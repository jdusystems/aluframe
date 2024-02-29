<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetOrderDetailRequest;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowOrderResource;
use App\Models\AdditionalService;
use App\Models\AssemblyService;
use App\Models\Corner;
use App\Models\Currency;
use App\Models\HandlerPosition;
use App\Models\OpeningType;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProfileColor;
use App\Models\ProfileType;
use App\Models\Sealant;
use App\Models\Status;
use App\Models\User;
use App\Models\WindowColor;
use App\Models\WindowHandler;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{

    public function exportPdf1(string $id){
        $order = Order::find($id);
        if(!$order || $order->orderDetails()->count()  == 0){
            return  new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ] , 404);
        }
        $orderDetails = $order->orderDetails;

        $profiles = OrderDetail::select('profile_type_id' ,
            DB::raw('SUM(height) as total_height') ,
            DB::raw('SUM(width) as total_width'),
            DB::raw('SUM(facade_quantity) as total_facade_quantity'),
            DB::raw('SUM(sealant_quantity) as total_sealant_length'),
            DB::raw('SUM(corner_quantity) as total_corner_quantity'),
            DB::raw('SUM(window_handler_quantity) as total_window_handler_quantity'),
            DB::raw('SUM(profile_length) as total_profile_length'),
        )->groupBy('profile_type_id')->where('order_id' , $order->id)->get();
