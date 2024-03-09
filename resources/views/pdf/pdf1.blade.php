<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">
   <style>
       *,
       *::after,
       *::before{
           margin: 0;
           padding: 0;
           box-sizing: border-box;
       }
       body{
           font-family: "Inter";
       }
       .container{
           width: 100%;
           max-width: 716px;
           margin: 0 auto;
       }
       .page-break{
           page-break-after: always;
       }
       .header{
           display: inline-block;
           width: 100%;
           height: 24px;
           /*padding-top: 34px;*/
           padding-bottom: 20px;
           /*border-bottom: 1px dotted rgb(18, 18, 18,.2);*/
       }


       .header-left{
           /* width: 100%; */
           float: right;
       }
       .title{
           float: left;
           /* width: 100%; */
           color: black;
           font-family: Inter;
           font-size: 25px;
           font-style: normal;
           font-weight: 500;
           line-height: normal;
           text-transform: uppercase;
       }
       .text{
           color: black;
           text-align: right;
           font-family: Inter;
           font-size: 14px;
           font-style: normal;
           font-weight: 500;
           line-height: normal;
       }
       .client{
           /*border: 2px solid red;*/
           /*background-color: lightpink;*/
           height: 24px;
           width: 100%;
           font-size: 24px;
           margin-bottom: 10px;
           padding-bottom: 5px;
           margin-top: 25px;
       }

       .list{
           width: 100%;
           padding-bottom: 27px;
           border-bottom: 1px dotted rgb(18, 18, 18,.2);
           margin-top: 30px;
       }
       .list-item{
           width: 100%;

       }
       .list-top{
           width: 100%;

       }
       .list-item:nth-child(2n-1){
           background-color: #f4f4f4;

       }
       .list-text{

           text-align: left;
           color: black;
           font-family: Inter;
           font-size: 12px;
           font-style: normal;
           font-weight: 500;
           line-height: normal;
           padding: 8px 10px;
           width: 50%;
       }
       .list-text1{
           padding: 8px 10px;
           /* width: 100%; */
           text-align:left;
           color: black;
           font-family: Inter;
           font-size: 12px;
           font-style: normal;
           font-weight: 500;
           line-height: normal;

       }
       .list-text2{
           padding: 9px;
           color: black;
       }

       .list-text1:first-child{
           max-width: 161px ;
       }
       .list-text1:nth-child(2){
           max-width: 340px ;
       }
       .list-text1:nth-child(3){
           max-width: 50px ;
       }
       .list-text1:nth-child(4){
           max-width: 50px ;
       }
       .list-text1:nth-child(5){
           max-width: 50px ;
       }
       .list-text2:first-child{
           max-width: 171px  !important;
       }
       .wrap{
           display: inline-block;
           width: 100%;
           margin-top: 40px;
           margin-bottom: 40px;
       }

       .wrap-tile{
           color: black;
           font-family: Inter;
           font-size: 20px;
           font-style: normal;
           font-weight: 700;
           line-height: normal;
           float:left;
       }

       .pdf-text{
           width: 100%;
           max-width: 419px;
           color: black;
           font-family: Inter;
           font-size: 13px;
           font-style: normal;
           font-weight: 400;
           line-height: 18px;
           margin-bottom: 8px;
       }
       .pdf-text span{
           color: black;
           font-family:Inter;
           font-size: 13px;
           font-style: normal;
           font-weight: 700;
           line-height: 18px;
       }

   </style>
</head>

