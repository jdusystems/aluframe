<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfileColorRequest;
use App\Http\Requests\UpdateProfileColorRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\ProfileColorCollection;
use App\Http\Resources\ShowProfileColorResource;
use App\Http\Resources\SuccessResource;
use App\Models\ProfileColor;
use Illuminate\Http\Request;

class ProfileColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ProfileColorCollection(ProfileColor::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfileColorRequest $request)
    {
        return new ShowProfileColorResource(ProfileColor::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profileColor = ProfileColor::find($id);
        if(!$profileColor) {
                return new ErrorResource([
                    'code' => 404,
                    'message' => 'Record not found.',
                ]);
        }
        return new ShowProfileColorResource($profileColor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileColorRequest $request, string $id)
    {
        $profileColor = ProfileColor::find($id);

        $profileColor->update([
            'name' => $request->name,
            'image' => $request->image,
            'sort_index' => $request->sort_index,
            'color_from' => $request->color_from,
            'color_to' => $request->color_to
        ]);

        return new ShowProfileColorResource($profileColor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $profile_color = ProfileColor::find($id);

         if (!$profile_color) {
            return new ErrorResource([
                'code' => 404,
                'message' => 'Record not found.',
            ]);
         }
 
         $profile_color->delete();
 
         return new SuccessResource([
            'code' => 200,
            'message' => 'Resource deleted successfully'
         ]);
     
    }
}
