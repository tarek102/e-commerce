<?php

function lang($phrase) {

    static $lang = [

        // Navigation

        'HOME_ADMIN'    => 'Admin',
        'CATEGORIES'    => 'Sections',
        'ITEMS'         => 'Items',
        'MEMBERS'       => 'Members',
        'STATISTICS'    => 'Statistics',
        'LOGS'          => 'Logs',
        
    ];
    return $lang[$phrase];
}