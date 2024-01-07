<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfileTypeRequest;
use App\Http\Requests\UpdateProfileTypeRequest;
use App\Http\Resources\ProfileTypeCollection;
use App\Http\Resources\ShowProfileTypeResource;
use App\Models\ProfileType;
use Illuminate\Http\Request;
use App\Http\Resources\ReturnResponseResource;

class ProfileTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile_types = ProfileType::paginate(10);
        return new ProfileTypeCollection($profile_types);
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfileTypeRequest $request)
    {
        return new ShowProfileTypeResource(ProfileType::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profileType = ProfileType::find($id);
        if (!$profileType) {
            return new ReturnResponseResource([
                'code' => 404,
                'message' => 'Record not found.',
            ]);
        }
        return new ShowProfileTypeResource($profileType);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileTypeRequest $request, string $id)
    {
        $profileType = ProfileType::find($id);
        if(!$profileType){
            return new ReturnResponseResource([
                'code' => 404,
                'message' => 'Record not found.',
            ]);
        }
        $profileType->update([
            'name' => $request->name ,
            'calculation_type' => $request->calculation_type ,
            'price' => $request->price ,
            'sort_index' => $request->sort_index
        ]);
        return new ShowProfileTypeResource($profileType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $profileType = ProfileType::find($id);
        if(!$profileType){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found"
            ]);
        }else{
            $profileType->delete();

            return new ReturnResponseResource([
                'code' => 200 ,
                'message' => "Profile Type deleted successfully"
            ]);
        }
    }
}
