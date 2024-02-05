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
  </style>
</head>

<body>
<div class="full">

    <div class="wrap">
        @foreach($orderDetails as $orderDetail)
            <table class="card">
                <tr class="card-item">
                    <td class="text">Профиль:</td>
                    <td class="title">{{$orderDetail->profileType->name}}, {{$orderDetail->profileColor->name}}</td>
                </tr>
                <tr class="card-item">
                    <td class="text">Цвет стекла:</td>
                    <td class="title">{{$orderDetail->windowColor->name}}</td>
                </tr>
                <tr class="card-item">
                    <td class="text">Доп-услуги для стекла:</td>
                    <td class="title">{{$orderDetail->additionalService->name}}</td>
                </tr>
                <tr class="card-item">
                    <td class="text">Тип открывания:</td>
                    <td class="title">{{$orderDetail->openingType->name}}</td>
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
                    <td class="title">{{$orderDetail->}}</td>
                </tr>
                <tr class="card-item">
                    <td class="text">Присака станд.?:</td>
                    <td class="title">Узкий (19 мм), Черный</td>
                </tr>
                <tr class="card-item">
                    <td class="text">Комментарий:</td>
                    <td class="title">Узкий (19 мм), Черный</td>
                </tr>
            </table>
        @endforeach
    </div>
</div>

<div class="wrap" style="margin-bottom: 20px;">
    <div class="card1">
        <table class="card-item1">
            <tr class="card-title">
                <td>Профиль</td>
                <td>#1401</td>
                <td>28.12.2023 18:53</td>
            </tr>
            <tr class="card-top">
                <td>Код товара</td>
                <td>Высота</td>
                <td>Кол-во</td>
            </tr>
            <tr class="card-list">
                <td>2110 Black</td>
                <td>2800</td>
                <td>10</td>
            </tr>
            <tr class="card-list">
                <td>Gold Aluminy</td>
                <td>2800</td>
                <td>10</td>
            </tr>
            <tr class="card-list">
                <td>Glass1</td>
                <td>2800</td>
                <td>10</td>
            </tr>
        </table>
    </div>
    <div class="card1">
        <table class="card-item1">
            <tr class="card-title">
                <td>Профиль</td>
                <td>#1401</td>
                <td>28.12.2023 18:53</td>
            </tr>
            <tr class="card-top">
                <td>Код товара</td>
                <td>Высота</td>
                <td>Кол-во</td>
            </tr>
            <tr class="card-list">
                <td>2110 Black</td>
                <td>2800</td>
                <td>10</td>
            </tr>
            <tr class="card-list">
                <td>Gold Aluminy</td>
                <td>2800</td>
                <td>10</td>
            </tr>
            <tr class="card-list">
                <td>Glass1</td>
                <td>2800</td>
                <td>10</td>
            </tr>
        </table>
    </div>
</div>
</body>

</html>
