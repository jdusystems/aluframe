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
        .header{
            display: inline-block;
            width: 100%;
            padding-top: 34px;
            padding-bottom: 30px;
            margin-bottom:20px;
            border-bottom: 1px dotted rgb(18, 18, 18,.2);
        }
        .header-left{
            float: right;

        }
        .title{
            float: left;
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

            width: 100%;
            padding-bottom: 27px;
            border-bottom: 1px dotted rgb(18, 18, 18,.2);

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
            color: #121212;
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
            text-align:left;
            color: #121212;
            font-family: Inter;
            font-size: 12px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;

        }
        .list-text2{
            padding: 9px;
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

            width: 100%;
            margin-top: 50px;
            margin-bottom: 20px;
        }

        .wrap-tile{
            color: #121212;
            float: left;
            font-family: Inter;
            font-size: 20px;
            font-style: normal;
            font-weight: 700;
            line-height: normal;
            width: 100%;
        }
        .pdf{
            width: 100%;
            display: inline-block;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .pdf-text{
            float: left;
            width: 310px;
            color: #121212;
            font-family: Inter;
            font-size: 13px;
            font-style: normal;
            font-weight: 500;
            line-height: 18px; /* 138.462% */
        }

        .pdf-wrap{
            float: right;
            width: 300px;
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
            max-width: 300px;
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
            <span class="text">#2121</span>
            <span class="text">28.12.2023 18:53</span>
        </div>
    </header>
    <table class="list">
        <tr class="list-item">
            <th class="list-text">Профиль</th>
            <th class="list-text">Узкий (19 мм), Черный</th>
        </tr>
        <tr class="list-item">
            <th class="list-text">Цвет стекла:</th>
            <th class="list-text">Прозрачное</th>
        </tr>
        <tr class="list-item">
            <th class="list-text">Дополнительные услуги для стекла:</th>
            <th class="list-text">Доп. услуги не требуются</th>
        </tr>
        <tr class="list-item">
            <th class="list-text">Тип открывания:</th>
            <th class="list-text">Узкий</th>
        </tr>
        <tr class="list-item">
            <th class="list-text">Количество петель:</th>
            <th class="list-text">Узкий</th>
        </tr>
        <tr class="list-item">
            <th class="list-text">Высота:</th>
            <th class="list-text">Узкий</th>
        </tr>
        <tr class="list-item">
            <th class="list-text">Ширина:</th>
            <th class="list-text">Узкий</th>
        </tr>
        <tr class="list-item">
            <th class="list-text">Кол-во L:</th>
            <th class="list-text">Узкий</th>
        </tr>
        <tr class="list-item">
            <th class="list-text">Кол-во R:</th>
            <th class="list-text">Узкий</th>
        </tr>
        <tr class="list-item">
            <th class="list-text">Ручка:</th>
            <th class="list-text">Узкий</th>
        </tr>
        <tr class="list-item">
            <th class="list-text">Присака станд.?:</th>
            <th class="list-text">Узкий</th>
        </tr>
        <tr class="list-item">
            <th class="list-text">Комментарий:</th>
            <th class="list-text">Узкий</th>
        </tr>
    </table>
    <div class="wrap">
        <h3 class="wrap-tile">Спецификация</h3>
        <div class="header-left">
            <span class="text">#2121</span>
            <span class="text">28.12.2023 18:53</span>
        </div>
    </div>

    <table class="list">
        <tr class="list-top">
            <th class="list-text1 list-text2">Код товара</th>
            <th class="list-text1 list-text2">Наименование</th>
            <th class="list-text1 list-text2">Кол-во</th>
        </tr>
        <tr class="list-item">
            <th class="list-text1">2109</th>
            <th class="list-text1">Наименование</th>
            <th class="list-text1">1</th>
        </tr>
        <tr class="list-item">
            <th class="list-text1">Uplot Transparent</th>
            <th class="list-text1">Наименование</th>
            <th class="list-text1">1</th>
        </tr>
        <tr class="list-item">
            <th class="list-text1">Ugolok 62</th>
            <th class="list-text1">Наименование</th>
            <th class="list-text1">1</th>
        </tr>
        <tr class="list-item">
            <th class="list-text1">Glass4</th>
            <th class="list-text1">Наименование</th>
            <th class="list-text1">1</th>
        </tr>
        <tr class="list-item">
            <th class="list-text1">Zakalka</th>
            <th class="list-text1">Наименование</th>
            <th class="list-text1">1</th>
        </tr>
        <tr class="list-item">
            <th class="list-text1">Sborka stand Updated</th>
            <th class="list-text1">Наименование</th>
            <th class="list-text1">1</th>
        </tr>
        <tr class="list-item">
            <th class="list-text1">2108 Black</th>
            <th class="list-text1">Наименование</th>
            <th class="list-text1">1</th>
        </tr>
    </table>
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
