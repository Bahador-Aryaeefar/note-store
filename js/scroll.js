$(document).ready(function(){

    let hh = parseInt($("#ms").css("height").replace("px",""))/parseInt($("#cont").css("height").replace("px",""))*100;
    $("#ins").css("height",hh + "%");
    let scale = parseInt($("#cont").css("height").replace("px",""))/parseInt($("#ms").css("height").replace("px",""));
    let emo = 70/scale;
    let max = parseInt($("#ms").css("height").replace("px","")) - parseInt($("#ins").css("height").replace("px",""));
    $("#ins").addClass("chov");

    $(window).resize(function(){
        hh = parseInt($("#ms").css("height").replace("px",""))/parseInt($("#cont").css("height").replace("px",""))*100;
        $("#ins").css("height",hh + "%");
        scale = parseInt($("#cont").css("height").replace("px",""))/parseInt($("#ms").css("height").replace("px",""));
        emo = 70/scale;
        max = parseInt($("#ms").css("height").replace("px","")) - parseInt($("#ins").css("height").replace("px",""));
        let mo = 0;
        moves = mo;
        $("#ins").css("top",mo + "px");
        mo = mo * scale;
        mo *= -1;
        $("#cont").css("margin-top",mo + "px");
    });

    $("#ins").mousedown(function (event){
        event.preventDefault();
        let y = event.clientY;
        $("#ins").removeClass("chov");
        $(this).css("background-color","#881718")
        $(document).mousemove(function (event){
            let dif = event.clientY - y;
            y = event.clientY;
            let move = parseInt($("#ins").css("top").replace("px",""))+dif;
            if(move<0) move = 0;
            if(move>max) move = max;
            moves = move;
            $("#ins").css("top",move + "px");
            move = move * scale;
            move *= -1;
            $("#cont").css("margin-top",move + "px");
        });
        $(document).mouseup(function (){
            $(this).off("mousemove");
            $(this).off("mouseup");
            $(this).off("mouseleave");
            $("#ins").addClass("chov");
            $("#ins").css("background-color","#f14748")
        });
        $(document).mouseleave(function (){
            $(this).off("mousemove");
            $(this).off("mouseup");
            $(this).off("mouseleave");
            $("#ins").addClass("chov");
            $("#ins").css("background-color","#f14748")
        });
    });

    let moves=0;
    let bmoves=0;
    let difm = 0;
    let isup=false;
    $("#hold").bind("mousewheel DOMMouseScroll", function(event){
        $("#ins").stop();
        $("#cont").stop();
        if($("#ins").css("top") !== (moves+"px"))
        {
            difm = moves - parseInt($("#ins").css("top").replace("px",""));
        }
        else
        {
            difm = 0;
        }
        if(event.originalEvent.wheelDelta > 0 || event.originalEvent.detail < 0){
            if(!isup)
            {
                difm=0;
            }

            moves = parseInt($("#ins").css("top").replace("px","")) - emo + difm;
            if(moves<0) moves = 0;
            else if(moves>max) moves = max;
            else {event.preventDefault();}
            $("#ins").animate({"top": moves + "px"},200);
            bmoves = moves * scale;
            bmoves *= -1;
            $("#cont").animate({"margin-top": bmoves + "px"},200);
            isup = true;
        }
        else{
            if(isup)
            {
                difm=0;
            }
            moves = parseInt($("#ins").css("top").replace("px","")) + emo + difm;
            if(moves<0) moves = 0;
            else if(moves>max) moves = max;
            else {event.preventDefault();}
            $("#ins").animate({"top": moves + "px"},200);
            bmoves = moves * scale;
            bmoves *= -1;
            $("#cont").animate({"margin-top": bmoves + "px"},200);
            isup = false;
        }
    });

    $("#ms").mousedown(function (event) {
        event.preventDefault();
        if(event.target.id === "ins") return;
        $("#ins").removeClass("chov");
        $("#ins").css("background-color","#881718")
        let m = event.offsetY - parseInt($("#ins").css("height").replace("px",""))/2;
        if(m<0) m = 0;
        if(m>max) m = max;
        moves = m;
        $("#ins").animate({"top": m + "px"},500);
        m = m * scale;
        m *= -1;
        $("#cont").animate({"margin-top": m + "px"},500);

        $("#ms").mouseup(function () {
            $("#ins").addClass("chov");
            $("#ins").css("background-color","#f14748")
            $("#ins").stop();
            $("#cont").stop();
            moves = parseInt($("#ins").css("top").replace("px",""));
            $(this).off("mouseup");
            $(this).off("mouseleave");
        });

        $("#ms").mouseleave(function () {
            $(this).trigger("mouseup");
        });

    });

});