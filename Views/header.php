<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">

        <link rel="stylesheet" type="text/css" href="/lib/bootstrap-3.3.7-dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/lib/bootstrap-xxs-1.0.2.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        <link rel="stylesheet" type="text/css" href="/css/style480.css">
        <link rel="stylesheet" type="text/css" href="/css/olb.css">

        <title>大学生の「空きスキル」を、「交換」でなくす Starport.com</title>
        <meta name="description" content="大学生の、「話したい」と「聞きたい」のマッチングサービス。魅力的なものを普及し、今まで考えもしなかったことを知れ、仲間を作る場です。">

        <link rel="icon" href="/images/icon32x32.jpg" sizes="32x32" />
        <link rel="icon" href="/images/icon192x192.jpg" sizes="192x192" />
        <link rel="apple-touch-icon-precomposed" href="/images/icon180x180.jpg" />
        <meta name="msapplication-TileImage" content="/images/icon270x270.jpg" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>
            $(function () {
                var menu = $('#slide_menu'),
                        menuBtn = $('#button'),
                        body = $(document.body),
                        // .layer もオブジェクト化
                        layer = $('.layer'),
                        menuWidth = menu.outerWidth();

                menuBtn.on('click', function () {
                    body.toggleClass('open');
                    menuBtn.toggleClass('active');
                    if (body.hasClass('open')) {
                        // css で非表示にしていた .layer を表示
                        $(".layer").show();
                        body.animate({'left': menuWidth}, 300);
                        menu.animate({'left': 0}, 300);
                    } else {
                        // .layer を非表示
                        $(".layer").hide();
                        menu.animate({'left': -menuWidth}, 300);
                        body.animate({'left': 0}, 300);
                    }
                });
                // .layer をクリック時にもメニューを閉じる
                layer.on('click', function () {
                    menu.animate({'left': -menuWidth}, 300);
                    body.animate({'left': 0}, 300).removeClass('open');
                    menuBtn.removeClass('active');
                    layer.hide();
                });
            });
        </script>
    </head>
        <nav class="navbar navbar-inverse">
            <div class="nav-container">
                <a href="/">
                    <span class="top-logo-s"><img src="/images/logo-small.png" height="50px" width="auto"></span>
                    <span class="top-logo"><img src="/images/logo.png" height="50px" width="auto"></span>
                </a>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <a class="menu-trigger" id="button">
                    <span></span>
                    <span></span>
                    <span></span>
                </a>

                <div class="nav-top">
                    <?php if (!isset($_SESSION['user_id'])) { ?>
                        <a href="/system/select/" class="navbar-right">ログイン</a>
                    <?php } else { ?>
                        <img id="accountmenu" src="<?= $_SESSION['user_img'] ?>" width="50px" height="50px" />
                        <ul class="accountmenu">
                            <li><a href="/user/profile/<?= $_SESSION['user_id'] ?>/">マイページ</a></li>
                            <li><a href="/lesson/register/input/">レッスン登録</a></li>
                            <li><a href="/setting/profile/">プロフィール編集</a></li>
                            <li><a href="/system/signout/">ログアウト</a></li>
                        </ul>
                        <script>
                            $(function () {
                                $('#accountmenu').on('click', function () {
                                    if ($('.accountmenu').css('display')==='none') {
                                        $('.accountmenu').slideDown('fast');
                                    } else {
                                        $('.accountmenu').slideUp('fast');
                                    }
                                });
                            });
                        </script>
                    <?php } ?>
                </div><!-- /.navbar-collapse -->
                <div class="layer"></div>
            </nav>
        <!-- スライドメニュー部分-->
        <div id="slide_menu">
            <div id="slide_menu_inner">
                <ul class="slide_ul">
                    <?php foreach ($data['genre'] as $g) { ?>
                        <a href="/lesson/genre/<?= $g['url'] ?>/"><h2 class="slide_h2"><?= $g['name'] ?></h2></a>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <!--メニューを出すボタン-->
    <style>
        body {
            position: relative;
            left: 0;
            overflow-x: hidden;
        }
        .slide_ul{padding-left: 0px;}
        #slide_menu{
            position: fixed;
            top: 0;
            left: -240px;
            width: 240px;
            height: 100%;
            background: #F44336;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        #menu-inner {
            width: 100%;
            height: 100%;
            overflow-y: auto;
        }
        .layer{
            position: fixed;
            top: 0;
            display: none;
            width: 100%;
            height: 100%;
            background-color: transparent;
        }
        body.open{
            position: fixed;
        }
        .slide_h2{
            height: 44px;
            width: 100%;
            font-size: 20px;
            line-height: 20px;
            padding: 12px 0px 12px 24px;
            background-color: #F44336;
            border-bottom: solid 1px #E57373;
            color: #FFEBEE;
            text-align: left;
            margin:0px;
        }
        .slide_h2 a{
            text-decoration: none;
            color: #FFEBEE;
        }
        .slide_position{
            width: 100%;
            height: 44px;
            padding: 14px 0px 14px 44px;
            border-bottom: solid 1px #E57373;
            text-align: left;
            font-size: 16px;
            line-height: 16px;
            text-decoration: none;
            color: white;
            margin: 0px;
            position: relative;
        }
        #button{
            margin: 3px 16px 0px 0px;
            top: 3px;
            float:left;
        }
        #accountmenu{
          border-radius: 25px;
        }
        .accountmenu{
            display: none;
            position: absolute;
            z-index: 1;
            background-color: #F44336;
            opacity: 0.9;
            list-style: none;
            right: -1px;
            top: 51px;
        }
        .accountmenu li a{
            display: block;
            font-size: 18px;
            padding: 4px 0px 4px 6px;
            color: #fff;
            text-align: left;
            border-bottom: solid 1px #EF9A9A;
        }
        .accountmenu li a:hover{text-decoration: none;}
        .menu-trigger,
        .menu-trigger span {
        	display: inline-block;
        	transition: all .4s;
        	box-sizing: border-box;
        }
        .menu-trigger {
        	position: relative;
        	width: 50px;
        	height: 44px;
        }
        .menu-trigger span {
        	position: absolute;
        	left: 10px;
        	width: 60%;
        	height: 2px;
        	background-color: #fff;
        	border-radius: 0px;
        }
        .menu-trigger.active span {
            border-radius: 1px;
        }
        .menu-trigger span:nth-of-type(1) {
        	top: 12px;
        }
        .menu-trigger span:nth-of-type(2) {
        	top: 20px;
        }
        .menu-trigger span:nth-of-type(3) {
            top: 28px;
        }
        .menu-trigger.active span:nth-of-type(1),
        .menu-trigger.active span:nth-of-type(3) {
        	width: 15px;
        }
        .menu-trigger.active {
            -webkit-transform: rotate(180deg);
            transform: rotate(180deg);
        }
        .menu-trigger.active span:nth-of-type(1) {
        	-webkit-transform: translate(17px,3px) rotate(45deg);
        	transform: translate(17px,3px) rotate(45deg);
        }
        .menu-trigger.active span:nth-of-type(3) {
        	-webkit-transform: translate(17px,-3px) rotate(-45deg);
        	transform: translate(17px,-3px) rotate(-45deg);
        }
    </style>
<body>
