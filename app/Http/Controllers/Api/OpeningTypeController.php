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
        return new ShowOpeningTypeResource(
            OpeningType::create([
                'name' => $request->name ,
                'type_id' => $request->type_id ,
                'sort_index' => $request->sort_index ,
                'image_name' => $request->image_name ,
                'image_url' => $request->image_url ,
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

        $openingType->update([
            'name' => $request->name ,
            'type_id' => $request->type_id,
            'sort_index' => $request->sort_index ,
            'image_url' => $request->image_url ,
            'image_name' => $request->image_name ,
            'price' => $request->price ,
        ]);

        return new ShowOpeningTypeResource($openingType);
    }


    public function deleteMultiple(Request $request){
        $ids = $request->json('ids');

        if (!empty($ids) && is_array($ids)) {
            OpeningType::whereIn('id', $ids)->delete();

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
        $openingType = OpeningType::find($id);
        if(!$openingType){
            return new ReturnResponseResource([
                'code' => 404,
                'message' => 'Record not found.',
            ]);
        }
        Storage::disk('uploads')->delete($openingType->image_name);
        if($openingType->delete()){
            return new ReturnResponseResource([
                'code' => 200,
                'message' => 'Opening type deleted successfully'
            ]);
        }
    }
}
