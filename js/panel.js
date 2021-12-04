function addEl(lay,name,type,topic,link) {
    let a = $("<a class='open' href='../php/panel.php?name=" + name + "'></a>");
    let bthing = $("<div class='bthing"+lay+"'></div>");
    bthing.append(a);
    bthing.append("<div class='thing"+lay+"'></div>")
    bthing.append("<div class='txtt"+lay+"'>" + name + "</div>");
    bthing.append("<div class='typet"+lay+"'>" + type + "</div>");
    bthing.append("<div class='topict"+lay+"'>" + topic + "</div>");
    bthing.append("<a href='" + link + "'> <div class='delete"+lay+"'></div> </a>");
    $("#cont").append(bthing);
}

let isSaved = true;

$(document).ready(function(){

    $("#addp").slideUp(0);
    let isSu = true;
    $("#sui").click(function (){
        $("#sui1").stop();
        $("#sui2").stop();
        $("#pad").stop();
        $("#hold").stop();
        if(isSu) {
            $("#sui1").animate({"right": "25px"}, 300);
            $("#sui2").animate({"right": "35px"}, 300);
            $("#pad").animate({"width": "0"},300);
            $("#hold").animate({"width": "97%"},300);
            isSu = false;
        }
        else {
            $("#sui1").animate({"right": "0px"}, 300);
            $("#sui2").animate({"right": "10px"}, 300);
            $("#pad").animate({"width": "25.5%"},300);
            $("#hold").animate({"width": "70%"},300);
            isSu = true;
        }
        setTimeout(function (){$(window).trigger("resize")},300);
    });

    let layup = true;
    $(".layof").click(function () {
        $("#laypic").stop();
        $(this).parent().stop();
        if(layup) {
            $("#laypic").css("transform", "rotate(180deg)");
            $(this).parent().animate({"height":"123px"},500);
            layup = false;
        }
        else {
            $("#laypic").css("transform", "rotate(0deg)");
            $(this).parent().animate({"height":"40px"},500);
            layup = true;
        }
    });


    $("#noteF").on("input",function () {
        isSaved = false;
        let aVal = $(this).val().replaceAll("\n",",,n");
        $("#aSave").attr("href","save.php?name=" + $(this).attr("name") + "&cont="+aVal);
    });

    let isrot = false;
    $("#add").click(function () {
        $(this).stop();
        $("#addp").stop();
        if(!isrot) {
            $(this).css("transform", "rotate(135deg)");
            isrot = true;
        }
       else{
            $(this).css("transform", "rotate(0deg)");
            isrot = false;
        }
       if(issel) $("#select").trigger("click");
       $("#addp").slideToggle(200);
    });

    function moenter() {
        $(".selected").removeClass("selected");
        $(this).addClass("selected");
    }

    let tempel = 0;
    let issel = false;
    $("#select").click(function (event) {
        $("#licon").stop();
        $("#insel").stop();
        let cont =  4 * 37 + 4;
        if(!issel) {
            $("#licon").css("transform","rotate(180deg)");
            $("#insel").animate({"height" : cont + "px"},300);
            $(".option").mouseenter(moenter);
            issel = true;
        }
        else {
            $(".option").off("mouseenter");
            $("#licon").css("transform","rotate(0deg)");
            $("#insel").animate({"height" : "37px"},300);
            let tempt = $(event.target);
            if(tempt.html() !== "" && tempt.hasClass("option")) {
                $("#first").html(tempt.html());
                $(".selected").removeClass("selected");
                tempt.addClass("selected");

                if($(".selected").html() === "جعبه")  tempel = 1;
                else if($(".selected").html() === "تودو")  tempel = 2;
                else if($(".selected").html() === "هفته")  tempel = 3;
            }
            $(".selected").removeClass("selected");
            if(tempel === 1)  $("#second").addClass("selected");
            else if(tempel === 2)  $("#third").addClass("selected");
            else if(tempel === 3)  $("#fourth").addClass("selected");
            issel = false;
        }
        if($("#first").html() !== "نوع") $("#first").css("color","#000000");
    });

    $(document).click(function (event) {
        if(!($(event.target).parents("#select").length === 1))
        {
            if(issel) $("#select").trigger("click");
        }
    });

    let addInfo = "";
    $("#addb").click(function (event) {
        let name = $("#name").val();
        let subject = $("#subject").val();
        let type = $("#first").html();

        addInfo = "name=" + name + "&subject=" + subject + "&type=" + type;

        if(name === "" || subject === "" || type === "نوع"){
            event.preventDefault();
            $("#err").html("کمبود");
        }

        else {
            $("#addLink").attr("href","../../blank/php/add.php?" + addInfo);
        }
    });

    $("#cancel").click(function () {
        $("#name").val("");
        $("#subject").val("");
        $("#first").html("نوع");
        $("#first").css("color","#757575");
        $(".selected").removeClass("selected");
        tempel = 0;
        $("#err").html(" ");
        $("#add").trigger("click");
    });

});