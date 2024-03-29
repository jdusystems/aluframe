<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOpeningTypeNumberRequest;
use App\Http\Requests\UpdateOpeningTypeNumberRequest;
use App\Http\Resources\OpeningTypeNumberCollection;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowOpeningTypeNumberResource;
use App\Models\Image;
use App\Models\OpeningType;
use App\Models\OpeningTypeNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpeningTypeNumberController extends Controller
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
        return new OpeningTypeNumberCollection(OpeningTypeNumber::paginate($itemsPerPage));
    }
    public function all()
    {
        return new OpeningTypeNumberCollection(OpeningTypeNumber::all());
    }

    public function getByOpeningType(string $type_id){
        $openingType = OpeningType::find($type_id);
        if(!$openingType){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found!'
            ] , 404);
        }
        $openingTypeNumbers = OpeningTypeNumber::where('opening_type_id' , $openingType->id)->get();
        return new OpeningTypeNumberCollection($openingTypeNumbers);
    }
    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOpeningTypeNumberRequest $request)
    {
        $openingTypeNumber = OpeningTypeNumber::create([
            'opening_type_id' => $request->opening_type_id ,
        ]);
        if($request->numbers){
            foreach ($request->input('numbers') as $number){
                Image::create([
                    'opening_type_number_id' => $openingTypeNumber->id ,
                    'number' => $number['number'],
                    'image_name' => $number['image_name'] ,
                    'image_url' => $number['image_url'] ,
                ]);
            }
        }

        return new ShowOpeningTypeNumberResource($openingTypeNumber);
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
        if ($openingTypeNumber->images){
            DB::table('images')->where('opening_type_number_id' , $openingTypeNumber->id)->delete();
        }
        $numbers = $request->input('numbers');

        if($numbers){
            foreach ($numbers as $number){
                Image::create([
                    'opening_type_number_id' => $openingTypeNumber->id ,
                    'number' => $number['number'],
                    'image_name' => $number['image_name'] ,
                    'image_url' => $number['image_url'] ,
                ]);
            }
        }
        $openingTypeNumber->update([
            'opening_type_id' => $request->opening_type_id ,
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
       DB::table('images')->where('opening_type_number_id' , $openingTypeNumber->id)->delete();
        $openingTypeNumber->delete();
        return new ReturnResponseResource([
            'code' => 200 ,
            'message' => 'Record has been deleted successfully!'
        ]);
    }
}
