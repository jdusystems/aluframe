<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Http\Resources\CurrencyCollection;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowCurrencyResource;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CurrencyCollection(Currency::paginate(10));
    }
    public function allData()
    {
        return new CurrencyCollection(Currency::all());
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCurrencyRequest $request)
    {
        return new ShowCurrencyResource(Currency::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $currency = Currency::find($id);
        if(!$currency){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found!'
            ]);
        }

        return new ShowCurrencyResource($currency);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCurrencyRequest $request, string $id)
    {
        $currency = Currency::find($id);
        if(!$currency){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found!'
            ]);
        }

        $currency->update([
            'name' => $request->name ,
            'rate' => $request->rate
        ]);

        return new ShowCurrencyResource($currency);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $currency = Currency::find($id);
        if(!$currency){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found!'
            ]);
        }
        if($currency->orders()->count() > 0 ){
            return new ReturnResponseResource([
                'code' => 422 ,
                'message' => "You can not delete this Item!"
            ]);
        }
        $currency->delete();
        return new ReturnResponseResource([
            'code' => 200,
            'message' => 'Additional service deleted successfully'
        ]);
    }
}
