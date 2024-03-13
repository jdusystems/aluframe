<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdditionalServiceRequest;
use App\Http\Requests\UpdateAdditionalServiceRequest;
use App\Http\Resources\AdditionalServiceCollection;
use App\Http\Resources\AdditionalServiceResource;
use App\Http\Resources\ReturnResponseResource;
use App\Models\AdditionalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class AdditionalServiceController extends Controller
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

        return new AdditionalServiceCollection(AdditionalService::where('active' , 1)->orderBy('sort_index')->paginate($itemsPerPage));
    }
    public function all()
    {
        return new AdditionalServiceCollection(AdditionalService::where('active',1)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdditionalServiceRequest $request)
    {
        return new AdditionalServiceResource(AdditionalService::create([
            'name' => $request->name,
            'uz_name' => $request->uz_name,
            'image_name' => $request->image_name ,
            'image_url' => $request->image_url,
            'sort_index' => $request->sort_index,
            'vendor_code' => $request->vendor_code,
            'price' => $request->price,
            'description' => $request->description ,
            'uz_description' => $request->uz_description
        ]));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $additionalService = AdditionalService::find($id);
        if (!$additionalService) {
            return new ReturnResponseResource([
                'code' => 404,
                'message' => 'Record not found.',
            ]);
        }
        return new AdditionalServiceResource($additionalService);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdditionalServiceRequest $request, string $id)
    {
        $additionalService = AdditionalService::find($id);
        if (!$additionalService) {
            return new ReturnResponseResource([
                'code' => 404,
                'message' => 'Record not found.',
            ]);
        }
        $request->validate([
            'vendor_code' => Rule::unique('additional_services')->ignore($additionalService->id),
        ]);

        $additionalService->update([
            'name' => $request->name,
            'uz_name' => $request->uz_name,
            'image_name' => $request->image_name ,
            'image_url' => $request->image_url,
            'sort_index' => $request->sort_index,
            'vendor_code' => $request->vendor_code,
            'price' => $request->price,
            'uz_description' => $request->uz_description
        ]);

        return new AdditionalServiceResource($additionalService);
    }

    public function deleteMultiple(Request $request){

        $request->validate([
            'ids' => 'required|array|min:1|exists:additional_services,id' ,
        ]);
        $ids = $request->json('ids');

        if (!empty($ids) && is_array($ids)) {
            DB::table('additional_services')->whereIn('id',$ids)->update(['active' => 0]);
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
        $additionalService = AdditionalService::find($id);

        if (!$additionalService) {
            return new ReturnResponseResource([
                'code' => 404,
                'message' => 'Record not found.',
            ]);
        }

        $additionalService->update(['active'=>0]);

        return new ReturnResponseResource([
            'code' => 200,
            'message' => 'Additional service deleted successfully'
        ]);
    }
}
