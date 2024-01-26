<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOpeningTypeRequest;
use App\Http\Requests\UpdateOpeningTypeRequest;
use App\Http\Resources\OpeningTypeCollection;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowOpeningTypeResource;
use App\Models\OpeningType;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use function PHPUnit\Framework\isEmpty;

class OpeningTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new OpeningTypeCollection(OpeningType::paginate(10));
    }

    public function getByType(string $type_id){
        $type = Type::find($type_id);
        if(!$type){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found!'
            ] , 404);
        }
        $openingTypes = OpeningType::where('type_id' , $type_id)->get();
        return new OpeningTypeCollection($openingTypes);
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOpeningTypeRequest $request)
    {
        $openingType = OpeningType::create([
            'name' => $request->name ,
            'type_id' => $request->type_id ,
            'sort_index' => $request->sort_index ,
            'image_name' => $request->image_name ,
            'image_url' => $request->image_url ,
            'price' => $request->price ,
        ]);
        if($request->handler_positions){
            $openingType->handlerPositions()->attach($request->handler_positions);
        }
        return new ShowOpeningTypeResource($openingType);
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
        if($request->handler_positions){
            $openingType->handlerPositions()->sync($request->handler_positions);
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
        if($openingType->orderDetails()->count() > 0 || $openingType->openingTypeNumbers()->count() > 0 ){
            return new ReturnResponseResource([
                'code' => 422 ,
                'message' => "You can not delete this Item!"
            ]);
        }

        $openingType->handlerPositions()->detach();
        if($openingType->delete()){
            return new ReturnResponseResource([
                'code' => 200,
                'message' => 'Opening type deleted successfully'
            ]);
        }
    }
}
