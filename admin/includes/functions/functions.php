<?php

/* Page Title Function v1.0
** Print page title based on $pageTitle
*/

function getTitle(){
    global $pageTitle;

    echo isset($pageTitle) ?  $pageTitle :  'Default';
}

/* Redirect Functions v2.0
** [Added $url and $msg dynamicaly]
** Home Redirect Functions v1.0
** [Accepts 2 parameters]  
- First parameter is Error message 
- Second parameter is seconds for redirect 
*/

function homeRedirect($msg, $url = null, $seconds = 3) {

    if ($url == null) {
        $url = 'index.php';
        $link = 'Homepage';
    } else {
        $url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '' ?
        $_SERVER['HTTP_REFERER'] :    
        'index.php';
        
        $link = 'previous page';
        
    }

    echo "<div class='container'</div>";
    echo $msg; 
    echo "<div class='alert alert-info'>You will be redirected to $link after $seconds</div>";
    echo "</div>";
    header("refresh:$seconds; url=$url");
    exit();
}



/*
* Check Items Function v1.0
* Check Item in Database
* Parameters [$select, $from, $value]
*/

function checkItem($select, $from, $value){
    global $con;

    $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $statement->execute(array($value));
    $count = $statement->rowCount();

    return $count;
}