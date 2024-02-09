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
use App\Models\HandlerPosition;
use App\Models\HandlerType;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProfileColor;
use App\Models\ProfileType;
use App\Models\Sealant;
use App\Models\Status;
use App\Models\WindowColor;
use App\Models\WindowHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
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
        $user = Auth::user();
        if($user->is_admin == 1){
            $orders = Order::latest()->paginate($itemsPerPage);
        }else{
            $orders = Order::where('user_id' , $user->id)->latest()->paginate($itemsPerPage);
        }
        return new OrderCollection($orders);
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
        try {
            $startingOrderId = 1000;
            $lastOrderId = Order::max('order_id');
            $nextOrderId = $lastOrderId ? $lastOrderId + 1 : $startingOrderId;
            $status = Status::where('slug' , 'pending')->first();
            $order = Order::create([
                'order_id' => $nextOrderId,
                'user_id' => $request->user_id ,
                'status_id' => $status->id
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
                        $sealant = Sealant::where('profile_type_id' , $profileType->id)->whereNull('deleted_at')->first();
                        $price += $peremetr*$sealant->price;
                    }
                    if($profileType->window_handler){
                        $windowHandler = WindowHandler::where('profile_type_id' , $profileType->id)->where('profile_color_id' , $detail['profile_color_id'])->whereNull('deleted_at')->first();
                        $handlerPosition = HandlerPosition::find($detail['handler_position_id']);
                        if($handlerPosition->slug == "no_handler"){
                            $windowHandlerQuantity += 0;
                            $profilePeremetr = $profilePeremetr + 2 * $width + 2 * $height;
                        }
                        if($windowHandler){
                            if($handlerPosition->slug == "opposite"){
                                $price += $height*$windowHandler->price;
                                $windowHandlerQuantity = $height;
                                $profilePeremetr = $profilePeremetr + 2*$width + $height;
                            }
                            if($handlerPosition->slug == "top"){
                                $price += $width*$windowHandler->price;
                                $windowHandlerQuantity = $width;
                                $profilePeremetr = $profilePeremetr + 2*$height + $width;
                            }
                            if($handlerPosition->slug == "below"){
                                $price += $width*$windowHandler->price;
                                $windowHandlerQuantity = $width;
                                $profilePeremetr = $profilePeremetr + 2*$height + $width;
                            }
                            if($handlerPosition->slug == "round"){
                                $price += $peremetr*$windowHandler->price;
                                $windowHandlerQuantity = $peremetr;
                                $profilePeremetr += 0;
                            }
                        }else{
                            return new ReturnResponseResource([
                                'code' => 404 ,
                                'message' => 'Window handler not found!'
                            ]  , 404);
                        }
                    }
                    if($profileType->corner){
                        $corner = Corner::where('profile_type_id' , $profileType->id)->whereNull('deleted_at')->first();
                        if($corner){
                            $price += 4 * $profileNumber * $corner->price;
                        }
                    }
                    $price += $profileNumber*$profilePeremetr*$profileType->price;
                }
                if($detail['window_color_id']){
                    $windowColor = WindowColor::find($detail['window_color_id']);
                    if($windowColor){
                        $price += $surface * $windowColor->price*$profileNumber;
                    }
                }
                if(array_key_exists('additional_service_id' ,$detail)){
                    $additionalService = AdditionalService::find($detail['additional_service_id']);
                    if($additionalService){
                        $price += $additionalService->price ;
                    }
                }
                // Mana shu joyini ko'rish kerak balandlik yoki peremetr assembly service
                $p = 2*($width + $height);
                if($p >= 1.8 && $p < 2.4){
                    $assemblyService = AssemblyService::where('facade_height' , 1800)->first();
                    if($assemblyService){
                        $price += $assemblyService->price*$profileNumber;
                    }
                }elseif($p >=2.4){
                    $assemblyService = AssemblyService::where('facade_height' , 2400)->first();
                    if($assemblyService){
                        $price += $assemblyService->price*$profileNumber;
                    }
                }
                OrderDetail::create([
                    'order_id' => $order->id ,
                    'profile_type_id' => $detail['profile_type_id'] ,
                    'window_color_id' => $detail['window_color_id'] ,
                    'profile_color_id' => $detail['profile_color_id'] ,
                    'opening_type_id' => $detail['opening_type_id'] ,
                    'handler_position_id' => $detail['handler_position_id'] ,
                    'additional_service_id' => (array_key_exists('additional_service_id' ,$detail)) ? $detail['additional_service_id'] : null ,
                    'assembly_service_id' => ($assemblyService) ? $assemblyService->id : null ,
                    'width' => $width ,
                    'height' => $height ,
                    'quantity_right' => (array_key_exists('quantity_right', $detail)) ? $detail['quantity_right'] : 0 ,
                    'quantity_left' => (array_key_exists('quantity_left' , $detail)) ? $detail['quantity_left'] : 0 ,
                    'number_of_loops' => ($detail['number_of_loops']) ? $detail['number_of_loops'] : 0 ,
                    'comment' => ($detail['comment']) ? $detail['comment'] : " " ,
                    'corner_quantity' =>  $cornerQuantity,
                    'sealant_quantity' =>  $sealantQuantity,
                    'window_handler_quantity' =>  $windowHandlerQuantity,
                    'status_id' =>  1,
                    'X1' => (array_key_exists('X1' , $detail)) ? $detail['X1'] : 100 ,
                    'X2' => (array_key_exists('X2' , $detail)) ? $detail['X2'] : 100 ,
                    'Y1' => (array_key_exists('Y1' , $detail)) ? $detail['Y1'] : 100 ,
                    'price' => $price
                ]);
                $totalPrice += $price;
            }
            if($totalPrice > 0){
                $order->update([
                    'total_price' => $totalPrice
                ]);
            }
            DB::commit();
            return new ShowOrderResource($order);

        }catch (\Exception $e){
            DB::rollBack();

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

    public function getOrderPrice(Request $request){

        $totalPrice = 0;
        $profilePrice = 0;
        $windowPrice = 0;
        $cornerPrice = 0;
        $sealantPrice = 0;
        $windowHandlerPrice = 0;
        $additionalServicePrice = 0;
        $assemblyServicePrice = 0;
        $profilePerimeter = 0;

        $width = 0;
        $height = 0;

        if($request->has('width') && $request->has('height')){
            $width = $request->width/1000;
            $height = $request->height/1000;
        }else{
            $price = 0;
            if($request->has('profile_type_id')){
                $profileType = ProfileType::find($request->profile_type_id);
                $price += $profileType->price;
            }
            if($request->has('window_color_id')){
                $windowColor = WindowColor::find($request->window_color_id);
                $price += $windowColor->price;
            }
            return response()->json([
                'total_price' => $price
            ]);
        }
        $profileNumber = 1;
        if($request->has('quantity_left')){
            $profileNumber += $request->quantity_left;
        }
        if($request->has('quantity_right')){
            $profileNumber += $request->quantity_right;
        }
        $perimeter = 2*($width + $height);

        if($request->has('profile_type_id')){
            $profileType = ProfileType::find($request->profile_type_id);
            if($profileType){
                if($profileType->selant){
                    return response()->json([
                        'data' => "Keldi",
                    ]);
                    $sealant  = Sealant::where('profile_type_id' , $profileType->id)->whereNull('deleted_at')->first();
                    if($sealant){
                        $sealantPrice += 2*($height + $width)*$sealant->price*$profileNumber;
                    }
                }
                if($profileType->corner){
                    $corner = Corner::where('profile_type_id' , $profileType->id)->whereNull('deleted_at')->first();
                    if($corner){
                        $cornerPrice += $corner->price*4*$profileNumber;
                    }
                }
                if($request->has('handler_position_id')){
                    if($profileType->window_handler){
                            if($request->has('profile_color_id')){
                                $profileColor = ProfileColor::where('id',$request->profile_color_id)->whereNull('deleted_at')->first();
                                if($profileColor){
                                    $handlerPosition = HandlerPosition::find($request->handler_position_id);
                                    $windowHandler = WindowHandler::where('profile_type_id' , $profileType->id)->where('profile_color_id' , $profileColor->id)->whereNull('deleted_at')->first();
                                    if($handlerPosition && $windowHandler){

                                        if($handlerPosition->slug =="no_handler"){
                                            $profilePerimeter = $profilePerimeter + 2*($width + $height);
                                        }
                                        if($handlerPosition->slug =="opposite"){
                                         $profilePerimeter = $profilePerimeter + 2*$width + $height;
                                         $windowHandlerPrice += $height*$windowHandler->price*$profileNumber;
                                        }
                                        if($handlerPosition->slug=="top"){
                                            $profilePerimeter = $profilePerimeter + 2*$height + $width;
                                            $windowHandlerPrice =+ $width*$windowHandler->price*$profileNumber;
                                        }
                                        if($handlerPosition->slug == "below"){
                                            $profilePerimeter = $profilePerimeter +  2*$height + $width;
                                            $windowHandlerPrice += $width*$windowHandler->price*$profileNumber;
                                        }
                                        if($handlerPosition->slug=="round"){
                                            $profilePerimeter += 0;
                                            $windowHandlerPrice += 2*($width + $height)*$profileNumber*$windowHandler->price;
                                        }
                                    }
                                }
                            }
                    }
                }
                else{
                    $profilePerimeter = 2*($width + $height);
                }
            }
                $profilePrice = $profileNumber * $profileType->price*$profilePerimeter;
                $profilePrice = $profilePrice + $sealantPrice + $cornerPrice + $windowHandlerPrice;
        }
        if($request->has('window_color_id')){
            $windowColor = WindowColor::find($request->window_color_id);
            if($windowColor){
                $windowPrice = $windowPrice + $profileNumber*$width*$height*$windowColor->price;
            }
        }
        if($request->has('additional_service_id')){
            $additionalService = AdditionalService::find($request->additional_service_id);
            if($additionalService){
                $additionalServicePrice += $additionalService->price;
            }
        }
        if($perimeter >= 1.8 && $perimeter < 2.4){
            $assemblyService = AssemblyService::where('facade_height' , 1800)->first();
            if($assemblyService){
                $assemblyServicePrice += $assemblyService->price*$profileNumber;
            }
        }elseif($perimeter >=2.4){
            $assemblyService = AssemblyService::where('facade_height' , 2400)->first();
            if($assemblyService){
                $assemblyServicePrice += $assemblyService->price*$profileNumber;
            }
        }

        $totalPrice += $sealantPrice + $cornerPrice+$windowHandlerPrice+$profilePrice+$windowPrice+$additionalServicePrice+$assemblyServicePrice;

        return response()->json([
            'totalPrice' => $totalPrice ,
            'sealant_price' => $sealantPrice ,
            'corner_price' => $cornerPrice ,
            'window_handler_price' =>$windowHandlerPrice ,
            'profile_price' => $profilePrice ,
            'window_price' => $windowPrice ,
            'additional_service_price' => $additionalServicePrice ,
            'assembly_service_price' => $assemblyServicePrice
        ]);
    }

}
