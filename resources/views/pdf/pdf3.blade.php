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

        }
        .wrap{
            width: 100%;
            max-width: 876px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            /* border-bottom: 1px dotted #121212; */
        }

        .card{
            width: 50%;
            padding: 55px 40px;
            border-bottom: 1px dotted #121212;
        }
        .card:nth-child(2n-1){
            border-right: 1px dotted #121212;
        }
        .card1{
            width: 50%;
            padding: 55px 40px;
            border-top: 1px dotted #121212;
            border-bottom: 1px dotted #121212;
        }
        .card1:nth-child(2n-1){
            border-right: 1px dotted #121212;
        }
        .card-item{
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }
        .card-item:last-child{
            margin-top: 0;
        }
        .text{
            width: 100%;
            color: #121212;
            font-family: Inter;
            font-size: 11px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
        }
        .title{
            width: 100%;
            color: #121212;
            font-family: Inter;
            font-size: 12px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
        }

        .card-title{
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title h3{
            width:100%;
            color: #4B3E32;
            font-family: Inter;
            font-size: 13px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
            max-width: 107px;
        }
        .card-title p{
            width: 100%;
            color: #4B3E32;

            font-family: Inter;
            font-size: 13px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
        }
        .card-title p:nth-child(2){
            width: 100%;
            max-width: 54px;
        }
        .card-top{
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 11px 0;
        }
        .card-top p{
            width: 100%;
            color: #4B3E32;
            font-family: Inter;
            font-size: 11px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
        }
        .card-list{
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 4px;
        }
        .card-list p{
            width: 100%;
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

<div class="wrap">
    <div class="card">
        <div class="card-item">
            <p class="text">Профиль:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Цвет стекла:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Доп-услуги для стекла:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Тип открывания:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Количество петель:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Высота:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Ширина:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Кол-во L:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Кол-во R:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Ручка:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Присака станд.?:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Комментарий:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
    </div>
    <div class="card">
        <div class="card-item">
            <p class="text">Профиль:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Цвет стекла:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Доп-услуги для стекла:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Тип открывания:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Количество петель:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Высота:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Ширина:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Кол-во L:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Кол-во R:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Ручка:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Присака станд.?:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Комментарий:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
    </div>
    <div class="card">
        <div class="card-item">
            <p class="text">Профиль:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Цвет стекла:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Доп-услуги для стекла:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Тип открывания:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Количество петель:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Высота:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Ширина:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Кол-во L:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Кол-во R:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Ручка:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Присака станд.?:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
        <div class="card-item">
            <p class="text">Комментарий:</p>
            <p class="title">Узкий (19 мм), Черный</p>
        </div>
    </div>
</div>

<div class="wrap" style="margin-bottom: 20px;">
    <div class="card1">
        <ul class="card-item1">
            <li class="card-title">
                <h3>Профиль</h3>
                <p>#1401</p>
                <p>28.12.2023 18:53</p>
            </li>
            <li class="card-top">
                <p>Код товара</p>
                <p>Высота</p>
                <p>Кол-во</p>
            </li>
            <li class="card-list">
                <p>2110 Black</p>
                <p>2800</p>
                <p>10</p>
            </li>
            <li class="card-list">
                <p>Gold Aluminy</p>
                <p>2800</p>
                <p>10</p>
            </li>
            <li class="card-list">
                <p>Glass1</p>
                <p>2800</p>
                <p>10</p>
            </li>
        </ul>
    </div>
    <div class="card1">
        <ul class="card-item1">
            <li class="card-title">
                <h3>Профиль</h3>
                <p>#1401</p>
                <p>28.12.2023 18:53</p>
            </li>
            <li class="card-top">
                <p>Код товара</p>
                <p>Высота</p>
                <p>Кол-во</p>
            </li>
            <li class="card-list">
                <p>2110 Black</p>
                <p>2800</p>
                <p>10</p>
            </li>
            <li class="card-list">
                <p>Gold Aluminy</p>
                <p>2800</p>
                <p>10</p>
            </li>
            <li class="card-list">
                <p>Glass1</p>
                <p>2800</p>
                <p>10</p>
            </li>
        </ul>
    </div>
</div>
</body>

</html>
