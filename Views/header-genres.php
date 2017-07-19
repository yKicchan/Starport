<!--トップに表示される、ジャンル一覧の黒いバー-->
<div class="wrapper" id="genres">
    <div class="genres-back">
        <div class="contents__inner">
            <nav>
                <ul class="menu">
                    <?php foreach ($data['genre'] as $g) { ?>
                        <li class="menu__mega">
                            <a  class="init-bottom" href="/lesson/genre/<?= $g['url'] ?>/"><?= $g['name'] ?></a>
                            <!--
                            <ul class="menu__second-level">
                                <?php foreach ($data['content'][$g['id']] as $c) { ?>
                                <li><a href="/lesson/content/<?= $g['url'] . '/' . $c['url'] ?>/"><?= $c['name'] ?></a></li>
                                <?php } ?>
                            </ul>
                            -->
                        </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </div>
</div>
<style>
    .wrapper {
        width: 100%;
        text-align: center;
        font-size: 13px;
    }
    .genres-back{
        background-color:rgb(33, 25, 18);
    }
    .contents__inner {
        box-sizing: border-box;
        width: 100%;
        color: #fff;
    }
    /* --------------------------------------------------- menu */
    .menu {
        position: relative;
        width: 100%;
        height: 30px;
        margin: 0 auto;
        list-style:none;
    }

    .menu > li {
        float: left;
        width: 14.28%;
        height: 30px;
        line-height: 30px;
        background: rgb(33, 25, 18);
    }

    .menu > li a {
        display: block;
        color: #fff;
    }

    .menu > li a:hover {
        color: #fff;
        text-decoration: none;
    }

    ul.menu__second-level {
        visibility: hidden;
        opacity: 0;
        z-index: 1;
        list-style:none;
        display: table;
    }

    ul.menu__third-level {
        visibility: hidden;
        opacity: 0;
        list-style:none;
        display: table;
    }
    /* メニューホバーのうごき */
    .menu > li:hover {
        background: #ff5659;
        -webkit-transition: all .5s;
        transition: all .5s;
    }

    .menu__second-level li {
        border-top: 2px solid #111;
    }

    .menu__third-level li {
        border-top: 2px solid #111;
    }

    .menu__second-level li a:hover {
        background: #111;
    }

    .menu__third-level li a:hover {
        background: #2a1f1f;
    }
    .init-bottom:after {
        content: '';
        display: inline-block;
        border-right: 2px;
        border-right-color: white;
        border-left: 2px;
        border-left-color: white;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
    /* --------------------------------------------------- mega menu */
    li.menu__mega ul.menu__second-level {
        position: absolute;
        top: 10px;
        left: 0;
        box-sizing: border-box;
        width: 80%;
        background: #ff5659;
        -webkit-transition: all .2s ease;
        transition: all .2s ease;
    }
    li.menu__mega-right ul.menu__second-level{
        left:20%;
    }

    li.menu__mega:hover ul.menu__second-level {
        top: 30px;
        visibility: visible;
        opacity: 0.9;
    }

    li.menu__mega ul.menu__second-level > li {
        float: left;
        width: 32.63%;
        border: none;
    }

    li.menu__mega ul.menu__second-level > li:nth-child(3n+2) {
        margin: 0 1%;
    }
    ul{
        padding-left: 0px;
    }
    /* --------------------------------------------------- single menu */
    .menu > li.menu__single {
        position: relative;
    }

    li.menu__single ul.menu__second-level {
        position: absolute;
        top: 10px;
        width: 100%;
        background: #ff5659;
        -webkit-transition: all .2s ease;
        transition: all .2s ease;
    }

    li.menu__single:hover ul.menu__second-level {
        top: 30px;
        visibility: visible;
        opacity: 0.9;
    }

    /* --------------------------------------------------- multi menu */
    .menu > li.menu__multi {
        position: relative;
    }
    li.menu__multi ul.menu__second-level {
        position: absolute;
        top: 10px;
        width: 100%;
        background: #ff5659;
        -webkit-transition: all .2s ease;
        transition: all .2s ease;
    }
    li.menu__multi:hover ul.menu__second-level {
        top: 30px;
        visibility: visible;
        opacity: 0.9;
    }
    li.menu__multi ul.menu__second-level li {
        position: relative;
    }
    li.menu__multi ul.menu__second-level li:hover {
        background: #111;
    }
    li.menu__multi ul.menu__second-level li ul.menu__third-level {
        position: absolute;
        top: -2px;
        left: 100%;
        width: 100%;
        background: #111;
        -webkit-transition: all .2s ease;
        transition: all .2s ease;
    }
    li.menu__multi ul.menu__second-level li:hover ul.menu__third-level {
        visibility: visible;
        opacity: 0.9;
    }
    li.menu__multi ul.menu__second-level li ul.menu__third-level li {
        position: relative;
    }
    li.menu__multi ul.menu__second-level li ul.menu__third-level li:hover {
        background: #2a1f1f;
    }
    li.menu__multi ul.menu__second-level li ul.menu__third-level li ul.menu__fourth-level {
        position: absolute;
        top: -2px;
        left: 100%;
        width: 100%;
        background: #2a1f1f;
        -webkit-transition: all .2s ease;
        transition: all .2s ease;
    }
    li.menu__multi ul.menu__second-level li ul.menu__third-level li:hover ul.menu__fourth-level {
        visibility: visible;
        opacity: 0.9;
    }
    .init-right:after {
        content: '';
        display: inline-block;
        width: 6px;
        height: 6px;
        margin: 0 0 0 15px;
        border-right: 2px solid #fff;
        border-top: 2px solid #fff;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }

</style>
