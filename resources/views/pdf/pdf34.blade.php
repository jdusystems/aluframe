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
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body{
            font-family: "Inter";
            text-align: center;
        }
        .full{
            width: 100%;

        }
        .wrap{
            width: 100%;
            max-width: 876px;
            margin: 0 auto;
            display: inline-block;
            text-align: left;
        }

        .card{
            width: 50%;
            padding: 55px 40px;
            border-bottom: 1px dotted #121212;
            float: right;
        }
        .card:nth-child(2n-1){
            border-right: 1px dotted #121212;
            float: left;
        }
        .card1{
            width: 50%;
            padding: 55px 40px;
            border-top: 1px dotted #121212;
            border-bottom: 1px dotted #121212;
            float: right;
        }
        .card1:nth-child(2n-1){
            border-right: 1px dotted #121212;
            float: left;
        }
        .card-item{
            width: 100%;

        }
        .card-item:last-child{
            margin-top: 0;
        }
        .text{
            display: inline-block;
            width: 50%;
            color: #121212;
            font-family: Inter;
            font-size: 11px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
            margin-bottom: 12px;
        }
        .title{
            display: inline-block;
            width: 50%;
            color: #121212;
            font-family: Inter;
            font-size: 12px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
            margin-bottom: 12px;
        }

        .card-title{
            width: 100%;
        }

        .card-title td:nth-child(1){

            color: #4B3E32;
            font-family: Inter;
            font-size: 13px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
            max-width: 107px;
        }
        .card-title td{
            width: 33%;

            color: #4B3E32;

            font-family: Inter;
            font-size: 13px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
        }

        .card-top{
            width: 100%;

        }
        .card-top td{

            color: #4B3E32;
            font-family: Inter;
            font-size: 11px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
        }
        .card-list{
            width: 100%;

        }
        .card-list1{
            width: 100%;

        }
        .card-list td{

            margin-bottom: 4px;
            color: #4B3E32;
            font-family: Inter;
            font-size: 13px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
        }


        .WrapConent{
            width: 100%;
            max-width: 716px;
            gap: 21px;
            margin: 80px auto;
            display: flex;
            flex-wrap: wrap;
        }

        .cardConent{
            width:calc((100% - 21px) / 2);
            list-style: none;
            padding-top: 20px;
            padding-bottom: 37px;
            border-top: 1px dotted black;
            border-bottom: 1px dotted black;
        }
        .cardConent-top{
            display: flex;
            align-items: center;
            margin-bottom: 22px;
            gap: 22px;
        }
        .cardConent-top p {
            color: #4B3E32;
            font-family: Inter;
            font-size: 13px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
        }
        .cardConent-top p:last-child{
            margin-left: auto;
        }
        .cardConent-item{
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
            gap: 22px;
        }
        .cardConent-item p {
            color: #4B3E32;
            font-family: Inter;
            font-size: 14px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
        }
        .cardConent-item p:last-child{
            text-align: end;
        }
        .cardConent-item:nth-child(5) p:first-child {
            font-weight: 700;
        }
        .cardConent-item:nth-child(4) p:first-child {
            font-weight: 700;
        }
    </style>
</head>

<body>
<div class="full">

    <div class="wrap">
        @foreach($orderDetails as $orderDetail)
            <table class="card">
                <tr class="card-item">
                    <td class="text">Профиль:</td>
                    <td class="title">{{($orderDetail->profileType) ? $orderDetail->profileType->name: ""}}, {{($orderDetail->profileColor) ? $orderDetail->profileColor->name : ""}}</td>
                </tr>
                <tr class="card-item">
                    <td class="text">Цвет стекла:</td>
                    <td class="title">{{($orderDetail->windowColor) ? $orderDetail->windowColor->name :""}}</td>
                </tr>
                <tr class="list-item">
                    <td class="text">Дополнительные услуги для стекла:</td>
                    <td class="title">
                        @foreach($orderDetail->additionalServices as $additionalService)
                            {{($additionalService) ? $additionalService->name: ""}} ,
                        @endforeach
                    </td>
                </tr>
                <tr class="card-item">
                    <td class="text">Тип открывания:</td>
                    <td class="title">{{($orderDetail->openingType) ? $orderDetail->openingType->name : ""}}</td>
                </tr>
                <tr class="card-item">
                    <td class="text">Количество петель:</td>
                    <td class="title">{{$orderDetail->number_of_loops}}</td>
                </tr>
                <tr class="card-item">
                    <td class="text">Высота:</td>
                    <td class="title">{{$orderDetail->height}}</td>
                </tr>
                <tr class="card-item">
                    <td class="text">Ширина:</td>
                    <td class="title">{{$orderDetail->width}}</td>
                </tr>
                <tr class="card-item">
                    <td class="text">Кол-во L:</td>
                    <td class="title">{{$orderDetail->quantity_left}}</td>
                </tr>
                <tr class="card-item">
                    <td class="text">Кол-во R:</td>
                    <td class="title">{{$orderDetail->quantity_right}}</td>
                </tr>
                <tr class="card-item">
                        <?php
                        $windowHandler = \App\Models\WindowHandler::where('profile_type_id' , $orderDetail->profile_type_id)->where('profile_color_id' , $orderDetail->profile_color_id)->whereNull('deleted_at')->first();
                        ?>
                    <td class="text">Ручка:</td>
                    <td class="title">
                        {{($windowHandler) ? $windowHandler->name : ""}}
                    </td>
                </tr>
                <tr class="card-item">
                    <td class="text">Присака станд.?:</td>
                    <td class="title">{{($orderDetail->additive_sizes) ? $orderDetail->additive_sizes : ""}} </td>
                </tr>
                <tr class="card-item">
                    <td class="text">Комментарий:</td>
                    <td class="title">{{ ($orderDetail->comment) ? $orderDetail->comment : ""}}</td>
                </tr>
            </table>
        @endforeach

    </div>
