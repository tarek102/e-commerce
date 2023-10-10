<?php

function lang($phrase) {

    static $lang = [
        'MESSAGE' => 'Hello',
        'Admin' => 'Adminstrator'
    ];
    return $lang[$phrase];
}