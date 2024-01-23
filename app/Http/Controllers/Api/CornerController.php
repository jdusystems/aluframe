<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCornerRequest;
use App\Http\Requests\UpdateCornerRequest;
use App\Http\Resources\ClientCollection;
use App\Http\Resources\CornerCollection;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowCornerResource;
use App\Models\Corner;
use Illuminate\Http\Request;

class CornerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CornerCollection(Corner::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCornerRequest $request)
    {
        return new ShowCornerResource(Corner::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $corner = Corner::find($id);
        if(!$corner){
            return new ReturnResponseResource([
                'code' =>  404,
                'message' => "Record not found"
            ]);
        }
        return new ShowCornerResource($corner);
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCornerRequest $request, string $id)
    {
        $corner = Corner::find($id);
        if(!$corner){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found!'
            ]);
        }
        $corner->update([
            'name' => $request->name,
            'price' => $request->price,
            'vendor_code' => $request->vendor_code,
            'profile_type_id' => $request->profile_type_id
        ]);
        return new ShowCornerResource($corner);
    }
    public function deleteMultiple(Request $request){
        $ids = $request->json('ids');

        if (!empty($ids) && is_array($ids)) {
            Corner::whereIn('id', $ids)->delete();

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
        $corner = Corner::find($id);
        if(!$corner){
            return new ReturnResponseResource([
                'code' =>  404,
                'message' => "Record not found"
            ]);
        }
        $corner->delete();
        return new ReturnResponseResource([
            'code' => 200 ,
            'message' => 'Corner deleted successfully'
        ]);
    }
}
