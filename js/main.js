$(document).ready(function(){

    let iseye = false;
    let focused = "";
    $(".input").focus(function(){
        focused = "#" + $(this).attr('id');
    });
    $("#eye").click(function(){
        if(!iseye) {
            $(this).css("background-image", "url('../img/eye.png')");
            $("#password").attr("type","text");
            $("#repass").attr("type","text");
            $(focused).focus().val($(focused).val());
            iseye = true;
        }
        else {
            $(this).css("background-image", "url('../img/uneye.png')");
            $("#password").attr("type","password");
            $("#repass").attr("type","password");
            $(focused).focus().val($(focused).val());
            iseye = false;
        }
    });


});