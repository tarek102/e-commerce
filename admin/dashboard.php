<?php

session_start();


if (isset($_SESSION['Username'])) {
    $pageTitle = 'Dashboard';
    include 'init.php';
    /* Dashboard Start*/

    $stmt2 = $con->prepare("SELECT count(UserID) FROM users");
    $stmt2->execute();
    echo $stmt2->fetchColumn() ;
    ?>
    <div class="container home-stat text-center">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stat">
                    Total Members
                    <span>250</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat">
                    Pending Members
                    <span>250</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat">
                    Total Items
                    <span>250</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat">
                    Total Members
                    <span>250</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container latest">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-title">
                        <i class="fa fa-users">latest registered users</i>
                    </div>
                    <div class="card-body">
                            test
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-title">
                        <i class="fa fa-tag">latest Items</i>
                    </div>
                    <div class="card-body">
                            test
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    /* Dashboard End*/
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
    exit();
}