//        return response()->json([
//            'data' => $profiles ,
//            'details' => $orderDetails
//        ]);
        $windowColors = OrderDetail::select('window_color_id' ,
            DB::raw('SUM(surface) as total_surface'),
            DB::raw('SUM(facade_quantity) as total_facade_quantity'),
        )->groupBy('window_color_id')->where('order_id' , $order->id)->get();

        $additionalServices = OrderDetail::select('additional_service_id' ,
            DB::raw('SUM(surface) as total_surface')
        )->groupBy('additional_service_id')->where('order_id' , $order->id)->get();

        $assemblyServices = OrderDetail::select('assembly_service_id' ,
            DB::raw('SUM(facade_quantity) as total_facade_quantity') ,
        )->groupBy('assembly_service_id')->where('order_id' , $order->id)->get();

        $user = User::find($order->user_id);

        $filename = 'invoice1_' . $order->order_id . '.pdf';

        if (Storage::disk('pdf')->exists($filename)) {
            // If the file exists, return its URL
            $url = url(Storage::url($filename));
            return response()->json(['pdf' => $url]);
        }
        $pdf = Pdf::loadView('pdf.pdf1' , ['order' => $order, 'orderDetails' => $orderDetails ,
            'profiles' => $profiles , 'windowColors' => $windowColors , 'user' => $user ,
            'additionalServices' => $additionalServices , 'assemblyServices' => $assemblyServices
        ]);
        $pdfContents = $pdf->output();

        Storage::disk('pdf')->put($filename , $pdfContents);
        $url = url(Storage::url($filename));
        return response()->json(
            [
                'pdf' => $url ,
            ]);
    }

    public function exportPdf2(string $id){
        $order = Order::find($id);
        if(!$order || $order->orderDetails()->count()  == 0){
            return  new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ] , 404);
        }
        $orderDetails = $order->orderDetails;

        $profiles = OrderDetail::select('profile_type_id' ,
            DB::raw('SUM(height) as total_height') ,
            DB::raw('SUM(width) as total_width'),
            DB::raw('SUM(facade_quantity) as total_facade_quantity'),
            DB::raw('SUM(sealant_quantity) as total_sealant_length'),
            DB::raw('SUM(corner_quantity) as total_corner_quantity'),
            DB::raw('SUM(window_handler_quantity) as total_window_handler_quantity'),
            DB::raw('SUM(profile_length) as total_profile_length'),
        )->groupBy('profile_type_id')->where('order_id' , $order->id)->get();

        $windowColors = OrderDetail::select('window_color_id' ,
            DB::raw('SUM(surface) as total_surface'),
            DB::raw('SUM(facade_quantity) as total_facade_quantity'),
        )->groupBy('window_color_id')->where('order_id' , $order->id)->get();

        $additionalServices = OrderDetail::select('additional_service_id' ,
            DB::raw('SUM(surface) as total_surface')
        )->groupBy('additional_service_id')->where('order_id' , $order->id)->get();

        $assemblyServices = OrderDetail::select('assembly_service_id' ,
            DB::raw('SUM(facade_quantity) as total_facade_quantity') ,
        )->groupBy('assembly_service_id')->where('order_id' , $order->id)->get();

        $user = User::find($order->user_id);

        $filename = 'invoice2_' . $order->order_id . '.pdf';

        if (Storage::disk('pdf')->exists($filename)) {
            // If the file exists, return its URL
            $url = url(Storage::url($filename));
            return response()->json(['pdf' => $url]);
        }
        $pdf = Pdf::loadView('pdf.pdf2' , ['order' => $order, 'orderDetails' => $orderDetails ,
            'profiles' => $profiles , 'windowColors' => $windowColors , 'user' => $user ,
            'additionalServices' => $additionalServices , 'assemblyServices' => $assemblyServices
        ]);
        $pdfContents = $pdf->output();

        Storage::disk('pdf')->put($filename , $pdfContents);
        $url = url(Storage::url($filename));
        return response()->json(
            [
                'pdf' => $url ,
            ]);
    }
    public function exportPdf3(string $id){
        $order = Order::find($id);
        if(!$order){
            return  new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ] , 404);
        }

        $orderDetails = $order->orderDetails;
        $profiles = OrderDetail::select('profile_type_id' ,
            DB::raw('SUM(height) as total_height') ,
            DB::raw('SUM(width) as total_width') ,
            DB::raw('SUM(facade_quantity) as total_facade_quantity'),
        )->groupBy('profile_type_id')->where('order_id' , $order->id)->get();

        $windowColors = OrderDetail::select('window_color_id' ,
            DB::raw('SUM(facade_quantity) as total_facade_quantity') ,
            DB::raw('SUM(height) as total_height') ,
            DB::raw('SUM(width) as total_width') ,
            DB::raw('SUM(surface) as total_surface'),
        )->groupBy('window_color_id')->where('order_id' , $order->id)->get();

        $filename = 'invoice3_' . $order->order_id . '.pdf';

        if (Storage::disk('pdf')->exists($filename)) {
            // If the file exists, return its URL
            $url = url(Storage::url($filename));
            return response()->json(['pdf' => $url]);
        }

        $pdf = PDF::loadView('pdf.pdf3' , ['order' => $order,'orderDetails' => $orderDetails , 'profiles' => $profiles , 'windowColors' => $windowColors]);
        $pdfContents = $pdf->output();

        Storage::disk('pdf')->put($filename , $pdfContents);
        $url = url(Storage::url($filename));
        return response()->json(
            [
                'pdf' => $url ,
            ]);
    }
    public function exportPdf4(string $id){

        $order = Order::find($id);
        if(!$order){
            return  new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ] , 404);
        }

        $orderDetails = $order->orderDetails;
        $filename = 'invoice4_' . $order->order_id . '.pdf';

        if (Storage::disk('pdf')->exists($filename)) {
            // If the file exists, return its URL
            $url = url(Storage::url($filename));
            return response()->json(['pdf' => $url]);
        }


        $pdf = PDF::loadView('pdf.pdf4'  , ['order' => $order , 'orderDetails' => $orderDetails]);
        $pdfContents = $pdf->output();

        Storage::disk('pdf')->put($filename , $pdfContents);
        $url = url(Storage::url($filename));
        return response()->json(
            [
                'pdf' => $url ,
            ]);
    }




    public function orderDetails(GetOrderDetailRequest $request){

        $details = $request->input('orders');
        $currency = Currency::find($request->currency_id);
        $totalPrice = 0;

        $data =  [];
        foreach ($details as $detail){
            $price = 0;
            $profileNumber = 0;
            $sealantQuantity = 0;
            if($detail['profile_type_id']){
                $profileType = ProfileType::find($detail['profile_type_id']);
                $quantity_left = 0;
                $quantity_right = 0;
                if(array_key_exists('quantity_right' , $detail)){
                    $profileNumber += $detail['quantity_right'];
                    $quantity_right = $detail['quantity_right'];
                }
                if(array_key_exists('quantity_left' , $detail)){
                    $profileNumber += $detail['quantity_left'];
                    $quantity_left = $detail['quantity_left'];
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
                $windowHandler = WindowHandler::where('profile_type_id' , $profileType->id)->where('profile_color_id' , $detail['profile_color_id'])->whereNull('deleted_at')->first();
                if($windowHandler){
                    $handlerPosition = HandlerPosition::find($detail['handler_position_id']);
                    if($handlerPosition){
                        if($handlerPosition->slug == "no_handler"){
                            $windowHandlerQuantity += 0;
                            $profilePeremetr = $profilePeremetr + 2 * $width + 2 * $height;
                        }
                        if($handlerPosition->slug == "opposite"){
                            $price += $height*$windowHandler->price*$profileNumber;
                            $windowHandlerQuantity = $height*$profileNumber;
                            $profilePeremetr = $profilePeremetr + 2 * $width + 2 * $height;
                        }
                        if($handlerPosition->slug == "top"){
                            $price += $width*$windowHandler->price*$profileNumber;
                            $windowHandlerQuantity = $width*$profileNumber;
                            $profilePeremetr = $profilePeremetr + 2 * $width + 2 * $height;
                        }
                        if($handlerPosition->slug == "below"){
                            $price += $width*$windowHandler->price*$profileNumber;
                            $windowHandlerQuantity = $width*$profileNumber;
                            $profilePeremetr = $profilePeremetr + 2 * $width + 2 * $height;
                        }
                        if($handlerPosition->slug == "round"){
                            $price += $peremetr*$windowHandler->price;
                            $windowHandlerQuantity = $peremetr;
                            $profilePeremetr = $profilePeremetr + 2 * $width + 2 * $height;
                        }
                    }
                }else{
                    $profilePeremetr = 2*($height + $width);
                }

                if($profileType->corner){
                    $corner = Corner::where('profile_type_id' , $profileType->id)->first();
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
                    $price += $additionalService->price*$surface; // Har bitta rom uchun alohida qo'shimcha xizmat xaqi mi yoki hammasiga bittami
                }
            }
            $assemblyService = null;
            $perimeter = 2*($width + $height);
            if($height < 1.8 ){
                $assemblyService = AssemblyService::where('facade_height' , 1800)->where('condition_operator' , '<')->first();
                if($assemblyService){
                    $price += $assemblyService->price*$profileNumber;
                }
            }elseif($height >= 1.8){
                $assemblyService = AssemblyService::where('facade_height' , 1800)->where('condition_operator' , '>')->first();
                if($assemblyService){
                    $price += $assemblyService->price*$profileNumber;
                }
            }
            $windowColor1 = WindowColor::find($detail['window_color_id']);
            $profileColor1 = ProfileColor::find($detail['profile_color_id']);
            $openingType1 = OpeningType::find($detail['opening_type_id']);
            if(array_key_exists('additional_service_id' ,$detail)){
                $additionalService1 = AdditionalService::find($detail['additional_service_id']);
            }
             if(array_key_exists('handler_position_id' ,$detail)){
                $handlerPosition1 = HandlerPosition::find($detail['handler_position_id']);
            }
             $sealant1 = Sealant::where('profile_type_id' , $profileType->id)->first();
            $windowHandler1 = WindowHandler::where('profile_type_id', $profileType->id)->where('profile_color_id', $detail['profile_color_id'])->first();
            $corner1 = Corner::where('profile_type_id' , $profileType->id)->first();
            $data[] = [
                'profile_id' => $profileType->id,
                'profile_type' => $profileType->calculationType->name ,
                'profile_size' => $profileType->size_name ,
                'profile_type_name' => $profileType->name ,
                'profile_type_vendor_code' => $profileType->vendor_code ,
                'profile_type_name_uz' => $profileType->uz_name ,
                'profile_type_price' => round($profileType->price*$currency->rate  , 2),
                'profile_quantity' => round($profilePeremetr*$profileNumber , 2) ,
                'window_color_id' => $windowColor1->id ,
                'window_vendor_code' => $windowColor1->vendor_code ,
                'window_color_name' => $windowColor1->name ,
                'window_color_name_uz' => $windowColor1->uz_name ,
                'window_color_price' => $windowColor1->price*$currency->rate ,
                'window_color_surface' => round(($width*$height)*($quantity_left + $quantity_right) ),
                'profile_color_id' =>  $profileColor1->id,
                'profile_color_name' =>  $profileColor1->name,
                'profile_color_name_uz' =>  $profileColor1->uz_name,
                'opening_type_name' => $openingType1->name ,
                'opening_type_position' => $openingType1->position ,
                'handler_position_name' => ($handlerPosition1) ? $handlerPosition1->name :"",
                'handler_position_name_uz' => ($handlerPosition1) ? $handlerPosition1->uz_name :"",
                'additional_service_vendor_code' => ($additionalService1) ? $additionalService1->vendor_code  : "",
                'additional_service_name' => ($additionalService1) ? $additionalService1->name  : "",
                'additional_service_name_uz' => ($additionalService1) ? $additionalService1->uz_name  : "",
                'additional_service_price' => ($additionalService1) ? round($additionalService1->price * $currency->rate , 2)  : 0,
                'additional_service_quantity' => ($additionalService1) ? round($surface , 2)  : 0,
                'assembly_service_vendor_code' => ($assemblyService) ? $assemblyService->vendor_code : "" ,
                'assembly_service_name' => ($assemblyService) ? $assemblyService->name : "" ,
                'assembly_service_name_uz' => ($assemblyService) ? $assemblyService->uz_name : "" ,
                'assembly_service_price' => ($assemblyService) ? round($assemblyService->price * $currency->rate , 2) : 0 ,
                'assembly_service_quantity' => ($assemblyService) ? round($profileNumber , 2) : 0 ,
                'sealant_name' => ($sealant1) ? $sealant1->name : "",
                'sealant_name_uz' => ($sealant1) ? $sealant1->uz_name : "",
                'sealant_vendor_code' => ($sealant1) ? $sealant1->vendor_code : "",
                'sealant_price' => ($sealant1) ? round($sealant1->price * $currency->rate , 2) : 0,
                'sealant_quantity' => ($sealant1) ? round($sealantQuantity , 2) : 0,
                'window_handler_vendor_code' => ($windowHandler1) ? $windowHandler1->vendor_code : "",
                'window_handler_name' => ($windowHandler1) ? $windowHandler1->name : "",
                'window_handler_price' => ($windowHandler1) ? round($windowHandler1->price *$currency->rate , 2) : 0,
                'window_handler_quantity' => ($windowHandler1) ? round($windowHandlerQuantity , 2) : 0,
                'conrer_vendor_code' => ($corner1)  ? $corner->vendor_code : "",
                'conrer_name' => ($corner1)  ? $corner->name : "",
                'conrer_name_uz' => ($corner1)  ? $corner->uz_name : "",
                'conrer_price' => ($corner1)  ? round($corner->price*$currency->rate , 2) : 0.00,
                'conrer_quantity' => ($corner1)  ? round($cornerQuantity , 2) : 0,
                'width' => $width*1000 ,
                'height' => $height*1000 ,
                'quantity_right' => (array_key_exists('quantity_right', $detail)) ? $detail['quantity_right'] : 0 ,
                'quantity_left' => (array_key_exists('quantity_left' , $detail)) ? $detail['quantity_left'] : 0 ,
                'number_of_loops' => ($detail['number_of_loops']) ? $detail['number_of_loops'] : 1 ,
                'comment' => ($detail['comment']) ? $detail['comment'] : "" ,
                'additive_sizes' => (array_key_exists('additive_sizes' , $detail)) ? $detail['additive_sizes'] : "" ,
            ];
        }

        $data = collect($data);
   // Profiles
        $summedProfiles = $data->mapToGroups(function ($item) {
            return ["{$item['profile_id']}-{$item['profile_color_id']}"=> [
                    'profile_name' => $item['profile_type_name'] ,
                    'profile_name_uz' => $item['profile_type_name_uz'] ,
                    'profile_vendor_code' => $item['profile_type_vendor_code'] ,
                    'profile_price' => $item['profile_type_price'] ,
                    'profile_quantity' => $item['profile_quantity'],
                    'profile_size' => $item['profile_size'],
              ]
            ];
        })->map(function ($group){
            return [
                'profile_vendor_code' => $group[0]['profile_vendor_code'] ,
                'profile_name' => $group[0]['profile_name'] ,
                'profile_name_uz' =>$group[0]['profile_name_uz'] ,
                'profile_price' => $group[0]['profile_price'] ,
                'profile_size' => $group[0]['profile_size'],
                'total_quantity' => $group->sum('profile_quantity'),
            ];
        });

        // Windows 'window_color_id' => $windowColor1->id ,
        //                'window_vendor_code' => $windowColor1->vendor_code ,
        //                'window_color_name' => $windowColor1->name ,
        //                'window_color_name_uz' => $windowColor1->uz_name ,
        //                'window_color_price' => $windowColor1->price*$currency->rate ,
        //                'window_color_surface' => round(($width*$height)*($quantity_left + $quantity_right) ),
        $summedWindows = $data->mapToGroups(function ($item) {
            return ["{$item['window_color_id']}"=> [
                'window_vendor_code' => $item['window_vendor_code'] ,
                'window_color_name' => $item['window_color_name'] ,
                'window_color_name_uz' => $item['window_color_name_uz'] ,
                'window_color_price' => $item['window_color_price'] ,
                'window_color_surface' => $item['window_color_surface'],
            ]
            ];
        })->map(function ($group){
            return [
                'window_vendor_code' => $group[0]['window_vendor_code'] ,
                'window_color_name' => $group[0]['window_color_name'] ,
                'window_color_name_uz' =>$group[0]['window_color_name_uz'] ,
                'window_color_price' => $group[0]['window_color_price'] ,
                'total_quantity' => $group->sum('window_color_surface'),
            ];
        });

        return response()->json([
             'data' => $data ,
             'profiles' => $summedProfiles ,
             'windows' => $summedWindows
        ]);
    }

    public function totalPrice(GetOrderDetailRequest $request){
        $currency = Currency::find($request->currency_id);
        $details = $request->input('orders');
        $totalPrice = 0;
        foreach ($details as $detail){
            $price = 0;
            $profileNumber = 0;
            if($detail['profile_type_id']){

                $profileType = ProfileType::find($detail['profile_type_id']);
                if(array_key_exists('quantity_right' , $detail) && $detail['quantity_right'] > 0){
                    $profileNumber += $detail['quantity_right'];
                }
                if(array_key_exists('quantity_left' , $detail) && $detail['quantity_left'] > 0){
                    $profileNumber += $detail['quantity_left'];
                }

                $width = $detail['width']/1000;
                $height = $detail['height']/1000;

                $peremetr = 2*($width + $height) * $profileNumber;

                $profilePeremetr = 0;

                $surface = $width * $height;

                if($profileType->sealant){
                    $sealant = Sealant::where('profile_type_id' , $profileType->id)->first();
                    $price += $peremetr*$sealant->price;
                }
                if($profileType->window_handler){
                    $windowHandler = WindowHandler::where('profile_type_id' , $profileType->id)->where('profile_color_id' , $detail['profile_color_id'])->whereNull('deleted_at')->first();
                    $handlerPosition = HandlerPosition::find($detail['handler_position_id']);
                    if($handlerPosition->slug == "no_handler"){
                        $profilePeremetr = $profilePeremetr + 2 * $width + 2 * $height;
                    }
                   if($windowHandler){
                       if($handlerPosition->slug == "opposite"){
                           $price += $height*$windowHandler->price*$profileNumber;
                           $profilePeremetr = $profilePeremetr + 2 * $width + 2 * $height;
                       }
                       if($handlerPosition->slug == "top"){
                           $price += $width*$windowHandler->price*$profileNumber;
                           $profilePeremetr = $profilePeremetr + 2 * $width + 2 * $height;
                       }
                       if($handlerPosition->slug == "below"){
                           $price += $width*$windowHandler->price*$profileNumber;
                           $profilePeremetr = $profilePeremetr + 2 * $width + 2 * $height;
                       }
                       if($handlerPosition->slug == "round"){
                           $price += $peremetr*$windowHandler->price;
                           $profilePeremetr = $profilePeremetr + 2 * $width + 2 * $height;
                       }
                   }
                }
                if($profileType->corner){
                    $corner = Corner::where('profile_type_id' , $profileType->id)->first();
                    if($corner){
                        $price += 4 * $profileNumber * $corner->price;
                    }
                }
                $price += $profileNumber*$profilePeremetr*$profileType->price;
            }
            if($detail['window_color_id']){
                $windowColor = WindowColor::find($detail['window_color_id']);
                if($windowColor){
                    $price += $surface * $windowColor->price * $profileNumber;
                }
            }
            if(array_key_exists('additional_service_id' ,$detail)){
                $additionalService = AdditionalService::find($detail['additional_service_id']);
                if($additionalService){
                    $price += $additionalService->price*$surface*$profileNumber;
                }
            }
            if($height < 1.8 ){
                $assemblyService = AssemblyService::where('facade_height' , 1800)->where('condition_operator' , '<')->first();
                if($assemblyService){
                    $price += $assemblyService->price*$profileNumber;
                }
            }elseif($height >= 1.8){
                $assemblyService = AssemblyService::where('facade_height' , 1800)->where('condition_operator' , '>')->first();
                if($assemblyService){
                    $price += $assemblyService->price*$profileNumber;
                }
            }
            $totalPrice += $price;
        }

        return response()->json([
            'totalPrice' => round($totalPrice * $currency->rate , 2) ,
        ]);
    }

}
