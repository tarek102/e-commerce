<?php

// Page title function

function getTitle(){
    global $pageTitle;

    echo isset($pageTitle) ?  $pageTitle :  'Default';
}