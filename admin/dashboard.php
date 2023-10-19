<?php

session_start();


if (isset($_SESSION['Username'])) {
    $pageTitle = 'Dashboard';
    include 'init.php';
    echo 'Home';
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
    exit();
}
