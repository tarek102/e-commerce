<?php


// Manage Member page 

session_start();
$pageTitle = 'Members';

if (isset($_SESSION['Username'])) {
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {
        # Manage page
    } elseif ($do == 'Edit') { # Edit Page 
    
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? 
                    intval($_GET['userid']) : 
                    0;
                    
        $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) { ?>
        
        <h1 class="text-center">Edit Member</h1>
        <div class="container">
        <form class="">
            <!-- Username Field Start -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10 col-md-8">
                    <input type="text" name="username" value="<?php echo $row['Username']?>" class="form-control form-control-lg" autocomplete="off">
                </div>
            </div>
            <!-- Username Field End -->
            <!-- Email Field Start -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label ">Email</label>
                <div class="col-sm-10 col-md-8">
                    <input type="email" name="email" value="<?php echo $row['Email']?>" class="form-control  form-control-lg" >
                </div>
            </div>
            <!-- Email Field End -->
            <!-- Password Field Start -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10 col-md-8">
                    <input type="password" name="password" class="form-control  form-control-lg" autocomplete="new-password">
                </div>
            </div>
            <!-- Password Field End -->
            <!-- Full name Field Start -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Full Name</label>
                <div class="col-sm-10 col-md-8">
                    <input type="text" name="full" value="<?php echo $row['FullName']?>" class="form-control  form-control-lg">
                </div>
            </div>
            <!-- Full name Field End -->
            <!-- Submit Field Start -->
            <div class="form-group row mb-3">
                <div class="offset-sm-2 col-sm-10 col-md-8">
                    <input type="submit" class="btn btn-primary btn-lg" value="Save">
                </div>
            </div>
            <!-- Submit Field End -->
        </form>
        </div>
        
    <?php 
       } else {
        echo "<h2 class='text-center my-5'>False ID</h2>";
       }
    }
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
    exit();
}

