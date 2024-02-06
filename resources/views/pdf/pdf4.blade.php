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
        .wrap{
            width: 100%;
            max-width: 716px;
            gap: 21px;
            margin: 80px auto;
        }
        .card{
            width:calc((100% - 21px) / 2);
            list-style: none;
            padding-top: 20px;
            padding-bottom: 37px;
            border-top: 1px dotted black;
            border-bottom: 1px dotted black;
            float: right;
        }
        .card:nth-child(2n-1){
            float: left;
        }
        .card-top{
            width: 100%;
            padding-bottom: 22px;
        }
        .card-top td {
            color: #4B3E32;
            font-family: Inter;
            font-size: 13px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
            padding-bottom: 22px;
            /*padding-right: 10px;*/
        }
        .card-top td:last-child{
            margin-left: auto;
        }
        .card-item{
            width: 100%;
        }
        .card-item td {
            color: #4B3E32;
            font-family: Inter;
            font-size: 14px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
            padding-bottom: 12px;
        }
        .card-item td:last-child{
            text-align: end;
        }
        .card-item:nth-child(5) td:first-child {
            font-weight: 700;
        }
        .card-item:nth-child(4) td:first-child {
            font-weight: 700;
        }
    </style>
</head>

<body>

<div class="wrap">
    @foreach($orderDetails as $orderDetail)
            <?php
               $facades = $orderDetail->quantity_left + $orderDetail->quantity_right  + 1;
            ?>
         @for($i = 1;$i <= $facades;$i++)
        <table class="card">
                <tr class="card-top">
                    <td style="padding-right: 30px">{{$orderDetail->id}} {{$order->created_at}}</td>
                    <td style="padding-left: 20px">Фасад {{$i}}/{{$facades}}</td>
                </tr>
                <tr class="card-item">
                    <td>Высота:</td>
                    <td>{{$orderDetail->height}}</td>
                </tr>
                <tr class="card-item">
                    <td>Ширина:</td>
                    <td>{{$orderDetail->width}}</td>
                </tr>
                <tr class="card-item">
                    <td>Профиль:</td>
                    <td>{{$orderDetail->profileType->name}} , {{$orderDetail->profileColor->name}}</td>
                </tr>
                <tr class="card-item">
                    <td>Cтекло:</td>
                    <td>{{$orderDetail->windowColor->name}}</td>
                </tr>
        </table>
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
        <hr>
    @endforeach
</div>
</body>

</html>
