$(document).ready(function()
{
    $(".header .menu ul li.parent").mouseenter(function(){
        $(this).find('ul.submenu').fadeIn(600);
    }).mouseleave(function(){
        $(this).find('ul.submenu').fadeOut(600);
    });
});