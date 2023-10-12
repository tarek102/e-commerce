<?php

function lang($phrase) {

    static $lang = [

        // Dashboard Page

        'HOME_ADMIN' => 'Admin',
        'CATEGORIES' => 'Sections',
        '' => '',
        '' => '',
        '' => '',
        
    ];
    return $lang[$phrase];
}