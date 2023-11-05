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

    // Confirmation on Delete

    $('.confirm').click(function(){
        return confirm('Are you sure you want to delete this user?');
    })

    // Category view option

    $('.cat h3').click(function () {
        $(this).next('.full-view').fadeToggle(200);
    })
})