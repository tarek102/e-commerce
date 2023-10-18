<?php


// Manage Member page 

session_start();
$pageTitle = 'Members';

if (isset($_SESSION['Username'])) {
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') { # Manage page 

        // Select normal users from Database

        $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1");
        $stmt->execute();
        $rows = $stmt->fetchAll();
    ?>

        <h1 class="text-center">Manage Members</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table text-center table table-striped table-bordered">
                    <tr>
                        <td>#ID</td> 
                        <td>Username</td> 
                        <td>Full Name</td> 
                        <td>Email</td> 
                        <td>Registered Date</td> 
                        <td>Control</td> 
                    </tr>

                    <?php 
                        foreach ($rows as $row) {
                            ?>
                                <tr>
                                    <td><?php echo $row['UserID']?></td>
                                    <td><?php echo $row['Username']?></td>
                                    <td><?php echo $row['FullName']?></td>
                                    <td><?php echo $row['Email']?></td>
                                    <td></td>
                                    <td>
                                        <a href="members.php?do=Edit&userid=<?php echo $row['UserID']?>" class="btn btn-success my-3"><i class="fa fa-edit"></i>Edit</a>
                                        <a href="members.php?do=Delete&userid=<?php echo $row['UserID']?>" class="btn btn-danger my-3 confirm"><i class="fa-solid fa-delete-left"></i>Delete</a>
                                    </td>
                                </tr>
                            <?php
                        }
                    ?>
                </table>
            </div>
            <a href="members.php?do=Add" class="btn btn-primary">Add new member <i class="fa fa-plus mx-1"></i></a>
        </div>

    

    <?php
        



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
                    <input type="password" name="password" class="password form-control form-control-lg" autocomplete="new-password" required="required" placeholder="Enter a valid email">
                    <i class="show-pass fa-solid fa-eye"></i>
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

        echo '<h1 class="text-center">Update Member</h1>';
        echo '<div class="container">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $user = $_POST['username'];
            $pass = $_POST['password'];
            $email = $_POST['email'];
            $name = $_POST['full'];

            $hashPass = sha1($_POST['password']);

            // Update Password
            // $pass = empty($_POST['newpassword']) ? $pass = $_POST['oldpassword'] : $pass = sha1($_POST['newpassword']);


            // Form Validation
            
            $formErrors = array();

            if (empty($user)) {
                $formErrors[] = 'Username can\'t be <strong>empty</strong>';
            }
            if (strlen($user) > 20) {
                $formErrors[] = 'Username can\'t be more than <strong>20 characters</strong>';
            }
            if (empty($email)) {
                $formErrors[] = 'Email can\'t be <strong>empty</strong>';
            }
            if (empty($pass)) {
                $formErrors[] = 'Password can\'t be <strong>empty</strong>';
            }
            if (empty($name)) {
                $formErrors[] = 'Full Name can\'t be<strong> empty</strong>';
            }
            
            foreach ($formErrors as $error) {
                echo '<div class="alert alert-danger">' . $error . "</div>" . "<br>";
            }
            
            

            # Insert User info to Database

            if (empty($formErrors)) {
                
                $stmt = $con->prepare("INSERT INTO
                                        users(Username, Password, Email, FullName) 
                                        VALUES (:user, :pass, :email, :full)");

                $stmt->execute(array(
                    'user' => $user,
                    'pass' => $hashPass,
                    'email' => $email,
                    'full' => $name
                ));
                echo '<div class="alert alert-primary">' . $stmt->rowCount() . "Inserted </div>";
            }
            
        } else {
            echo "You cant access here";
        }

        echo '</div>';
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
                $formErrors[] = 'Username can\'t be <strong>empty</strong>';
            }
            if (strlen($user) > 20) {
                $formErrors[] = 'Username can\'t be more than <strong>20 characters</strong>';
            }
            if (empty($email)) {
                $formErrors[] = 'Email can\'t be <strong>empty</strong>';
            }
            if (empty($name)) {
                $formErrors[] = 'Full Name can\'t be<strong> empty</strong>';
            }
            
            foreach ($formErrors as $error) {
                echo '<div class="alert alert-danger">' . $error . '</div>' . "<br>";
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
    } elseif ($do == 'Delete') { # Delete member

        echo '<h1 class="text-center">Delete Member</h1>';
        echo '<div class="container">';
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

            // Select user to delete from Database

            $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
            $stmt->execute(array($userid));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();

            if ($count > 0) {
                $stmt = $con->prepare("DELETE FROM users WHERE UserID = :userid");
                $stmt->bindParam("userid", $userid);
                $stmt->execute();

                echo '<div class="alert alert-primary">' . $row['Username'] . " Deleted </div>";
            } else {
                $errorMsg = 'This ID doesn\'t exist';

                homeRedirect($errorMsg, 2);
            }

        echo "</div>";
    }
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
    exit();
}

