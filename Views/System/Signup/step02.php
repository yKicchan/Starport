<section><!--プロフィール登録-->
    <div class="width412px">
        <h2>登録情報の確認</h2>
        <div class="step-group">
            <div class="step">
                <div class="step-no">Step 01.</div>
                <div class="step-title">プロフィール情報の入力</div>
            </div>
            <div class="step-next">&gt;</div>
            <div class="step selected">
                <div class="step-no">Step 02.</div>
                <div class="step-title">登録情報の確認</div>
            </div>
            <div class="step-next">&gt;</div>
            <div class="step">
                <div class="step-no">Step 03.</div>
                <div class="step-title">登録完了</div>
            </div>
        </div>
        <div class="pages confirm">
            <div class="confirm-content">
                <h3 class="confirm-title">氏名</h3>
                <p><?= $_SESSION['data']['last_name'].$_SESSION['data']['first_name'] ?></p><!--名-->
                <div class="solid"></div>
                <h3 class="confirm-title">メールアドレス</h3>
                <p><?= $_SESSION['data']['email'] ?></p><!--Eメール-->
                <div class="solid"></div>
                <h3 class="confirm-title">学校名</h3>
                <p><?= $_SESSION['data']['university'] ?></p><!--大学名-->
                <div class="solid"></div>
                <?php if (!empty($_SESSION['data']['faculty'])) { ?>
                    <h3 class="confirm-title">学部・学科名</h3>
                    <p><?= $_SESSION['data']['faculty'] ?></p><!--学部-->
                    <div class="solid"></div>
                <?php } ?>
                <?php if (!empty($_SESSION['data']['introduction'])) { ?>
                    <h3 class="confirm-title">自己紹介文</h3>
                    <p><?= $_SESSION['data']['introduction'] ?></p><!--自己紹介文-->
                    <div class="solid"></div>
                <?php } ?>
            </div>
            <form method="post" action="/system/signup/step03">
                <div class="form-group agree">
                    <input type="checkbox" id="agree" required />
                    <label for="agree"><a href="/info/terms">利用規約</a>と<a href="/info/privacy">プライバシーポリシー</a>に同意する。</label>
                </div>
                <div class="form-group">
                    <a class="btn btn-default" href="/system/signup/step01">戻る</a>
                    <button id="submit" name="submit" type="submit" class="btn btn-success">確定</button>
                </div>
            </form>
            <script type="text/javascript">

                $("#submit").click(function(){
                    if (!$("#agree").prop('checked')) {
                        showErrorMsg($(".agree"), "利用規約に同意してください。");
                    }
                });

                //エラーメッセージの表示
        		var showErrorMsg = function (parent, str) {
        			parent.append("<span class=\"msg\">" + str + "</span>");
        			var msg = parent.find(".msg");
        			setTimeout(function(){
        				msg.fadeOut(1000);
        			}, 1000);
        		};
            </script>
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
