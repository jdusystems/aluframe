<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowOrderResource;
use App\Models\AdditionalService;
use App\Models\AssemblyService;
use App\Models\Corner;
use App\Models\HandlerType;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProfileType;
use App\Models\Sealant;
use App\Models\WindowColor;
use App\Models\WindowHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new OrderCollection(Order::latest()->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
     DB::beginTransaction();
        try{
            $startingOrderId = 1000;
            $lastOrderId = Order::max('order_id');
            $nextOrderId = $lastOrderId ? $lastOrderId + 1 : $startingOrderId;
            $order = Order::create([
                'order_id' => $nextOrderId,
                'client_id' => $request->client_id
            ]);
            $details = $request->input('orders');
            $totalPrice = 0;
            foreach ($details as $detail){
                $price = 0;
                $profileNumber = 0;
                if($detail['profile_type_id']){
                    $profileType = ProfileType::find($detail['profile_type_id']);
                    $profileNumber += 1;
                    if(array_key_exists('quantity_right' , $detail) && $detail['quantity_right'] > 0){
                        $profileNumber += $detail['quantity_right'];
                    }
                    if(array_key_exists('quantity_left' , $detail) && $detail['quantity_left'] > 0){
                        $profileNumber += $detail['quantity_left'];
                    }

                    $width = $detail['width']/1000;
                    $height = $detail['height']/1000;
                    $peremetr = 2*($width + $height) * $profileNumber;
                    $cornerQuantity = 4*$profileNumber;
                    $profilePeremetr = 0;
                    $sealantQuantity = $peremetr;
                    //
                    $windowHandlerQuantity = 0;

                    //
                    $surface = $profileNumber * ($width * $height);
                    if($profileType->sealant){
                        $sealant = Sealant::where('profile_type_id' , $profileType->id)->first();
                        $price += $peremetr*$sealant->price;
                    }
                    if($profileType->window_handler){
                        $windowHandler = WindowHandler::where('profile_type_id' , $profileType->id)->where('profile_color_id' , $detail['profile_color_id'])->first();
                        $handlerType = HandlerType::find($detail['handler_type_id']);
                        if($handlerType->slug == "no_handler"){
                            $windowHandlerQuantity += 0;
                            $profilePeremetr = $profilePeremetr + 2 * $width + 2 * $height;
                        }
                        if($handlerType->slug == "opposite"){
                            $price += $height*$windowHandler->price;
                            $windowHandlerQuantity = $height;
                            $profilePeremetr = $profilePeremetr + 2*$width + $height;
                        }
                        if($handlerType->slug == "top"){
                            $price += $width*$windowHandler->price;
                            $windowHandlerQuantity = $width;
                            $profilePeremetr = $profilePeremetr + 2*$height + $width;
                        }
                        if($handlerType->slug == "below"){
                            $price += $width*$windowHandler->price;
                            $windowHandlerQuantity = $width;
                            $profilePeremetr = $profilePeremetr + 2*$height + $width;
                        }
                        if($handlerType->slug == "round"){
                            $price += $peremetr*$windowHandler->price;
                            $windowHandlerQuantity = $peremetr;
                            $profilePeremetr += 0;
                        }
                    }
                    if($profileType->corner){
                        $corner = Corner::where('profile_type_id' , $profileType->id)->first();
                        $price += 4 * $profileNumber * $corner->price;
                    }
                    $price += $profileNumber*$profilePeremetr*$profileType->price;
                }
                if($detail['window_color_id']){
                    $windowColor = WindowColor::find($detail['window_color_id']);
                    $price += $surface * $windowColor->price;
                }
                if(array_key_exists('additional_service_id' ,$detail)){
                    $additionalService = AdditionalService::find($detail['additional_service_id']);
                    $price += $additionalService->price ;
                }
                if($height < 1.8){
                    $assemblyService = AssemblyService::where('facade_height' , 1800)->first();
                    $price += $assemblyService->price ;
                }elseif($height > 1.8){
                    $assemblyService = AssemblyService::where('facade_height' , 1800)->first();
                    $price += $assemblyService->price ;
                }

                OrderDetail::create([
                    'order_id' => $order->id ,
                    'profile_type_id' => $detail['profile_type_id'] ,
                    'window_color_id' => $detail['window_color_id'] ,
                    'profile_color_id' => $detail['profile_color_id'] ,
                    'opening_type_id' => $detail['opening_type_id'] ,
                    'handler_type_id' => $detail['opening_type_id'] ,
                    'additional_service_id' => (array_key_exists('additional_service_id' ,$detail)) ? $detail['additional_service_id'] : null ,
                    'assembly_service_id' => ($assemblyService) ? $assemblyService->id : null ,
                    'width' => $width ,
                    'height' => $height ,
                    'quantity_right' => (array_key_exists('quantity_right', $detail)) ? $detail['quantity_right'] : 0 ,
                    'quantity_left' => (array_key_exists('quantity_left' , $detail)) ? $detail['quantity_left'] : 0 ,
                    'number_of_loops' => ($detail['number_of_loops']) ? $detail['number_of_loops'] : 0 ,
                    'corner_quantity' =>  $cornerQuantity,
                    'sealant_quantity' =>  $sealantQuantity,
                    'window_handler_quantity' =>  $windowHandlerQuantity,
                    'status_id' =>  1,
                    'X1' => (array_key_exists('X1' , $detail)) ? $detail['X1'] : null ,
                    'X2' => (array_key_exists('X2' , $detail)) ? $detail['X2'] : null ,
                    'Y1' => (array_key_exists('Y1' , $detail)) ? $detail['Y1'] : null ,
                    'price' => $price
                ]);
                $totalPrice += $price;
            }
            if($totalPrice > 0){
                $order->update([
                    'total_price' => $totalPrice
                ]);
            }
            return new ShowOrderResource($order);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'error' => 'Error creating order and details: ' . $e->getMessage()
            ] , 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::find($id);
        if(!$order){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ]);
        }
        return new ShowOrderResource($order);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => ['required', 'integer' , "exists:statuses,id"],
        ]);
        $order = Order::find($id);
        if(!$order){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ]);
        }
        $order->update([
            'status_id' => $request->status
        ]);
        return new ShowOrderResource($order);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);
        if(!$order){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ]);
        }
        $order->orderDetails()->delete();
        $order->delete();
        return new ReturnResponseResource([
            'code' => 200 ,
            'message' => "Order and associated details deleted successfully."
        ]);
    }
}
