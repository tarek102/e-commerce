<?php

// Page title function

function getTitle(){
    global $pageTitle;

    echo isset($pageTitle) ?  $pageTitle :  'Default';
}

/* Home Redirect Functions [Accepts 2 parameters] */

/* 
- First parameter is Error message 
- Second parameter is seconds for redirect 
*/

function homeRedirect($errorMsg, $seconds = 3) {

    echo "<div class='container'</div>";
    echo "<div class='alert alert-danger'>$errorMsg</div>"; 
    echo "<div class='alert alert-info'>You will be redirected to Homepage after $seconds</div>";
    echo "</div>";
    header("refresh:$seconds; url=index.php");
    exit();
}