</div>

<div class="wrap" style="margin-bottom: 20px;">
    <div class="card1">
        <table class="card-item1">
            <tr class="card-title" style="margin-left: 20px">
                <td style=" padding-left: 30px;">Профиль</td>
                <td style=" padding-left: 20px;">{{$order->order_id}}</td>
                <td style=" padding-left: 20px;">{{$order->created_at}}</td>
            </tr>
            <tr class="card-top">
                <td style=" padding-left: 30px;">Код товара</td>
                <td style=" padding-left: 20px;">Высота</td>
                <td style=" padding-left: 20px;">Кол-во</td>
            </tr>
            @foreach($profiles as $profile)
                <tr class="card-list">
                    <td style=" padding-left: 30px;">{{$profile->profileType->name}}</td>
                    <td style=" padding-left: 20px;">{{2*($profile->total_height + $profile->total_width)}}</td>
                    <td style=" padding-left: 20px;">{{$profile->total_facade_quantity}}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="card1">
        <table class="card-item1">
            <tr class="card-title" >
                <td style="padding-left: 30px;">Стекло</td>
                <td style=" padding-left: 20px;">{{$order->order_id}}</td>
                <td style=" padding-left: 20px; " colspan="2">{{$order->created_at}}</td>
            </tr>
            <tr class="card-top">
                <td style=" padding-left: 30px;">Код товара</td>
                <td style=" padding-left: 20px;">Высота</td>
                <td style=" padding-left: 20px;">Ширина</td>
                <td style=" padding-left: 20px;">Кол-во</td>
            </tr>
            @foreach($windowColors as $windowColor)
                    <?php
                    $profiles = \App\Models\OrderDetail::where('window_color_id' , $windowColor->window_color_id)->where('order_id' , $order->id)->get();
                    ?>
                <tr class="card-list">
                    <td style=" padding-left: 30px;">{{$windowColor->windowColor->name}}</td>
                    <td style=" padding-left: 20px;">{{$windowColor->total_width}}</td>
                    <td style=" padding-left: 20px;">{{$windowColor->total_height}}</td>
                    <td style=" padding-left: 20px;">{{$windowColor->total_facade_quantity}}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

<div class="WrapConent">
    @foreach($orderDetails as $orderDetail)
            <?php
            $facades = $orderDetail->quantity_left + $orderDetail->quantity_right;
            ?>
        @for($i = 1;$i <= $facades;$i++)

    <ul class="cardConent">
        <li class="cardConent-top">
            <p>{{$orderDetail->id}}</p>
            <p>{{$order->created_at}}</p>
            <p>Фасад {{$i}}/{{$facades}}</p>
        </li>
        <li class="cardConent-item">
            <p>Высота:</p>
            <p>{{$orderDetail->height*1000}}</p>
        </li>
        <li class="cardConent-item">
            <p>Ширина:</p>
            <p>{{$orderDetail->width*1000}}</p>
        </li>
        <li class="cardConent-item">
            <p>Профиль:</p>
            <p>{{$orderDetail->profileType->name}} , {{$orderDetail->profileColor->name}}̆</p>
        </li>
        <li class="cardConent-item">
            <p>Cтекло:</p>
            <p>{{$orderDetail->windowColor->name}}ijd</p>
        </li>
    </ul>
            @if($i%2==0)
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            @endif
        @endfor
    @endforeach
</div>
</body>

</html>
