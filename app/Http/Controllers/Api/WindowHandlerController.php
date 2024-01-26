<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWindowHandlerRequest;
use App\Http\Requests\UpdateWindowHandlerRequest;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowWindowHandlerResource;
use App\Http\Resources\WindowHandlerCollection;
use App\Models\ProfileColor;
use App\Models\ProfileType;
use App\Models\WindowHandler;
use Illuminate\Http\Request;

class WindowHandlerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new WindowHandlerCollection(WindowHandler::paginate(10));
    }
        public function all()
        {
            return new WindowHandlerCollection(WindowHandler::all());
        }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWindowHandlerRequest $request)
    {
        if(ProfileType::find($request->profile_type_id)->window_handler()->exists() && ProfileColor::find($request->profile_color_id)->windowHandlers()->exists()){
            return new ReturnResponseResource([
                'code' => 422 ,
                'message' => "Record already exists!"
            ]);
        }
        return new ShowWindowHandlerResource(WindowHandler::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $windowHandler = WindowHandler::find($id);
        if(!$windowHandler){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found!'
            ]);
        }
        return new ShowWindowHandlerResource($windowHandler);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWindowHandlerRequest $request, string $id)
    {
        $windowHandler = WindowHandler::find($id);
        if(!$windowHandler){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found!'
            ]);
        }
        $windowHandler->update([
            'name' => $request->name,
            'vendor_code' => $request->vendor_code,
            'price' => $request->price,
            'profile_type_id' => $request->profile_type_id,
            'profile_color_id' => $request->profile_color_id,
        ]);

        return new ShowWindowHandlerResource($windowHandler);
    }


    public function deleteMultiple(Request $request){
        $ids = $request->json('ids');

        if (!empty($ids) && is_array($ids)) {
            WindowHandler::whereIn('id', $ids)->delete();

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
        $windowHandler = WindowHandler::find($id);
        if(!$windowHandler){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => 'Record not found!'
            ]);
        }
        $windowHandler->delete();
        return new ReturnResponseResource([
            'code' => 200 ,
            'message' => "Window Handler has been deleted successfully!"
        ]);
    }
}
