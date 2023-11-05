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

            $sort = "ASC";
            $sort_Array = array("ASC", "DESC");
            if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_Array)) {
                $sort = $_GET['sort'];
            }
            $stmt2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
            $stmt2->execute();
            $cats = $stmt2->fetchAll();?>

            <h1 class="text-center">Manage Categories</h1>
            <div class="container categories">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3>Card title</h3>
                            <div class="ordering float-end">
                                Ordering:
                                <a class='<?php if($_GET['sort'] == "ASC"){echo "active";} ?>' href="?sort=ASC">ASC</a> |
                                <a class='<?php if($_GET['sort'] == "DESC"){echo "active";} ?>' href="?sort=DESC">DESC</a>
                            </div>
                        </div>
                        <div class="card-text">
                            <?php
                                foreach ($cats as $cat) {
                                    echo "<div class='cat'>";
                                    echo "<div class='hidden-buttons'>";
                                        echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] ."' class='btn btn-sm btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                                        echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='confirm btn btn-sm btn-danger'><i class='fa fa-close'></i>Delete</a>";
                                    echo "</div>";
                                    echo "<h3>" . $cat['Name'] . "</h3>";
                                    echo "<p>"; if ($cat['Description'] == '') { echo 'No Description for this category.' ;} else {echo  $cat['Description'];  } ; echo "</p>";
                                    if ($cat['Visibility'] === 1) {echo "<span class='visibility'>Hidden</span>";} 
                                    if ($cat['Allow_Comment'] === 1) {echo "<span class='commenting'>Comment disabled</span>";} 
                                    if ($cat['Allow_Ads'] === 1) {echo "<span class='advertising'>Ads disabled</span>";} 
                                    echo "</div>";
                                    echo "<hr>";
                                }
                            ?>
                        </div>
                    </div>
                    
                </div>
                <a class='btn btn-primary mt-2 mb-5' href="?do=Add"><i class="fa fa-plus mx-2"></i>Add new category</a>
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
            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? 
            intval($_GET['catid']) : 
            0;
            
            $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");
            $stmt->execute(array($catid));
            $cat = $stmt->fetch();
            $count = $stmt->rowCount();

            if ($count > 0) { ?>

            <h1 class="text-center">Edit Categories</h1>
            <div class="container">
                <form method="post" action="?do=Update">
                    <!-- Category Field Start -->
                    <input type="hidden" name="catid" value="<?php echo $catid; ?>">
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10 col-md-8">
                            <input type="text" name="name" class="form-control form-control-lg" required="required" placeholder="Add category name" value="<?php echo $cat['Name']?>">
                        </div>
                    </div>
                    <!-- Category Field End -->
                    <!-- Description Field Start -->
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10 col-md-8">
                            <input type="text" name="description" class="description form-control form-control-lg"  placeholder="Describe the category" value="<?php echo $cat['Description']?>">
                        </div>
                    </div>
                    <!-- Description Field End -->
                    <!-- Ordering Field Start -->
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label ">Ordering</label>
                        <div class="col-sm-10 col-md-8">
                            <input type="text" name="ordering" class="form-control  form-control-lg" placeholder="Write the order of the category" value="<?php echo $cat['Ordering']?>">
                        </div>
                    </div>
                    <!-- Ordering Field End -->
                    <!-- Visibility Field Start -->
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Visible</label>
                        <div class="col-sm-10 col-md-8">
                            <div>
                                <input id="vis-yes" type="radio" name="visibility" value="0" <?php if($cat['Visibility'] == 0 ){ echo "checked";} ?> >
                                <label for="vis-yes">Yes</label>
                            </div>
                            <div>
                                <input id="vis-no" type="radio" name="visibility" value="1" <?php if($cat['Visibility'] == 1 ){ echo "checked";} ?>>
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
                                <input id="comm-yes" type="radio" name="commenting" value="0" <?php if($cat['Allow_Comment'] == 0 ){ echo "checked";} ?>>
                                <label for="comm-yes">Yes</label>
                            </div>
                            <div>
                                <input id="comm-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_Comment'] == 1 ){ echo "checked";} ?>>
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
                                <input id="ads-yes" type="radio" name="ads" value="0" <?php if($cat['Allow_Ads'] == 0 ){ echo "checked";} ?>>
                                <label for="ads-yes">Yes</label>
                            </div>
                            <div>
                                <input id="ads-no" type="radio" name="ads" value="1" <?php if($cat['Allow_Ads'] == 1 ){ echo "checked";} ?>>
                                <label for="ads-no">No</label>
                            </div>
                            
                        </div>
                    </div>
                    <!-- Ads Field End -->
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
            $msg = "<div class='alert alert-danger'>False ID</div>";
            homeRedirect($msg);
            }
            
        echo '</div>';
        } elseif ($do == 'Update') {
            echo '<h1 class="text-center">Update Member</h1>';
            echo '<div class="container">';
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $id = $_POST['catid'];
                $name = $_POST['name'];
                $desc = $_POST['description'];
                $ordering = $_POST['ordering'];
                $visiblity = $_POST['visibility'];
                $commenting = $_POST['commenting'];
                $ads = $_POST['ads'];


                // Update the Database

                
                $stmt = $con->prepare("UPDATE
                                        categories
                                    Set
                                        Name = ?,
                                        Description = ?,
                                        Ordering = ?,
                                        Visibility = ?,
                                        Allow_Comment = ?,
                                        Allow_Ads = ?
                                    Where
                                        ID = ?");
                
                $stmt->execute(array($name, $desc, $ordering, $visiblity, $commenting, $ads, $id));

                $msg = '<div class="alert alert-primary">' . $stmt->rowCount() . "Updated </div>";
                homeRedirect($msg, 'back');
                
                
            } else {

                $msg = '<div class="alert alert-danger">You cant access here</div>';
                homeRedirect($msg);
                
            }

            echo '</div>';
        } elseif ($do == 'Delete') {
            echo "<h1 class='text-center'>Delete Category</h1>";
            echo "<div class='container'>";

            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? 
                        intval($_GET['catid']) :
                        0;

            $check = checkItem('ID', 'categories', $catid);

            if ($check > 0) {
                $stmt2 = $con->prepare("DELETE FROM categories WHERE ID = :catid");
                $stmt2->bindParam('catid', $catid);
                $stmt2->execute();

                $msg = '<div class="alert alert-primary">' . $stmt2->rowCount() . " Deleted </div>";
                homeRedirect($msg, 'back');
            } else {
                $errorMsg = '<div class="alert alert-danger">This ID doesn\'t exist </div>';

                homeRedirect($errorMsg, 2);
            }
            echo "</div>";
        }
    } else {
        header('location: index.php');
        exit();
    }

    ob_end_flush();