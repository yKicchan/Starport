<section><!--プロフィール登録-->
    <div class="width412px">
        <h2>プロフィール登録</h2>
        <div class="row">
            <img src="<?= $_SESSION['data']['facebook_photo_url'] ?>">
        </div>
        <form method="post" action="/system/signup/confirm">
            <!-- エラーメッセージ -->
            <caption><?= $data['msg'] ?></caption>
            <div class="form-group inline">
                <input type="text" class="form-control form148" name="data[last_name]" placeholder="姓(必須)" value="<?= $_SESSION['data']['last_name'] ?>"　required>
            </div>
            <div class="form-group inline">
                <input type="text" class="form-control form148" name="data[first_name]" placeholder="名(必須)" value="<?= $_SESSION['data']['first_name'] ?>"　required>
            </div>
            <div class="form-group inline">
                <input type="email" class="form-control form300" name="data[email]" placeholder="Eメール(必須)" value="<?= $_SESSION['data']['email'] ?>" required>
            </div>
            <div class="form-group inline">
                <input type="text" class="form-control form300" name="data[university]" placeholder="大学(必須)" value="<?= $_SESSION['data']['university'] ?>" required>
            </div>
            <div class="form-group inline">
                <input type="text" class="form-control form148" name="data[faculty]" placeholder="学部(必須)" value="<?= $_SESSION['data']['faculty'] ?>">
            </div>
            <div class="form-group inline">
                <input type="text" class="form-control form148" name="data[course]" placeholder="学科(任意)" value="<?= $_SESSION['data']['course'] ?>">
            </div>
            <div class="form-group inline">
                自己紹介文（必須）
                <textarea class="form-control form300" name="data[introduction]" placeholder="例：テニスサークル○○所属、特技は筋トレ、趣味は映画鑑賞など" ><?= $_SESSION['data']['introduction'] ?></textarea>
            </div>
            <div class="form-group inline">
                キャッチフレーズ(30字以内任意)
                <input type="text" class="form-control form300" name="data[phrase]" placeholder="例：stay foolish, stay hungry." maxlength="30" value="<?= $_SESSION['data']['phrase'] ?>">
            </div>
            <div class="form-group inline">
                Twitter ID(任意)
                <input type="text" class="form-control form300" name="data[twitter]" placeholder="例:starportcom(@以降)" value="<?= $_SESSION['data']['twitter'] ?>">
            </div>
            <div class="form-group inline">
                Instagram ID(任意)
                <input type="text" class="form-control form300" name="data[instagram]" placeholder="例:starportcom" value="<?= $_SESSION['data']['instagram'] ?>">
            </div>
            <div class="form-group inline form300">
                <input type="checkbox" name="confirmation" required><a href="/info/terms">利用規約</a>と<a href="/info/privacy">プライバシーポリシー</a>に同意する。
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
