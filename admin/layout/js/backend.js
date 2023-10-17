$(function () {
    'use strict';

    // Hide placeholder on focus 
    $('[placeholder]').focus(function() {
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function() {
        $(this).attr('placeholder', $(this).attr('data-text'));
    });

    $('input').each(function(){
        if ($(this).attr('required') === 'required') {
            $(this).after('<span class="asterisk">*</span>');
        }
    });

    $('.show-pass').hover(function(){
        $('.password').attr('type', 'text');
    }, function () {
        $('.password').attr('type', 'password');
    })
})