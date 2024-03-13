<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHandlerPositionRequest;
use App\Http\Requests\UpdateHandlerPositionRequest;
use App\Http\Resources\HandlerPositionCollection;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowHandlerPositionResource;
use App\Models\HandlerPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HandlerPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->exists('per_page')){
            $itemsPerPage = $request->per_page;
        }else{
            $itemsPerPage = 10;
        }
        return new HandlerPositionCollection(HandlerPosition::where('active',1)->orderBy('sort_index')->paginate($itemsPerPage));
    }
    public function all()
    {
        $handlerPositions = HandlerPosition::where('active',1)->orderBy('sort_index')->get();
        return new HandlerPositionCollection($handlerPositions);
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
    public function store(StoreHandlerPositionRequest $request)
    {
        $handlerPosition = HandlerPosition::create([
            'name' => $request->name ,
            'uz_name' => $request->uz_name ,
            'image_name' => $request->image_name ,
            'image_url' => $request->image_url ,
            'sort_index' => $request->sort_index
        ]);
        return new ShowHandlerPositionResource($handlerPosition);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $handlerPosition = HandlerPosition::find($id);
        if(!$handlerPosition){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found!'
            ]);
        }
        return new ShowHandlerPositionResource($handlerPosition);
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHandlerPositionRequest $request, string $id)
    {
        $handlerPosition = HandlerPosition::find($id);
        if(!$handlerPosition){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found!'
            ]);
        }
        $handlerPosition->update([
            'name' => $request->name ,
            'uz_name' => $request->uz_name ,
            'image_name' => $request->image_name ,
            'image_url' => $request->image_url ,
            'sort_index' => $request->sort_index
        ]);

        return new ShowHandlerPositionResource($handlerPosition);
    }
    public function deleteMultiple(Request $request){
        $request->validate([
            'ids' => 'required|array|min:1|exists:handler_positions,id' ,
        ]);
        $ids = $request->json('ids');

        if (!empty($ids) && is_array($ids)) {
            DB::table('handler_positions')->whereIn('id',$ids)->update(['active' => 0]);
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
        $handlerPosition = HandlerPosition::find($id);
        if(!$handlerPosition){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found!'
            ]);
        }
        $handlerPosition->update(['active'=>0]);
        return new ReturnResponseResource([
            'code' => 200 ,
            'message' => 'Record has been deleted successfully!'
        ]);
    }
}
