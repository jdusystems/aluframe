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

class HandlerPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new HandlerPositionCollection(HandlerPosition::paginate(10));
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
        return new ShowHandlerPositionResource(HandlerPosition::create($request->all()));
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
            'image_name' => $request->image_name ,
            'image_url' => $request->image_url
        ]);

        return new ShowHandlerPositionResource($handlerPosition);
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
        $handlerPosition->delete();
        return new ReturnResponseResource([
            'code' => 200 ,
            'message' => 'Record has been deleted successfully!'
        ]);
    }
}
