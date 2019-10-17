$(document).ajaxStart(function () {
    $('body').append("<div class='loading' id='loading'><div class='loader' id='loader'></div></div>");
    $('body').css('overflow-y', 'hidden');
});
$(document).ajaxStop(function () {
    $('#loading').remove();
    $('body').css('overflow-y', 'auto');
});
$(document).ajaxError(function( event, request, settings ) {
    if(request.status == 401 || request.status == 500){
        console.error(request);
    }
});
