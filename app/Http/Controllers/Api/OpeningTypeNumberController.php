<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOpeningTypeNumberRequest;
use App\Http\Requests\UpdateOpeningTypeNumberRequest;
use App\Http\Resources\OpeningTypeNumberCollection;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowOpeningTypeNumberResource;
use App\Models\Image;
use App\Models\OpeningTypeNumber;
use Illuminate\Http\Request;

class OpeningTypeNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new OpeningTypeNumberCollection(OpeningTypeNumber::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOpeningTypeNumberRequest $request)
    {
        $openingTypNumber = OpeningTypeNumber::create([
            'opening_type_id' => $request->opening_type_id
        ]);
        return new ShowOpeningTypeNumberResource($openingTypNumber);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $openingTypeNumber = OpeningTypeNumber::find($id);
        if(!$openingTypeNumber){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ]);
        }
        return new ShowOpeningTypeNumberResource($openingTypeNumber);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOpeningTypeNumberRequest $request, string $id)
    {
        $openingTypeNumber = OpeningTypeNumber::find($id);
        if(!$openingTypeNumber){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ]);
        }
        $openingTypeNumber->update([
            'opening_type_id' => $request->opening_type_id
        ]);
        return new ShowOpeningTypeNumberResource($openingTypeNumber);
    }

    public function addImage(Request $request){
       $request->validate([
           'opening_type_number_id' => ['required','integer', 'exists:opening_type_numbers,id'] ,
           'image_name' => ['required' , 'string'],
           'image_url' => ['required' , 'string'],
           'number' => ['required' , 'integer' ,],
       ]);
       $openingTypeNumber = OpeningTypeNumber::find($request->opening_type_number_id);

       $image = Image::create([
           'number' => $request->number ,
           'image_name' => $request->image_name ,
           'image_url' => $request->image_url ,
           'opening_type_number_id' => $openingTypeNumber->id
       ]);

       return new ShowOpeningTypeNumberResource($openingTypeNumber);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $openingTypeNumber = OpeningTypeNumber::find($id);
        if(!$openingTypeNumber){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ]);
        }
        $images = Image::where('opening_type_number_id')->get();
        if(!$images){
            foreach ($images as $image){
                $image->delete();
            }
        }
        $openingTypeNumber->delete();
        return new ReturnResponseResource([
            'code' => 200 ,
            'Record has been deleted successfully!'
        ]);
    }
}
