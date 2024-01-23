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
            display: flex;
            flex-wrap: wrap;
        }

        .card{
            width:calc((100% - 21px) / 2);
            list-style: none;
            padding-top: 20px;
            padding-bottom: 37px;
            border-top: 1px dotted black;
            border-bottom: 1px dotted black;
        }
        .card-top{
            display: flex;
            align-items: center;
            margin-bottom: 22px;
            gap: 22px;
        }
        .card-top p {
            color: #4B3E32;
            font-family: Inter;
            font-size: 13px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
        }
        .card-top p:last-child{
            margin-left: auto;
        }
        .card-item{
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
            gap: 22px;
        }
        .card-item p {
            color: #4B3E32;
            font-family: Inter;
            font-size: 14px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
        }
        .card-item p:last-child{
            text-align: end;
        }
        .card-item:nth-child(5) p:first-child {
            font-weight: 700;
        }
        .card-item:nth-child(4) p:first-child {
            font-weight: 700;
        }
    </style>
</head>

<body>

<div class="wrap">
    <ui class="card">
        <li class="card-top">
            <p>#1401</p>
            <p>28.12.2023 18:53</p>
            <p>Фасад 1/12</p>
        </li>
        <li class="card-item">
            <p>Высота:</p>
            <p>2470</p>
        </li>
        <li class="card-item">
            <p>Ширина:</p>
            <p>2470</p>
        </li>
        <li class="card-item">
            <p>Профиль:</p>
            <p>Узкий (19 мм), Черный</p>
        </li>
        <li class="card-item">
            <p>Cтекло:</p>
            <p>Прозрачное</p>
        </li>
    </ui>
    <ui class="card">
        <li class="card-top">
            <p>#1401</p>
            <p>28.12.2023 18:53</p>
            <p>Фасад 1/12</p>
        </li>
        <li class="card-item">
            <p>Высота:</p>
            <p>2470</p>
        </li>
        <li class="card-item">
            <p>Ширина:</p>
            <p>2470</p>
        </li>
        <li class="card-item">
            <p>Профиль:</p>
            <p>Узкий (19 мм), Черный</p>
        </li>
        <li class="card-item">
            <p>Cтекло:</p>
            <p>Прозрачное</p>
        </li>
    </ui>
    <ui class="card">
        <li class="card-top">
            <p>#1401</p>
            <p>28.12.2023 18:53</p>
            <p>Фасад 1/12</p>
        </li>
        <li class="card-item">
            <p>Высота:</p>
            <p>2470</p>
        </li>
        <li class="card-item">
            <p>Ширина:</p>
            <p>2470</p>
        </li>
        <li class="card-item">
            <p>Профиль:</p>
            <p>Узкий (19 мм), Черный</p>
        </li>
        <li class="card-item">
            <p>Cтекло:</p>
            <p>Прозрачное</p>
        </li>
    </ui>
</div>
</body>

</html>