<body>
<div class="container">
    <div class="client" style="margin-right: 200px;" >
        <div style="float: left">
            <span class="text" style="font-weight: bold;">Заказчик:</span>
            <span class="text" style="padding-left: 3px;max-width: 120px;">{{$user->name}}, </span>
            <span class="text" style="padding-left: 10px">+{{$user->phone_number}}</span>
        </div>
        <div style="float: right">
            <span class="text" style="margin-left: 230px">#{{$order->id}}</span>
            <span class="text" style="margin-left: 20px">{{$order->created_at->format('d.m.Y H:i')}}</span>
        </div>
    </div>
    <header class="header">
        <h3 class="wrap-tile">Накладная</h3>
    </header>
    <?php
    $i = 0;
    ?>
    @foreach($orderDetails as $orderDetail)
            <?php
            $i = $i + 1;
            ?>
        <table class="list">
            <tr class="list-item">
                <th class="list-text">Профиль</th>
                <th class="list-text">{{($orderDetail->profileType) ? $orderDetail->profileType->name: "" ." "}} {{($orderDetail->profileColor) ? $orderDetail->profileColor->name : "" ." "}}</th>
            </tr>
            <tr class="list-item">
                <th class="list-text">Цвет стекла:</th>
                <th class="list-text">{{($orderDetail->windowColor)? $orderDetail->windowColor->name : "Без стекла"}}</th>
            </tr>
            <tr class="list-item">
                <th class="list-text">Дополнительные услуги для стекла:</th>

                    <th class="list-text">
                        @foreach($orderDetail->additionalServices as $additionalService)
                        {{($additionalService) ? $additionalService->name: "" ." "}}
                        @endforeach
                    </th>
            </tr>
            <tr class="list-item">
                <th class="list-text">Тип открывания:</th>
                <th class="list-text">{{($orderDetail->openingType) ? $orderDetail->openingType->name: ""}}</th>
            </tr>
            <tr class="list-item">
                <th class="list-text">Количество петель:</th>
                <th class="list-text">{{$orderDetail->number_of_loops}}</th>
            </tr>
            <tr class="list-item">
                <th class="list-text">Высота:</th>
                <th class="list-text">{{$orderDetail->height*1000}}мм </th>
            </tr>
            <tr class="list-item">
                <th class="list-text">Ширина:</th>
                <th class="list-text">{{$orderDetail->width*1000}}мм</th>
            </tr>
            @if($orderDetail->openingType)
                @if($orderDetail->openingType->position=="single")
                    <tr class="list-item">
                        <th class="list-text">Кол-во фасадов:</th>
                        <th class="list-text">{{$orderDetail->quantity_left}}</th>
                    </tr>
                @elseif($orderDetail->openingType->position=="left/right")
                    <tr class="list-item">
                        <th class="list-text">Кол-во L:</th>
                        <th class="list-text">{{$orderDetail->quantity_left}}</th>
                    </tr>
                    <tr class="list-item">
                        <th class="list-text">Кол-во R:</th>
                        <th class="list-text">{{$orderDetail->quantity_right}}</th>
                    </tr>
                @elseif($orderDetail->openingType->position=="top/bottom")
                    <tr class="list-item">
                        <th class="list-text">Кол-во верхних фасадов:</th>
                        <th class="list-text">{{$orderDetail->quantity_left}}</th>
                    </tr>
                    <tr class="list-item">
                        <th class="list-text">Кол-во нижних фасадов:</th>
                        <th class="list-text">{{$orderDetail->quantity_right}}</th>
                    </tr>
                @endif
            @endif

            <tr class="list-item">
                    <?php
                    $windowHandler = \App\Models\WindowHandler::where('profile_type_id' , $orderDetail->profile_type_id)->where('profile_color_id' , $orderDetail->profile_color_id)->whereNull('deleted_at')->first();
                    ?>
                <th class="list-text">Ручка:</th>
                @if($orderDetail->handlerPosition->slug=="no_handler")
                    <th class="list-text">{{ ($orderDetail->handlerPosition) ? $orderDetail->handlerPosition->name:""}}</th>
                @else
                    <th class="list-text">{{($orderDetail->handlerPositionType) ? $orderDetail->handlerPositionType->handler_type_name:"" ." "}} {{($orderDetail->windowHandler) ? $orderDetail->windowHandler->profileColor->name:"" ." "}}  {{($orderDetail->handlerPosition) ? $orderDetail->handlerPosition->name:""}}</th>
                @endif
            </tr>
            <tr class="list-item">
                <th class="list-text">Присака станд.?:</th>
                <th class="list-text">{{($orderDetail->additive_sizes) ? $orderDetail->additive_sizes: "Стандарт"}}</th>
            </tr>
            <tr class="list-item">
                <th class="list-text">Комментарий:</th>
                <th class="list-text">{{ ($orderDetail->comment) ? $orderDetail->comment : ""}}</th>
            </tr>
        </table>


        @if($i % 2 == 0 || ($loop->last && $i != 1))
            <div class="page-break">

            </div>
        @endif
    @endforeach
    <div class="wrap">
        <h3 class="wrap-tile">Спецификация</h3>
        <div class="header-left">
            <span class="text" style="margin-left: 170px">#{{$order->id}}</span>
            <span class="text" style="margin-left: 20px">{{$order->created_at->format('d.m.Y H:i')}}</span>
        </div>
    </div>

    <table class="list">
        <tr class="list-top">
            <th class="list-text1 list-text2">Код товара</th>
            <th class="list-text1 list-text2">Наименование</th>
            <th class="list-text1 list-text2">Цена</th>
            <th class="list-text1 list-text2">Кол-во</th>
            <th class="list-text1 list-text2">Сумма</th>
        </tr>
        @foreach($profiles as $profile)
            @if($profile->profileType)
                <tr class="list-item">
                    <th class="list-text1">{{$profile->profileType->calCulationType->name}}</th>
                    <th class="list-text1">{{$profile->profileType->name}}</th>
                    <th class="list-text1">{{$profile->profileType->price}}</th>
                    <th class="list-text1">{{round($profile->total_profile_length , 2)}}</th>
                    <th class="list-text1">{{round($profile->total_profile_length*$profile->profileType->price , 2)}}</th>
                </tr>
            @endif

        @endforeach
        @foreach($profiles as $profile)
            @if($profile->profileType->sealant)
                <tr class="list-item">
                    <th class="list-text1">{{$profile->profileType->sealant->vendor_code}}</th>
                    <th class="list-text1">{{$profile->profileType->sealant->name}}</th>
                    <th class="list-text1">{{$profile->profileType->sealant->price}}</th>
                    <th class="list-text1">{{round($profile->total_sealant_length , 2)}}</th>
                    <th class="list-text1">{{round($profile->total_sealant_length*$profile->profileType->sealant->price ,2)}}</th>
                </tr>
            @endif

        @endforeach

        @foreach($profiles as $profile)
            @if($profile->profileType->corner)
                <tr class="list-item">
                    <th class="list-text1">{{$profile->profileType->corner->vendor_code}}</th>
                    <th class="list-text1">{{$profile->profileType->corner->name}}</th>
                    <th class="list-text1">{{$profile->profileType->corner->price}}</th>
                    <th class="list-text1">{{round($profile->total_corner_quantity , 2)}}</th>
                    <th class="list-text1">{{round($profile->total_corner_quantity*$profile->profileType->corner->price , 2)}}</th>
                </tr>
            @endif

        @endforeach
        @foreach($windowColors as $windowColor)
            @if($windowColor->windowColor)
                <tr class="list-item">
                    <th class="list-text1">{{$windowColor->windowColor->vendor_code}}</th>
                    <th class="list-text1">{{$windowColor->windowColor->name}}</th>
                    <th class="list-text1">{{$windowColor->windowColor->price}}</th>
                    <th class="list-text1">{{round($windowColor->total_surface , 2)}}</th>
                    <th class="list-text1">{{round($windowColor->total_surface * $windowColor->windowColor->price , 2)}}</th>
                </tr>
            @endif

        @endforeach
        @foreach($additionalServices as $additionalService)
{{--                <?php--}}
{{--                    $services = \App\Models\OrderDetail::where('additional_service_id' , $additionalService->additional_service_id)->where('order_id' , $order->id)->get();--}}
{{--                ?>--}}
        @if($additionalService['price'] > 0 && $additionalService['total_quantity'] > 0)
                <tr class="list-item">
                    <th class="list-text1">{{$additionalService['vendor_code']}}</th>
                    <th class="list-text1">{{$additionalService['name']}}</th>
                    <th class="list-text1">{{$additionalService['price']}}</th>
                    <th class="list-text1">{{round($additionalService['total_quantity'] , 2)}}</th>
                    <th class="list-text1">{{round($additionalService['total_quantity'] * $additionalService['price'] , 2)}}</th>
                </tr>
        @endif

        @endforeach
        @foreach($assemblyServices as $assemblyService)

        @if($assemblyService->assemblyService)
                <tr class="list-item">
                    <th class="list-text1">{{$assemblyService->assemblyService->vendor_code}}</th>
                    <th class="list-text1">{{$assemblyService->assemblyService->name}}</th>
                    <th class="list-text1">{{$assemblyService->assemblyService->price}}</th>
                    <th class="list-text1">{{round($assemblyService->total_facade_quantity , 2)}}</th>
                    <th class="list-text1">{{$assemblyService->total_facade_quantity * $assemblyService->assemblyService->price}}</th>
                </tr>
        @endif
        @endforeach

        @foreach($windowHandlers as $windowHandler)

        @if($windowHandler->windowHandler && $windowHandler->windowHandler->price > 0 && $windowHandler->total_window_handler_quantity > 0)
                    <?php
                    $orderDetail1 = \App\Models\OrderDetail::find($windowHandler->order_detail_id);
                    ?>
                <tr class="list-item">
                    <th class="list-text1">{{$windowHandler->windowHandler->vendor_code}}</th>
                    @if($orderDetail1->handlerPosition)
                        @if($orderDetail1->handlerPosition->slug=="no_handler")
                            <th class="list-text1">{{ ($orderDetail1->handlerPosition) ? $orderDetail1->handlerPosition->name:""}}</th>
                        @else
                            <th class="list-text1">{{($orderDetail1->handlerPositionType) ? $orderDetail1->handlerPositionType->handler_type_name:"" ." "}} {{($orderDetail1->windowHandler) ? $orderDetail1->windowHandler->profileColor->name:"" ." "}}  {{($orderDetail1->handlerPosition) ? $orderDetail->handlerPosition->name:""}}</th>
                        @endif
                    @endif
                    <th class="list-text1">{{$windowHandler->windowHandler->price}}</th>
                    <th class="list-text1">{{round($windowHandler->total_window_handler_quantity , 2)}}</th>
                    <th class="list-text1">{{round($windowHandler->total_window_handler_quantity * $windowHandler->windowHandler->price , 2)}}</th>
                </tr>
        @endif
        @endforeach
        <tr class="list-item">
            <th colspan="4" class="list-text1">Итого:</th>
            <th class="list-text1">{{round($order->total_price , 2)}}</th>
        </tr>
    </table>
    <p class="pdf-text" style="margin-top: 10px;">Вы можете проверить, как идет выполнение вашего заказа, зайдя в
        свой аккаунт:</p>
    <p class="pdf-text">Логин и пароль для входа в аккаунт: логин:
        <span>{{$user->phone_number}}</span> пароль:
        <span>{{$user->parol}}</span>
        <a class="pdf-link" style="font-weight: bold" href="https://aluframe.vercel.app/auth/login">Ссылка</a>
    </p>

</div>
</body>

</html>
