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
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class AdditionalServiceController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new AdditionalServiceCollection(AdditionalService::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdditionalServiceRequest $request)
    {

        return new AdditionalServiceResource(AdditionalService::create([
            'image_name' => $request->image_name ,
            'image_url' => $request->image_url,
            'name' => $request->name ,
            'vendor_code' => $request->vendor_code ,
            'price' => $request->price ,
            'sort_index' => $request->sort_index
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
            'image_name' => $request->image_name ,
            'image_url' => $request->image_url,
            'sort_index' => $request->sort_index,
            'vendor_code' => $request->vendor_code,
            'price' => $request->price
        ]);

        return new AdditionalServiceResource($additionalService);
    }

    public function deleteMultiple(Request $request){
        $ids = $request->json('ids');

        if (!empty($ids) && is_array($ids)) {
            AdditionalService::whereIn('id', $ids)->delete();
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
        $additionalService->delete();

        return new ReturnResponseResource([
            'code' => 200,
            'message' => 'Additional service deleted successfully'
        ]);
    }
}
