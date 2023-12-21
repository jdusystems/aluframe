<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOpeningTypeRequest;
use App\Http\Requests\UpdateOpeningTypeRequest;
use App\Http\Resources\OpeningTypeCollection;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowOpeningTypeResource;
use App\Models\OpeningType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OpeningTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new OpeningTypeCollection(OpeningType::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOpeningTypeRequest $request)
    {
        return new ShowOpeningTypeResource(
            OpeningType::create([
                'name' => $request->name ,
                'calculation_type_id' => $request->calculation_type_id ,
                 'sort_index' => $request->sort_index
            ])
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $openingType = OpeningType::find($id);
        if(!$openingType){
            return new ReturnResponseResource([
                'code' => 404,
                'message' => 'Record not found.',
            ]);
        }
        return new ShowOpeningTypeResource($openingType);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOpeningTypeRequest $request, string $id)
    {
        $openingType = OpeningType::find($id);
        if(!$openingType){
            return new ReturnResponseResource([
                'code' => 404,
                'message' => 'Record not found.',
            ]);
        }
        $openingType->update([
            'name' => $request->name ,
            'calculation_type_id' => $request->calculation_type_id ,
            'sort_index' => $request->sort_index
        ]);

        return new ShowOpeningTypeResource($openingType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $openingType = OpeningType::find($id);
        if(!$openingType){
            return new ReturnResponseResource([
                'code' => 404,
                'message' => 'Record not found.',
            ]);
        }
        if($openingType->delete()){
            return new ReturnResponseResource([
                'code' => 200,
                'message' => 'Opening type deleted successfully'
            ]);
        }
    }
}
