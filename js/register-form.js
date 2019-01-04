jQuery(function($){
    document.addEventListener('wpcf7mailsent', function () {
        $('.is-step1').remove();
        $('.is-step2').show();
    }, false);
});
