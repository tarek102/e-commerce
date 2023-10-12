<?php

session_start();


if (isset($_SESSION['Username'])) {
    // echo "Welcome " . $_SESSION['Username'];
    include 'init.php';
    echo "Welcome";
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
}
