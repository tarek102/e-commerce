<?php


// Manage Member page 

session_start();


if (isset($_SESSION['Username'])) {
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {
        # Manage page
    } elseif ($do == 'Edit') {
        # Edit Page
        echo "Edit page";
    }
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
    exit();
}

