<?php

/**
* =======================
* == Categories page ======
* =======================
*/


    ob_start();
    session_start();

    if (isset($_SESSION['Username'])) {
        include 'init.php';
        include $tpl . 'footer.php';
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
        if ($do == 'Manage') {
                $stmt2 = $con->prepare("SELECT * FROM categories");
                $stmt2->execute();
                $cats = $stmt2->fetchAll();?>

                <h1 class="text-center">Manage Categories</h1>
                <div class="container">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <div class="card-text">
                                <?php
                                    foreach ($cats as $cat) {
                                        echo $cat['Name'] . "<br>";
                                        echo $cat['Description'] . "<br>";
                                        echo "Ordeing is " . $cat['Ordering'] . "<br>";
                                        echo "Visibility is " . $cat['Visibility'] . "<br>";
                                        echo "Comments are " . $cat['Allow_Comment'] . "<br>";
                                        echo "Ads are " . $cat['Allow_Ads'] . "<br>";
                                    }
                                ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <?php
        } elseif ($do == 'Add') {
            ?>
        <h1 class="text-center">Add Category</h1>
        <div class="container">
        <form method="post" action="?do=Insert">
            <!-- Category Field Start -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10 col-md-8">
                    <input type="text" name="name" class="form-control form-control-lg" autocomplete="off" required="required" placeholder="Add category name">
                </div>
            </div>
            <!-- Category Field End -->
            <!-- Description Field Start -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10 col-md-8">
                    <input type="text" name="description" class="description form-control form-control-lg"  placeholder="Describe the category">
                </div>
            </div>
            <!-- Description Field End -->
            <!-- Ordering Field Start -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label ">Ordering</label>
                <div class="col-sm-10 col-md-8">
                    <input type="text" name="ordering" class="form-control  form-control-lg" placeholder="Write the order of the category">
                </div>
            </div>
            <!-- Ordering Field End -->
            <!-- Visibility Field Start -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Visible</label>
                <div class="col-sm-10 col-md-8">
                    <div>
                        <input id="vis-yes" type="radio" name="visibility" value="0" checked>
                        <label for="vis-yes">Yes</label>
                    </div>
                    <div>
                        <input id="vis-no" type="radio" name="visibility" value="1">
                        <label for="vis-no">No</label>
                    </div>
                    
                </div>
            </div>
            <!-- Visibility Field End -->
            <!-- Commenting Field Start -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Allow ommenting</label>
                <div class="col-sm-10 col-md-8">
                    <div>
                        <input id="comm-yes" type="radio" name="commenting" value="0" checked>
                        <label for="comm-yes">Yes</label>
                    </div>
                    <div>
                        <input id="comm-no" type="radio" name="commenting" value="1">
                        <label for="comm-no">No</label>
                    </div>
                    
                </div>
            </div>
            <!-- Commenting Field End -->
            <!-- Ads Field Start -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Allow Ads</label>
                <div class="col-sm-10 col-md-8">
                    <div>
                        <input id="ads-yes" type="radio" name="ads" value="0" checked>
                        <label for="ads-yes">Yes</label>
                    </div>
                    <div>
                        <input id="ads-no" type="radio" name="ads" value="1">
                        <label for="ads-no">No</label>
                    </div>
                    
                </div>
            </div>
            <!-- Ads Field End -->
            <!-- Submit Field Start -->
            <div class="form-group row mb-3">
                <div class="offset-sm-2 col-sm-10 col-md-8">
                    <input type="submit" class="btn btn-primary btn-lg" value="Add Category">
                </div>
            </div>
            <!-- Submit Field End -->
        </form>
        </div>
            <?php
        }elseif ($do == 'Insert') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                echo '<h1 class="text-center">Update Member</h1>';
                echo '<div class="container">';
                
                // Get variables from the form

                $name = $_POST['name'];
                $description = $_POST['description'];
                $ordering = $_POST['ordering'];
                $visiblity = $_POST['visibility'];
                $commenting = $_POST['commenting'];
                $ads = $_POST['ads'];

                // Check if a category exists

                $check = checkItem('Name', 'categories', $name);

                if ($check === 1) {
                    $msg = "<div class='alert alert-danger'>This category name already exists , please select another one</div>";
                    homeRedirect($msg, 'back');
                } else {
                    $stmt = $con->prepare("INSERT INTO categories (Name, Description, Ordering, Visibility, Allow_Comment, Allow_Ads)
                                                        VALUES(:name, :description, :ordering, :visibility, :comments, :ads)");
                    $stmt->execute(array(
                        'name' => $name,
                        'description' => $description,
                        'ordering' => $ordering,
                        'visibility' => $visiblity,
                        'comments' => $commenting,
                        'ads' => $ads
                    ));

                    $msg = '<div class="alert alert-primary">' . $stmt->rowCount() . "Inserted </div>";
                    homeRedirect($msg, 'back');

                }
            } else {
                $msg = "<div class='alert alert-danger'>You cant access here</div>";
                homeRedirect($msg, 'back');
            }

        } elseif ($do == 'Edit') {
            # code...
        } elseif ($do == 'Update') {
            # code...
        } elseif ($do == 'Delete') {
            # code...
        }
    } else {
        header('location: index.php');
        exit();
    }

    ob_end_flush();