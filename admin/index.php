<?php
session_start();
$noNavbar = '';
$pageTitle = 'Login';
if (isset($_SESSION['Username'])) {
    header('location: dashboard.php');
}
include("init.php"); 

// Check if user coming from post request

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedpass = sha1($password);

    // Check if user exist in DB

    $stmt = $con->prepare("SELECT 
                                UserID, Username, Password 
                            FROM 
                                users 
                            WHERE 
                                Username = ? 
                            AND 
                                Password = ? 
                            AND 
                                GroupID = 1
                            Limit 
                                1");
    $stmt->execute(array($username, $hashedpass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    // If user exist, Login

    if ($count > 0) {
        $_SESSION['Username'] = $username;      //Register Username
        $_SESSION['ID'] = $row['UserID'];       // Register User ID 
        header("location: dashboard.php");      // Redirect to Dashboard
        exit();
    }
}

?>


<form class="login" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <h4 class="text-center">Admin Login</h4>
    <input class="form-control form-control-lg input-lg" type="text" name="user" placeholder="Username" autocomplete="off">
    <input class="form-control form-control-lg input-lg" type="password" name="pass" placeholder="Password" autocomplete="off">
    
    <div class="d-grid gap-2">
        <input type="submit" value="Login" class="btn btn-lg btn-primary btn-block">
    </div>
</form>

<?php include($tpl . "footer.php"); ?>