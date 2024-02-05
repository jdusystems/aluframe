<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfileColorRequest;
use App\Http\Requests\UpdateProfileColorRequest;
use App\Http\Resources\ProfileColorCollection;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowProfileColorResource;
use App\Models\ProfileColor;
use App\Models\ProfileType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
class ProfileColorController extends Controller
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
        return new ProfileColorCollection(ProfileColor::orderBy('sort_index')->paginate($itemsPerPage));
    }
    public function all()
    {
        return new ProfileColorCollection(ProfileColor::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfileColorRequest $request)
    {
        $profileColor = ProfileColor::create([
            'image_name' => $request->image_name,
            'image_url' => $request->image_url,
            'name' => $request->name,
            'sort_index' => $request->sort_index,
            'color_from' => $request->color_from,
            'color_to' => $request->color_to ,
            'profile_type_id' => $request->profile_type_id,
        ]);
        // Image uploading is not working yet
        return new ShowProfileColorResource($profileColor);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profileColor = ProfileColor::find($id);
        if (!$profileColor) {
            return new ReturnResponseResource([
                'code' => 404,
                'message' => 'Record not found.',
            ]);
        }
        return new ShowProfileColorResource($profileColor);
    }

    public function getByType(string $type_id){
       $profile =  ProfileType::find($type_id);
        if(!$profile){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found!'
            ] , 404);
        }
        $profileColors = ProfileColor::where('profile_type_id' , $profile->id)->get();
        return new ProfileColorCollection($profileColors);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileColorRequest $request, string $id)
    {
        $profileColor = ProfileColor::find($id);
        if(!$profileColor){
            return new ReturnResponseResource([
                'code' => 404,
                'message' => 'Record not found.',
            ]);
        }
        $profileColor->update([
            'image_name' => $request->image_name,
            'image_url' => $request->image_url,
            'name' => $request->name,
            'sort_index' => $request->sort_index,
            'color_from' => $request->color_from,
            'color_to' => $request->color_to ,
            'profile_type_id' => $request->profile_type_id,
        ]);

        return new ShowProfileColorResource($profileColor);
    }


    public function deleteMultiple(Request $request){
        $ids = $request->json('ids');
        if (!empty($ids) && is_array($ids)) {
            ProfileColor::whereIn('id', $ids)->delete();

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
        $profile_color = ProfileColor::find($id);

        if (!$profile_color) {
            return new ReturnResponseResource([
                'code' => 404,
                'message' => 'Record not found.',
            ]);
        }
        if($profile_color->windowHandlers()->count() > 0 || $profile_color->orderDetails()->count() > 0 ){
            return new ReturnResponseResource([
                'code' => 422 ,
                'message' => "You can not delete this Item!"
            ]);
        }
        Storage::disk('uploads')->delete($profile_color->image_name);
        $profile_color->delete();

        return new ReturnResponseResource([
            'code' => 200,
            'message' => 'Profile color deleted successfully'
        ]);
    }
}
