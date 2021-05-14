$(document).ready(function(){
    var myLi = $("#boxTop > ul > li");
    var myDiv =$("#boxCont > div");
    myLi.each(function(i){
        $(this).mouseover(function(){
            myLi.removeClass("hover");
            $(this).addClass("hover");
            myDiv.hide();
            myDiv.eq(i).show();
        })
    })
})


/*鍩庡競椤� 鏄剧ず鏇村鏈堜寒鐨勪俊鎭�*/
$(document).ready(function(){
    $("#more_rs1").click(function(){
        $(".box_rs_more").hide();
        $("#more_rs1").hide();
        $("#more_rs").show();
    });

    $("#more_rs").click(function(){
        $(".box_rs_more").show();
        $("#more_rs1").show();
        $("#more_rs").hide();
    });
});