<section><!--プロフィール登録-->
    <div class="width412px">
        <h2>プロフィール登録</h2>
        <div class="row">
            <img src="<?= $_SESSION['fb_photo_url'] ?>">
        </div>
        <form method="post" action="/user/register/confirm">
            <!-- エラーメッセージ -->
            <caption><?= $data['msg'] ?></caption>
            <div class="form-group inline">
                <input type="text" class="form-control form148" name="last_name" placeholder="姓(必須)" value="<?= $_SESSION['last_name'] ?>"　required>
            </div>
            <div class="form-group inline">
                <input type="text" class="form-control form148" name="first_name" placeholder="名(必須)" value="<?= $_SESSION['first_name'] ?>"　required>
            </div>
            <div class="form-group inline">
                <input type="email" class="form-control form300" name="email" placeholder="Eメール(必須)" value="<?= $_SESSION['email'] ?>" required>
            </div>
            <div class="form-group inline">
                <input type="text" class="form-control form300" name="university" placeholder="大学(必須)" value="<?= $_SESSION['university'] ?>" required>
            </div>
            <div class="form-group inline">
                <input type="text" class="form-control form148" name="faculty" placeholder="学部(必須)" value="<?= $_SESSION['faculty'] ?>"　required>
            </div>
            <div class="form-group inline">
                <input type="text" class="form-control form148" name="course" placeholder="学科(任意)" value="<?= $_SESSION['course'] ?>">
            </div>
            <div class="form-group inline">
                自己紹介文（必須）
                <textarea class="form-control form300" name="introduction" placeholder="例：テニスサークル○○所属、特技は筋トレ、趣味は映画鑑賞など" required><?= $_SESSION['introduction'] ?></textarea>
            </div>
            <div class="form-group inline">
                キャッチフレーズ(30字以内任意)
                <input type="text" class="form-control form300" name="phrase" placeholder="例：stay foolish, stay hungry." maxlength="30" value="<?= $_SESSION['phrase'] ?>">
            </div>
            <div class="form-group inline">
                Twitter ID(任意)
                <input type="text" class="form-control form300" name="twitter" placeholder="例:starportcom(@以降)" value="<?= $_SESSION['twitter'] ?>">
            </div>
            <div class="form-group inline">
                Instagram ID(任意)
                <input type="text" class="form-control form300" name="instagram" placeholder="例:starportcom" value="<?= $_SESSION['instagram'] ?>">
            </div>
            <div class="form-group inline form300">
                <input type="checkbox" name="confirmation" required><a href="/info/terms">利用規約</a>と<a href="/info/privacy_policy">プライバシーポリシー</a>に同意する。
            </div>
            <div class="form-group">
                <button name="submit" type="submit" class="btn btn-default">完了！</button>
            </div>
        </form>

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
