$(function(){
    /**
     * レッスン名が書き換えられた時プレビューに反映する
     * @param  {Event} e イベントオブジェクト
     * @return {void}
     */
    $('input[name="data[name]"]:text').keyup(function(e){
        $(".profile-text").find(".lesson-name").text($(this).val());
    });

    /**
     * レッスン内容が書き換えられた時プレビューに反映する
     * @param  {Event} e イベントオブジェクト
     * @return {void}
     */
    $('textarea[name="data[about]"]').keyup(function(e){
        $(".profile-text").find(".lesson-about").text($(this).val());
    });
});
