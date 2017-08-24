$(function(){
    // 画像クリック
    $("#img_list .img").click(function(){
        // クリックされた画像を保存
        let item = $(this);
        // 全ての画像を全件捜査
        $('#img_list').find('.img').each(function(){
            //クリックされた画像ならチェックを切り替える
            if (item.is($(this))) {
                $(this).find('img').toggleClass('checked');
            } else {
                //クリックされていない画像はチェックを外す
                $(this).find('img').removeClass('checked');
            }
        });
        // チェックされた時
        if (item.find('img').hasClass('checked')){
            // 選択された画像を設定
            $("#preview").attr("src", item.find('img').attr("src"));
            $('input[name="data[image]"]:text').val($("#preview").attr("src"));
        } else {
            // チェックが外れた時は選択画像の設定を解除
            $("#preview").attr("src", "/images/cover/noimage.svg");
            $('input[name="data[image]"]:text').val('');
        }
    });
});
