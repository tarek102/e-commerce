<?php
include("init.php"); 
include($tpl . "header.php"); 
include('includes/languages/english.php');
?>

<form class="login">
    <h4 class="text-center">Admin Login</h4>
    <input class="form-control form-control-lg input-lg" type="password" name="pass" placeholder="Password" autocomplete="off">
    <input class="form-control form-control-lg input-lg" type="text" name="user" placeholder="Username" autocomplete="off">
    
    <div class="d-grid gap-2">
        <input type="submit" value="Login" class="btn btn-lg btn-primary btn-block">
    </div>
</form>

<?php include($tpl . "footer.php"); ?>