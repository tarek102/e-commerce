<?php


// Manage Member page 

session_start();
$pageTitle = 'Members';

if (isset($_SESSION['Username'])) {
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') { # Manage page
        
        echo "welcome to manage" . "<br>";
        echo '<a href="members.php?do=Add">Add new member</a>';

    } elseif ($do === 'Add') { # Add Memebers page
        ?>
        <h1 class="text-center">Add Member</h1>
        <div class="container">
        <form method="post" action="?do=Insert">
            <!-- Username Field Start -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10 col-md-8">
                    <input type="text" name="username" class="form-control form-control-lg" autocomplete="off" required="required" placeholder="Add your username">
                </div>
            </div>
            <!-- Username Field End -->
            <!-- Email Field Start -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label ">Email</label>
                <div class="col-sm-10 col-md-8">
                    <input type="email" name="email" class="form-control  form-control-lg" required="required" placeholder="Password must be at least 8 characters">
                </div>
            </div>
            <!-- Email Field End -->
            <!-- Password Field Start -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10 col-md-8">
                    <input type="password" name="password" class="form-control form-control-lg" autocomplete="new-password" required="required" placeholder="Enter a valid email">
                </div>
            </div>
            <!-- Password Field End -->
            <!-- Full name Field Start -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Full Name</label>
                <div class="col-sm-10 col-md-8">
                    <input type="text" name="full" class="form-control  form-control-lg" required="required" placeholder="Enter your first and last name">
                </div>
            </div>
            <!-- Full name Field End -->
            <!-- Submit Field Start -->
            <div class="form-group row mb-3">
                <div class="offset-sm-2 col-sm-10 col-md-8">
                    <input type="submit" class="btn btn-primary btn-lg" value="Add Member">
                </div>
            </div>
            <!-- Submit Field End -->
        </form>
        </div>
        
    <?php
    } elseif ($do == 'Insert') { # Insert page
        
        echo $_POST['username'] . " " . $_POST['password'] . " " . $_POST['email'] . " " . $_POST['full'] ;
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
        <form method="post" action="?do=Update">
            <input type="hidden" name="userid" value="<?php echo $userid?>">
            <!-- Username Field Start -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10 col-md-8">
                    <input type="text" name="username" value="<?php echo $row['Username']?>" class="form-control form-control-lg" autocomplete="off" required="required">
                </div>
            </div>
            <!-- Username Field End -->
            <!-- Email Field Start -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label ">Email</label>
                <div class="col-sm-10 col-md-8">
                    <input type="email" name="email" value="<?php echo $row['Email']?>" class="form-control  form-control-lg" required="required">
                </div>
            </div>
            <!-- Email Field End -->
            <!-- Password Field Start -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10 col-md-8">
                    <input type="hidden" name="oldpassword" value="<?php echo $row['Password'];?>">
                    <input type="password" name="newpassword" class="form-control  form-control-lg" autocomplete="new-password">
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
    } elseif ($do == 'Update') {
        echo '<h1 class="text-center">Update Member</h1>';
        echo '<div class="container">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $_POST['userid'];
            $user = $_POST['username'];
            $email = $_POST['email'];
            $name = $_POST['full'];

            // Update Password
            $pass = empty($_POST['newpassword']) ? $pass = $_POST['oldpassword'] : $pass = sha1($_POST['newpassword']);


            // Form Validation
            
            $formErrors = array();

            if (empty($user)) {
                $formErrors[] = '<div class="alert alert-danger" role="alert">Username can\'t be <strong>empty</strong></div>';
            }
            if (strlen($user) > 20) {
                $formErrors[] = '<div class="alert alert-danger">Username can\'t be more than <strong>20 characters</strong></div>';
            }
            if (empty($email)) {
                $formErrors[] = '<div class="alert alert-danger">Email can\'t be <strong>empty</strong></div>';
            }
            if (empty($name)) {
                $formErrors[] = '<div class="alert alert-danger">Full Name can\'t be<strong> empty</strong></div>';
            }
            
            foreach ($formErrors as $error) {
                echo $error . "<br>";
            }
            
            

            // Update the Database

            if (empty($formErrors)) {
                $stmt = $con->prepare("UPDATE
                                        users
                                    Set
                                        Username = ?,
                                        Email = ?,
                                        FullName = ?,
                                        Password = ?
                                    Where
                                        UserID = ?");
            
            $stmt->execute(array($user, $email, $name, $pass, $id));

            echo '<div class="alert alert-primary">' . $stmt->rowCount() . "Updated </div>";
            }
            
        } else {
            echo "You cant access here";
        }

        echo '</div>';
    }
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
    exit();
}

