$(function(){

    /**
     * ドロップエリアの表示を設定する
     * @param  {string} borderStyle 線の種類
     * @param  {string} color       色
     * @param  {string} msg         表示メッセージ
     * @return {void}
     */
    var setDropArea = function(borderStyle, color, msg) {
        $("#drop_area").css('border', '2px ' + borderStyle + ' ' + color);
        $("#drop_area p").text(msg);
        $("#drop_area p").css('color', color);
        $("#drop_area img").attr('src', '/images/upload_icon.svg');
    };

    /**
     * ラジオボタンが切り替えられたとき
     */
    $("input[name=cover]:radio").change(function(){
        // アニメーションの時間(ミリ秒)
        let ms = 200;
        // 選択されたラジオボタンに対応した表示に切り替え
        if ($(this).val() == "custom") {
            $("#default_cover").fadeOut(ms);
            $("#custom_cover").fadeIn(ms);
        } else {
            $("#custom_cover").fadeOut(ms);
            $("#default_cover").fadeIn(ms);
        }
        // 画像の選択履歴をクリア
        $("#preview").attr("src", "/images/cover/noimage.svg");
        $("#img_list .checked").removeClass("checked");
        setDropArea('dotted', '#8e8e8e', 'クリックして画像を選択');
        $("input[name=lesson_image]:text").val('');
    });

    /**
     * レッスン名が書き換えられた時プレビューに反映する
     * @param  {Event} e イベントオブジェクト
     * @return {void}
     */
    $("input[name=lesson_name]:text").keyup(function(e){
        $(".profile-text").find(".lesson-name").text($(this).val());
    });

    /**
     * レッスン内容が書き換えられた時プレビューに反映する
     * @param  {Event} e イベントオブジェクト
     * @return {void}
     */
    $("textarea[name=lesson_about]").keyup(function(e){
        $(".profile-text").find(".lesson-about").text($(this).val());
    });

    /**
     * ファイルが切り替えられた時非同期でアップロードする
     * @param  {Event} e イベントオブジェクト
     * @return {void}
     */
    $("#file").on('change', function(e){

        // ファイル取得
        var file = e.target.files[0];

        // 非同期でアップロード開始
        upload(file);
    });

    /**
     * D&Dしてきたときブラウザ標準の挙動をキャンセルする
     * @param  {Event} e イベント
     * @return {void}
     */
    var cancel = function(e){
        e.stopPropagation();
        e.preventDefault();
    };

    /**
     * ドロップエリアのイベント
     */
    $("#drop_area").on({
        // D&Dエリアがクリックされた時input[type=file]のクリックを発火させる
        'click': function() {
            $("#file").click();
        },
        // ドラッグしてきたとき表示を変える
        'dragenter': function(e) {
            cancel(e);
            setDropArea('solid', '#8e8e8e', 'ドロップして画像をアップ');
        },
        'dragover' : function(e) {
            cancel(e);
            setDropArea('solid', '#8e8e8e', 'ドロップして画像をアップ');
        },
        'dragleave': function(e) {
            cancel(e);
            setDropArea('dotted', '#8e8e8e', 'クリックして画像を選択');
        },
        // ドロップされた時
        'drop': function(e){
            // 表示を戻す
            cancel(e);
            setDropArea('dotted', '#8e8e8e', 'クリックして画像を選択');
            // ファイル取得
            var files = e.originalEvent.dataTransfer.files;
            // 複数アップされた時は処理しない
            if(files.length > 1){
                return false;
            }
            // 非同期でアップロード開始
            upload(files[0]);
        }
    });

    /**
     * ファイルがエラーの時のドロップエリアの表示設定
     * アイコン画像をエラー色に上書きする
     * @param  {string} msg 表示メッセージ
     * @return {void}
     */
    var error = function(msg){
        setDropArea('dotted', 'rgb(230, 89, 89)', msg);
        $("#drop_area img").attr('src', '/images/upload_icon_error.svg');
    };

    /**
     * ファイルの保存に成功した時のドロップエリアの表示設定
     * アイコン画像を成功色に上書きする
     * @param  {string} msg 表示メッセージ
     * @return {void}
     */
    var success = function(msg){
        setDropArea('dotted', 'rgb(89, 230, 89)', msg);
        $("#drop_area img").attr('src', '/images/upload_icon_success.svg');
    };

    /**
     * ファイルの簡易チェックを行う
     * @param  {File}    file チェックするファイル
     * @return {boolean}      チェックOKならtrue、だめならfalseを返す
     */
    var check = function(file){
        // ファイルサイズが2MBを超えているものは受け付けない
        if (file.size > 2000000) {
            error('2MB以上のファイルはアップできません');
            return false;
        }
        // 画像ファイルでないものは受け付けない
        if (file.type.indexOf("image") == -1) {
            error('画像ファイルを選択してください');
            return false;
        }
        return true;
    };

    /**
     * AJAXでファイルをアップロードする
     * @param  {File} file ファイル
     * @return {void}
     */
    var upload = function(file){

        // ファイルの簡易チェック
        if (!check(file)) {
            return false;
        }

        // アップしたファイルをプレビューする用
        var fileReader = new FileReader();
        var fd = new FormData();
        fd.append('file', file);
        // AJAX
        $.ajax({
            // ファイルをPOST送信するURL
            url: '/ajax/fileupload/',
            // メソッドの種類
            type: 'POST',
            // 添付データ
            data: fd,
            processData: false,
            contentType: false,
            // 非同期通信
            xhr : function(){
                var XHR = $.ajaxSettings.xhr();
                // 進捗を表示するためのイベントリスナー
                XHR.upload.addEventListener('progress',function(e){
                    // 進捗度合いの計算
                    var prog = parseInt(e.loaded / e.total * 100);
                    var width = prog * 394 / 100;
                    // 進捗をプログレスバーに表示
                    $('#progress').css('width', width + 'px');
                });
                return XHR;
            },
            // ファイルアップロード成功時
            success: function(result){
                // プレビューに画像を表示
                fileReader.onload = function() {
                    $('#preview').attr('src', fileReader.result);
                }
                fileReader.readAsDataURL(file);
                // プログレスバーの表示を元に戻して、ドロップエリアのメッセージをファイル名に変更
                setTimeout(function(){
                    $('#progress').css('width', '0px');
                    success(file.name);
                },500);
                console.log(result.fileName);
                $("input[name=lesson_image]").val(result.fileName);
            },
            // 失敗
            error: function(result){
                console.log(result);
                error(result.responseText);
            }
        });
    };
});
