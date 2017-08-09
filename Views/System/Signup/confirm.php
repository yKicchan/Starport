<section><!--プロフィール登録-->
    <div class="width412px">
        <div class="pages confirm">
    <h2>ユーザー登録確認画面</h2>
    <h3 class="confirm-title">プロフィール画像</h3>
    <div class="lecture-profile-image">
        <img alt="img" src="<?= $_SESSION['data']['facebook_photo_url'] ?>"/><!--プロフィール画像取得-->
    </div>
    <div class="confirm-content">
        <h3 class="confirm-title">姓</h3>
        <p><?= $_SESSION['data']['last_name'] ?></p><!--姓-->
        <div class="solid"></div>
        <h3 class="confirm-title">名</h3>
        <p><?= $_SESSION['data']['first_name'] ?></p><!--名-->
        <div class="solid"></div>
        <h3 class="confirm-title">Eメール</h3>
        <p><?= $_SESSION['data']['email'] ?></p><!--Eメール-->
        <h3 class="confirm-title">大学</h3>
        <p><?= $_SESSION['data']['university'] ?></p><!--大学名-->
        <div class="solid"></div>
        <h3 class="confirm-title">学部</h3>
        <p><?= $_SESSION['data']['faculty'] ?></p><!--学部-->
        <div class="solid"></div>
        <h3 class="confirm-title">学科</h3>
        <p><?= $_SESSION['data']['course'] ?></p><!--学科-->
        <div class="solid"></div>
        <h3 class="confirm-title">自己紹介文</h3>
        <p><?= $_SESSION['data']['introduction'] ?></p><!--自己紹介文-->
        <div class="solid"></div>
        <h3 class="confirm-title">キャッチフレーズ</h3>
        <p><?= $_SESSION['data']['phrase'] ?></p><!--キャッチフレーズ-->
        <div class="solid"></div>
        <h3 class="confirm-title">TwitterID</h3>
        <p><?= $_SESSION['data']['twitter'] ?></p><!--TwitterID-->
        <div class="solid"></div>
        <h3 class="confirm-title">InstagramID</h3>
        <p><?= $_SESSION['data']['instagram'] ?></p><!--InstagramID-->
        <div class="solid"></div>
    </div>
    <a class="confirm-button bg-ffcdd2" href="/system/signup/input">戻る</a>
    <a class="confirm-button bg-ef5350" href="/system/signup/complete">登録完了！</a>
</div>
        <style>
            @media all and (min-width: 412px){
                .form148{width: 196px;
                }
                .form300{width: 400px;
                }
            }
            @media all and (max-width: 412px){
                .form148{width: 144px;
                }
                .form300{width: 300px;
                }
            }

            .form_profile{
                display: inline-block;
                text-align: left;
            }
            form{
                text-align: center;
                padding-left: 4px;
                padding-right: 4px;
            }
            .inline{
                display: inline-block;
                margin:4px 2px;
            }
        </style>
    </div>
</section>
