<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWindowColorRequest;
use App\Http\Requests\UpdateWindowColorRequest;
use App\Http\Resources\ProfileColorCollection;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowWindowColorResource;
use App\Http\Resources\WindowColorCollection;
use App\Models\ProfileColor;
use App\Models\WindowColor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class WindowColorController extends Controller
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
        return new WindowColorCollection(WindowColor::where('active',1)->orderBy('sort_index')->paginate($itemsPerPage));
    }
    public function all()
    {
        return new WindowColorCollection(WindowColor::where('active' ,1)->latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWindowColorRequest $request)
    {
        // Image uploading is not working yet

        return new ShowWindowColorResource(WindowColor::create([
            'image_name' => $request->image_name ,
            'image_url' => $request->image_url ,
            'second_image_name' => $request->second_image_name ,
            'second_image_url' => $request->second_image_url ,
            'name' => $request->name ,
            'uz_name' => $request->uz_name ,
            'vendor_code' => $request->vendor_code ,
            'price' => $request->price ,
            'sort_index' => $request->sort_index ,
            'profile_color_id' => $request->profile_color_id
        ]));
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $windowColor = WindowColor::find($id);
        if (!$windowColor) {
            return new ReturnResponseResource([
                'code' => 404,
                'message' => 'Record not found.',
            ]);
        }
        return new ShowWindowColorResource($windowColor);
    }


    public function getByType(string $type_id){
        $profileColor = ProfileColor::find($type_id);
        if(!$profileColor){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found!'
            ] , 404);
        }
        $windowColors = WindowColor::where('profile_color_id' , $profileColor->id)->where('active' ,1)->get();
        return new WindowColorCollection($windowColors);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWindowColorRequest $request, string $id)
    {
        $windowColor = WindowColor::find($id);
        if(!$windowColor){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found!'
            ] , 404);
        }
//        $request->validate([
//            'vendor_code' => Rule::unique('window_colors')->ignore($windowColor->id),
//        ]);
        $vendor_code = $windowColor->vendor_code;

        DB::table('window_colors')->where('vendor_code' , $vendor_code)->update([
            'vendor_code' => $request->vendor_code ,
            'price' => $request->price ,
        ]);
        $windowColor->update([
            'name' => $request->name,
            'uz_name' => $request->uz_name ,
            'image_url' => $request->image_url,
            'image_name' => $request->image_name,
            'second_image_name' => $request->second_image_name ,
            'second_image_url' => $request->second_image_url ,
            'sort_index' => $request->sort_index ,
            'vendor_code' => $request->vendor_code,
            'price' => $request->price,
            'profile_color_id' => $request->profile_color_id
        ]);

        return new ShowWindowColorResource($windowColor);
    }
    public function deleteMultiple(Request $request){
        $request->validate([
            'ids' => 'required|array|min:1|exists:window_colors,id' ,
        ]);
        $ids = $request->json('ids');

        if (!empty($ids) && is_array($ids)) {
            DB::table('window_colors')->whereIn('id',$ids)->update(['active' => 0]);

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
        $windowColor = WindowColor::find($id);

        if (!$windowColor) {
            return new ReturnResponseResource([
                'code' => 404,
                'message' => 'Record not found.',
            ]);
        }
        $windowColor->update(['active'=>0]);

        return new ReturnResponseResource([
            'code' => 200,
            'message' => 'Window color deleted successfully'
        ]);
    }
}
