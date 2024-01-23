<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssemblyServiceRequest;
use App\Http\Requests\UpdateAssemblyServiceRequest;
use App\Http\Resources\AssemblyServiceCollection;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowAssemblyServiceResource;
use App\Models\AssemblyService;
use Illuminate\Http\Request;

class AssemblyServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new AssemblyServiceCollection(AssemblyService::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssemblyServiceRequest $request)
    {
        return new ShowAssemblyServiceResource(AssemblyService::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $assemblyService = AssemblyService::find($id);
        if(!$assemblyService){
            return new ReturnResponseResource([
                'code' =>  404 ,
                'message' => "Record not found"
            ]);
        }
        return new ShowAssemblyServiceResource($assemblyService);
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssemblyServiceRequest $request, string $id)
    {
        $assemblyService = AssemblyService::find($id);
        if(!$assemblyService){
            return new ReturnResponseResource([
                'code' =>  404 ,
                'message' => "Record not found"
            ]);
        }
        $assemblyService->update($request->all());

        return new ShowAssemblyServiceResource($assemblyService);
    }

    public function deleteMultiple(Request $request){
        $ids = $request->json('ids');

        if (!empty($ids) && is_array($ids)) {
            AssemblyService::whereIn('id', $ids)->delete();

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
        $assemblyService = AssemblyService::find($id);

        if(!$assemblyService){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found'
            ]);
        }
        if($assemblyService->orderDetails()->count() > 0){
            return new ReturnResponseResource([
                'code' => 422 ,
                'message' => "You can not delete this Item!"
            ]);
        }
        if ($assemblyService->delete()){
            return new ReturnResponseResource([
                'code' => 200 ,
                'message' => "Assembly Service deleted successfully"
            ]);
        }
    }
}
