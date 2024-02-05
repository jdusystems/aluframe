<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowTypeResource;
use App\Http\Resources\TypeCollection;
use App\Models\Type;
use Illuminate\Http\Request;


class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'per_page' => ['required','numeric']
        ]);
        $itemsPerPage = $request->per_page;
        return new TypeCollection(Type::paginate($itemsPerPage));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTypeRequest $request)
    {
        return new ShowTypeResource(Type::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $type = Type::find($id);
        if(!$type){
            return new ReturnResponseResource([
                'code' =>404 ,
                'message' => "Record not found!"
            ]);
        }
        return new ShowTypeResource($type);
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypeRequest $request, Type $type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        //
    }
}
