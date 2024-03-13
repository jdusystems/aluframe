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
use Illuminate\Support\Facades\DB;

class ProfileTypeController extends Controller
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
        $profile_types = ProfileType::where('active',1)->orderBy('sort_index')->paginate($itemsPerPage);
        return new ProfileTypeCollection($profile_types);
    }

    public function all()
    {
        $profile_types = ProfileType::where('active',1)->get();
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
            'image_name' => $request->image_name ,
            'image_url' => $request->image_url ,
            'name' => $request->name ,
            'vendor_code' => $request->vendor_code ,
            'uz_name' => $request->uz_name ,
            'size_name' => $request->size_name ,
            'thickness' => $request->thickness ,
            'calculation_type_id' => $request->calculation_type_id ,
            'price' => $request->price ,
            'sort_index' => $request->sort_index
        ]);
        return new ShowProfileTypeResource($profileType);
    }



    public function deleteMultiple(Request $request){

        $request->validate([
            'ids' => 'required|array|min:1|exists:users,id' ,
        ]);
        $ids = $request->json('ids');

        if (!empty($ids) && is_array($ids)) {
            DB::table('profile_types')->whereIn('id' , $ids)->update(['active'=>0]);

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
        $profileType = ProfileType::find($id);
        if(!$profileType){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found"
            ]);
        }else{
            if($profileType->window_handler()->count() > 0 || $profileType->orderDetails()->count() > 0 || $profileType->profileColors()->count() > 0){
                return new ReturnResponseResource([
                    'code' => 422 ,
                    'message' => "You can not delete this Item!"
                ]);
            }
            $profileType->delete();

            return new ReturnResponseResource([
                'code' => 200 ,
                'message' => "Profile Type deleted successfully"
            ]);
        }
    }
}
