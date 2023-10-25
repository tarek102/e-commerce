<?php

session_start();


if (isset($_SESSION['Username'])) {
    $pageTitle = 'Dashboard';
    include 'init.php';
    /* Dashboard Start*/
    $latestUsers = getLatest('*', 'users', 'UserID', $limit = 5);
    $usersLimit = 5;
    ?>
    <div class="container home-stat text-center">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stat st-members">
                    Total Members
                    <span><a href="members.php"><?php echo countItem('UserID', 'users'); ?></a></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-pending">
                    Pending Members
                    <span><a href="members.php?do=Manage&page=Pending"><?php echo checkItem('RegStatus', 'users', 0)?></a></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-items">
                    Total Items
                    <span>250</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-comments">
                    Comments
                    <span>250</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container latest">
        <div class="row">
            <div class="col-sm-6">
                <div class="card card-latest">
                    <div class="card-title title-latest">
                        <i class="fa fa-users">latest registered <?php echo $usersLimit;?> users</i>
                    </div>
                    
                    <div class="card-body">
                        <ul class="list-unstyled latest-user">
                            <?php 
                                foreach ($latestUsers as $user) {
                                    echo "<li>";
                                        echo $user['Username'] ;
                                        echo "<a href='members.php?do=Edit&userid=" . $user['UserID'] . "'>";
                                            echo "<span class='btn btn-success'>";
                                                echo "<i class='fa fa-edit'></i> Edit";
                                            echo "</span>";
                                        echo "</a>";
                                    echo "</li>";
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card card-latest">
                    <div class="card-title title-latest">
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
