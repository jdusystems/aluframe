<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HandlerTypeCollection;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowHandlerTypeResource;
use App\Models\HandlerType;
use Illuminate\Http\Request;

class HandlerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new HandlerTypeCollection(HandlerType::paginate(10));
    }
    public function all()
    {
        return new HandlerTypeCollection(HandlerType::all());
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $handler = HandlerType::find($id);
        if(!$handler){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ]);
        }
        return new ShowHandlerTypeResource($handler);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
