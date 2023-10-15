<?php

include 'connect.php';
// Routes

$tpl = 'includes/templates/';
$lang = 'includes/languages/';
$func = 'includes/functions/';
$css = 'layout/css/';
$js = 'layout/js/';


include $lang . 'english.php';
include $tpl . 'header.php';
include $func . 'functions.php';


if (!isset($noNavbar)) {
    include $tpl . 'navbar.php';
}