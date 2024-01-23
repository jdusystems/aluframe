<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
            display: flex;
            justify-content: space-between;
            flex-direction: column;
        }
        .header{
            display: flex;
            align-items: center;
            width: 100%;
            padding-top: 34px;
            padding-bottom: 30px;
            border-bottom: 1px dotted rgb(18, 18, 18,.2);
            margin-bottom:20px;
        }
        .header-left{
            width: 100%;
            display: flex;
            gap: 17px;
        }
        .title{
            width: 100%;
            color: #121212;
            font-family: Inter;
            font-size: 32px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
            text-transform: uppercase;
        }
        .text{

            color: #121212;
            text-align: right;
            font-family: Inter;
            font-size: 14px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
        }

        .list{
            /* list-style: none; */
            padding-bottom: 37px;
            border-bottom: 1px dotted rgb(18, 18, 18,.2);

        }
        .list-item{
            padding: 8px 10px;
            display: flex;
            align-items:center;
            gap: 10px;
        }
        .list-top{
            gap: 10px;
            padding-bottom: 9px;
            display: flex;
            align-items:center;
        }
        .list-item:nth-child(2n-1){
            background-color: #f4f4f4;

        }
        .list-text{
            width: 100%;
            color: #121212;
            font-family: Inter;
            font-size: 12px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
        }
        .list-text1{
            width: 100%;
            color: #121212;
            font-family: Inter;
            font-size: 12px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;

        }
        .list-text2{
            color: rgb(18, 18, 18,.5);
        }

        .list-text1:first-child{
            max-width: 161px ;
        }
        .list-text1:nth-child(2){
            max-width: 430px ;
        }
        .list-text1:nth-child(3){
            max-width: 80px ;
        }

        .list-text2:first-child{
            max-width: 171px  !important;
        }
        .wrap{
            display: flex;
            align-items: center;
            width: 100%;
            margin-top: 50px;
            margin-bottom: 20px;
        }

        .wrap-tile{
            color: #121212;

            font-family: Inter;
            font-size: 20px;
            font-style: normal;
            font-weight: 700;
            line-height: normal;
            width: 100%;
        }
        .pdf{
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .pdf-text{
            width: 100%;
            max-width: 310px;
            color: #121212;
            font-family: Inter;
            font-size: 13px;
            font-style: normal;
            font-weight: 500;
            line-height: 18px; /* 138.462% */
        }

        .pdf-wrap{
            display: flex;
            align-items: flex-start;
            gap: 22px;
            width: 100%;
            max-width: 300px;
        }
        .pdf-imzo{
            color: rgb(18, 18, 18,.3);
            font-family: Inter;
            font-size: 12px;
            font-style: normal;
            font-weight: 500;
            line-height: 22px; /* 183.333% */
        }

        .pdf-line{
            width: 100%;
        }
        .pdf-line-wrap{
            display: flex;
            align-items: flex-end;
            gap: 16px;
            width: 100%;
        }
        .pdf-line-wrap p {
            color: #121212;
            font-family: Inter;
            font-size: 12px;
            font-style: normal;
            font-weight: 500;
            line-height: 22px; /* 183.333% */
        }
        .pdf-line-wrap div{
            width: 100%;
            max-width: 180px;
            height: 1px;
            opacity: 0.2;
            background: #121212;
        }
    </style>
</head>

<body>
<div class="container">
    <header class="header">
        <h2 class="title">Накладная</h2>
        <div class="header-left">
            <p class="text">#2121</p>
            <p class="text">28.12.2023 18:53</p>
        </div>
    </header>
    <ul class="list">
        <li class="list-item">
            <p class="list-text">Профиль</p>
            <p class="list-text">Узкий (19 мм), Черный</p>
        </li>
        <li class="list-item">
            <p class="list-text">Цвет стекла:</p>
            <p class="list-text">Прозрачное</p>
        </li>
        <li class="list-item">
            <p class="list-text">Дополнительные услуги для стекла:</p>
            <p class="list-text">Доп. услуги не требуются</p>
        </li>
        <li class="list-item">
            <p class="list-text">Тип открывания:</p>
            <p class="list-text">Узкий</p>
        </li>
        <li class="list-item">
            <p class="list-text">Количество петель:</p>
            <p class="list-text">Узкий</p>
        </li>
        <li class="list-item">
            <p class="list-text">Высота:</p>
            <p class="list-text">Узкий</p>
        </li>
        <li class="list-item">
            <p class="list-text">Ширина:</p>
            <p class="list-text">Узкий</p>
        </li>
        <li class="list-item">
            <p class="list-text">Кол-во L:</p>
            <p class="list-text">Узкий</p>
        </li>
        <li class="list-item">
            <p class="list-text">Кол-во R:</p>
            <p class="list-text">Узкий</p>
        </li>
        <li class="list-item">
            <p class="list-text">Ручка:</p>
            <p class="list-text">Узкий</p>
        </li>
        <li class="list-item">
            <p class="list-text">Присака станд.?:</p>
            <p class="list-text">Узкий</p>
        </li>
        <li class="list-item">
            <p class="list-text">Комментарий:</p>
            <p class="list-text">Узкий</p>
        </li>
    </ul>
    <div class="wrap">
        <h3 class="wrap-tile">Спецификация</h3>
        <div class="header-left">
            <p class="text">#2121</p>
            <p class="text">28.12.2023 18:53</p>
        </div>
    </div>
    <div class="list-top">
        <p class="list-text1 list-text2">Код товара</p>
        <p class="list-text1 list-text2">Наименование</p>
        <p class="list-text1 list-text2">Кол-во</p>
    </div>
    <ul class="list">
        <li class="list-item">
            <p class="list-text1">2109</p>
            <p class="list-text1">Наименование</p>
            <p class="list-text1">1</p>
        </li>
        <li class="list-item">
            <p class="list-text1">Uplot Transparent</p>
            <p class="list-text1">Наименование</p>
            <p class="list-text1">1</p>
        </li>
        <li class="list-item">
            <p class="list-text1">Ugolok 62</p>
            <p class="list-text1">Наименование</p>
            <p class="list-text1">1</p>
        </li>
        <li class="list-item">
            <p class="list-text1">Glass4</p>
            <p class="list-text1">Наименование</p>
            <p class="list-text1">1</p>
        </li>
        <li class="list-item">
            <p class="list-text1">Zakalka</p>
            <p class="list-text1">Наименование</p>
            <p class="list-text1">1</p>
        </li>
        <li class="list-item">
            <p class="list-text1">Sborka stand Updated</p>
            <p class="list-text1">Наименование</p>
            <p class="list-text1">1</p>
        </li>
        <li class="list-item">
            <p class="list-text1">2108 Black</p>
            <p class="list-text1">Наименование</p>
            <p class="list-text1">1</p>
        </li>
    </ul>
    <div class="pdf">

        <p class="pdf-text">«Товар получил в полном объеме и ассортименте. Качество
            проверил.
            Претензий не имею.»
        </p>
        <div class="pdf-wrap">
            <p class="pdf-imzo">Подпись</p>
            <div class="pdf-line">
                <div class="pdf-line-wrap">
                    <p>ФИО:</p>
                    <div></div>
                </div>
                <div class="pdf-line-wrap">
                    <p>Дата:</p>
                    <div></div>
                </div>
            </div>

        </div>
    </div>
</div>
</body>



</html>
