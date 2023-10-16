<?php

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


if ($do == 'Manage' ) {
    echo "Welcome to Manage category";
    echo "<br>";
    echo '<a href="?do=Add">Add Category</a>';
} elseif ($do == 'Add') {
    echo "Welcome to Add category";
} elseif ($do == 'Insert') {
    echo "Welcome to Insert category";
} else {
    echo "$do is not a right name";
}