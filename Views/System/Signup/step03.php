<section><!--プロフィール登録-->
    <div class="width412px">
        <h2>講師登録が完了しました！</h2>
        <div class="step-group">
            <div class="step">
                <div class="step-no">1</div>
                <div class="step-title">プロフィール入力</div>
            </div>
            <div class="step-next">&gt;</div>
            <div class="step">
                <div class="step-no">2</div>
                <div class="step-title">登録情報の確認</div>
            </div>
            <div class="step-next">&gt;</div>
            <div class="step selected">
                <div class="step-no">3</div>
                <div class="step-title">登録完了</div>
            </div>
        </div>
        <p><?= $data['email'] ?>宛に確認メールを送信しました。<br>
            メールが届かない場合は@<?= $_SERVER['HTTP_HOST'] ?>の<br>ドメイン受信設定を行ってください。<br>
            <a href="/confirm-mail?type=resend" onclick="confirm('確認メールを再送信します。\nよろしいですか？')">確認メールを再送信</a>
        </p><a href="/user/profile/<?= $_SESSION['user_id'] ?>">マイページへ</a>
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
