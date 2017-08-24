$(function () {
    var isSubmit = false;
    $(window).on('beforeunload', function () {
        if (!isSubmit) {
            return "このページを離れようとしています";
        }
    });
    $("button[type=submit]").click(function(){
        isSubmit = true;
    });
});
