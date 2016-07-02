$(function goto(id){ 
    $("#nav-home").click(function(){ 
        var scroll_offset = $('#home').offset();
        $("body,html").animate({
            scrollTop:scroll_offset.top  //让body的scrollTop等于pos的top，就实现了滚动
        },500);
    }); 
    $("#nav-product").click(function(){ 
        var scroll_offset = $('#intro').offset();
        $("body,html").animate({
            scrollTop:scroll_offset.top  //让body的scrollTop等于pos的top，就实现了滚动
        },800); 
    }); 
    $("#nav-self").click(function(){ 
        $('html,body').scrollTo('#report',1000); 
    }); 
    $("#nav-contact").click(function(){ 
        $('html,body').scrollTo('#contact',1200); 
    });

}); 