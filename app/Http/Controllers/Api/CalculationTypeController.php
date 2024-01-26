<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCalculationTypeRequest;
use App\Http\Requests\UpdateCalculationTypeRequest;
use App\Http\Resources\CalculationTypeCollection;
use App\Http\Resources\CalculationTypeResource;
use App\Http\Resources\ReturnResponseResource;
use App\Models\CalculationType;
use Illuminate\Http\Request;

class CalculationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CalculationTypeCollection(CalculationType::paginate(10));
    }

    public function all()
    {
        return new CalculationTypeCollection(CalculationType::all());
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
    public function store(StoreCalculationTypeRequest $request)
    {
        return new CalculationTypeResource(CalculationType::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $calculationType = CalculationType::find($id);
        if (!$calculationType){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found"
            ]);
        }

        return new CalculationTypeResource($calculationType);
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
    public function update(UpdateCalculationTypeRequest $request, string $id)
    {
        $calculationType = CalculationType::find($id);
        if (!$calculationType){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found"
            ]);
        }
        $calculationType->update([
            'name' => $request->name ,
        ]);
        return new CalculationTypeResource($calculationType);
    }


    public function deleteMultiple(Request $request){
        $ids = $request->json('ids');

        if (!empty($ids) && is_array($ids)) {
            CalculationType::whereIn('id', $ids)->delete();

            return response()->json(['message' => 'Records deleted successfully.'], 200);
        } else {
            return response()->json(['error' => 'Invalid or empty IDs provided.'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $calculationType = CalculationType::find($id);

        if(!$calculationType){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found'
            ]);
        }
        if($calculationType->profiles()->count() > 0){
            return new ReturnResponseResource([
                'code' => 422 ,
                'message' => "You can not delete this Item!"
            ]);
        }
        if ($calculationType->delete()){
            return new ReturnResponseResource([
                'code' => 200 ,
                'message' => "Calculation type deleted successfully"
            ]);
        }
    }
}
