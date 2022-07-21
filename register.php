<?php
ob_start();

session_start();


$nolang = true;
include "app/init.php";

/* make redirect if cookie or session is set */
redirect();
/* make redirect if cookie or session is set */
$error =  false;
///make instance of the class ////////
$obj1 = new xegister("", "");
$do = '';
if (isset($_GET['do'])) {
    $do = $_GET['do'];
} else {
    $do = 'manage';
}

//////now on the user click submit button ///////////////////
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //check that this is the first phase
    if (isset($_POST['phase1'])) {
        //redeclartion of the obj1
        $obj1->redaclertionOfVals($_POST['email'], $_POST['pass']);
        ///////get the value and sanatize them
        $email = sanatizeInputs($_POST['email']);
        $pass = sanatizeInputs($_POST['pass']);
        $pass2 = sanatizeInputs($_POST['pass2']);

        $obj1->areTheySecure();
        $obj1->arePasswordMatch($pass2);
        if (!($obj1->isThereIsAnError()) && !doesValExcistBefore("users", "email", $email)) {
            $obj1->insertData();
            //rediret to seconed phase
            $_SESSION['phase1'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['pass'] = $pass;

            header("Location:" . $url . "/register.php?do=phase2");
        } else {
            $obj1->errarr[] = "email already excist";
            $error = true;
        }
        /* this part of code is for next phase*/
    } else if (isset($_POST['phase22'])) {
        $file = $_FILES['file'];

        //check if there is error
        if ($file['error'] == 1) {
            echo "sorry try another img";
        } else {
            $photopath = pathinfo($file['name']);
            $acceptedTypes = array("jpg", "png", "jpeg");
            if (in_array($photopath['extension'], $acceptedTypes)) {
                $newname = uniqid("IMG-");
                $newpath = "app/uploads/" . $newname . "." . $photopath['extension'];
                $oldimg = $file['tmp_name'];
                move_uploaded_file($oldimg, $newpath);
                $newname = $newname . "." . $photopath['extension'];

                $obj1->updatePhase2($newname, $_SESSION['email'], $_SESSION['pass']);
                $_SESSION['phase2'] = true;
            } else {
                echo "img is not the correct type it must be jpg or png or jpeg";
            }
        }
    } else if (isset($_POST['phase21'])) {
        $_SESSION['phase2'] = true;
        header("Location:" . $url . "/register.php?do=phase3");
    } else if (isset($_POST['phase32'])) {
        ////take the name of the user
        $username = sanatizeInputs($_POST['name']);
        ///create default username
        $obj1->setDefaultUserName($username, $_SESSION['email'], $_SESSION['pass']);
        $_SESSION['phase3'] = true;
        header("Location:" . $url . "/dashboard.php?status=new");
    } else if (isset($_POST['phase3'])) {

        ////take the name of the user
        $username = sanatizeInputs($_POST['name']);
        /////update username if username does not exccist before
        if (doesValExcistBefore("users", "username", $username)) {
            echo "the user name already excist please try agian";
        } else {
            $_SESSION['phase3'] = true;

            $obj1->updateuseranme($username, $_SESSION['email'], $_SESSION['pass']);
            $obj1->setId($username, $_SESSION['email'], $_SESSION['pass']);
            header("Location:" . $url . "/dashboard.php?status=new");
        }
    }
}

if ($do == 'manage') {

?>


    <section class="index">
        <h2 class="text-center"><?php echo lang("sitename") ?></h2>




        <form class='mb-5' action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

            <div class="form-group">
                <label><?php echo lang("email") ?></label>
                <input type="text" class="form-control" name='email' value="<?php echo isset($email) ? $email : ""  ?>" />

            </div>
            <div class="form-group">
                <label><?php echo lang("password") ?></label>
                <input type="password" class="form-control" name='pass' autocomplete="off" value="<?php echo isset($pass) ? $pass : ""  ?>" />

            </div>
            <div class="form-group">
                <label>confirm password </label>
                <input type="password" class="form-control" name='pass2' autocomplete="off" value="<?php echo isset($pass2) ? $pass2 : ""  ?>" />

            </div>
            <input type="submit" name="phase1" value="<?php echo lang("submit") ?>" class="btn btn-primary btn-block" />
        </form>
        <?php

        if (isset($obj1) && $error) {
            $obj1->printErrorsArray();
        }

        ?>

    </section>


<?php
} elseif ($do == "phase2") {
    //check if the user legally her or not
    if (!isset($_SESSION['phase1']) || $_SESSION['phase1'] == false) {
        header("Location:" . $url . "/index");
        exit();
    }
    ///make instance of your main class
    $obj2 = new xegister($_SESSION['email'], $_SESSION['pass']);
    /////html code ////////////////////
?>
    <section class="photo">
        <h3>choose your photo please</h3>
        <figure>
            <img src="app/layout/img/images.jpg" />
            <i class="fas fa-camera"></i>
            <a href='#' class="btn btn-primary">back</a>
        </figure>
        <form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'] . "?do=phase2" ?>" method="POST">
            <input type="file" name="file" style="opacity: 0;" class="file d-none" />
            <input type="submit" name="phase22" value="ok" class="btn btn-success" />
            <input type="submit" name="phase21" value="skip" class="btn btn-danger" />

        </form>
    </section>




    <?php
} else if ($do == "phase3") {
    if (isset($_SESSION['phase2']) && $_SESSION['phase2'] == true) {
        $_SESSION['phase1'] = false;
    ?>
        <!--html code-->
        <div class="username">
            <a href='#' class="btn btn-primary">back</a>
            <h2>type your username</h2>
            <form name="username" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'] . "?do=phase3" ?>" method="POST">
                <input type="text" name="name" class="form-control" />
                <input type="submit" name="phase3" value="ok" class="btn btn-success" />
                <input type="submit" name="phase32" value="skip" class="btn btn-danger" />

            </form>
        </div>

<?php
    } else {
        header("Location:" . $url . "/index");
        exit();
    }
    ///////////////////////phase4/////////////////////////////////
} else {
    echo "you are not authorized to be here";
}
?>


<?php
include "app/includes/views/footer.php";
ob_end_flush();
?>