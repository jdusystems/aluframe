<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSealantRequest;
use App\Http\Requests\UpdateSealantRequest;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\SealantCollection;
use App\Http\Resources\ShowSealantResource;
use App\Models\Sealant;
use Illuminate\Http\Request;

class SealantController extends Controller
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
        return new SealantCollection(Sealant::paginate($itemsPerPage));
    }
        public function all()
        {
            return new SealantCollection(Sealant::all());
        }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSealantRequest $request)
    {
        $sealant = Sealant::create([
            'name' => $request->name ,
            'uz_name' => $request->uz_name ,
            'vendor_code' => $request->vendor_code ,
            'price' => $request->price ,
            'profile_type_id' => $request->profile_type_id
        ]);
        return new ShowSealantResource($sealant);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sealant  = Sealant::find($id);

        if(!$sealant){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found'
            ]);
        }
        return new ShowSealantResource($sealant);

    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSealantRequest $request, string $id)
    {
        $sealant  = Sealant::find($id);

        if(!$sealant){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found'
            ]);
        }
        $sealant->update([
            'name' => $request->name ,
            'uz_name' => $request->uz_name ,
            'vendor_code' => $request->vendor_code ,
            'price' => $request->price ,
            'profile_type_id' => $request->profile_type_id
        ]);

        return new ShowSealantResource($sealant);
    }
    public function deleteMultiple(Request $request){
        $ids = $request->json('ids');

        if (!empty($ids) && is_array($ids)) {
            Sealant::whereIn('id', $ids)->delete();
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
        $sealant  = Sealant::find($id);

        if(!$sealant){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found'
            ]);
        }
        $sealant->delete();
        return new ReturnResponseResource([
            'code' => 200 ,
            'message' => 'Sealant has been deleted successfully!'
        ]);

    }
}
