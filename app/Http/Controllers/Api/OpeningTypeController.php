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
use Illuminate\Support\Facades\Storage;
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
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOpeningTypeRequest $request)
    {

        if($request->hasFile('image')){
            $uploadedFile = $request->file('image');

            $imageName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
            $filePath = Storage::disk('uploads')->putFileAs('', $uploadedFile, $imageName);
        }
        return new ShowOpeningTypeResource(
            OpeningType::create([
                'name' => $request->name ,
                'calculation_type' => $request->calculation_type ,
                'sort_index' => $request->sort_index ,
                'image' => $filePath ,
                'price' => $request->price ,
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

        if($request->hasFile('image')) {
            // Delete the old image
            Storage::disk('uploads')->delete($openingType->image);
            // Upload the new image
            $uploadedFile = $request->file('image');
            $imageName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
            $filePath = Storage::disk('uploads')->putFileAs('', $uploadedFile, $imageName);
        }else{
            $filePath = $openingType->image;
        }

        $openingType->update([
            'name' => $request->name ,
            'calculation_type' => $request->calculation_type,
            'sort_index' => $request->sort_index ,
            'image' => $filePath ,
            'price' => $request->price ,
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
        Storage::disk('uploads')->delete($openingType->image);
        if($openingType->delete()){
            return new ReturnResponseResource([
                'code' => 200,
                'message' => 'Opening type deleted successfully'
            ]);
        }
    }
}
