<?php
ob_start();

session_start();


if (isset($_GET['lang'])) {
    setcookie("lang", htmlspecialchars($_GET['lang']), time() + 3600 * 24 * 1000, "/");
}



include "app/init.php";
/* make redirect if cookie or session is set */
redirect();
/* make redirect if cookie or session is set */
$error =  false;

//////now on the user click submit button ///////////////////
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['pass'];


    /////////////call the security guard class////
    $obj1 = new securityGuard($email, $pass);

    $error = $obj1->areThereAnyErrors();
    if ($error && $obj1->checkIfDataExcist()) {
        $id =  $obj1->getId($email, $pass);


        if (isset($_POST['re'])) {
            setcookie("email", $email, time() + 3600 * 24 * 1000, "/");
            setcookie("pass", sha1($pass), time() + 3600 * 24 * 1000, "/");
            setcookie("id", $id, time() + 3600 * 24 * 1000, "/");
        } else {
            $_SESSION['id'] = $id;
            $_SESSION['email'] = $email;
        }
        $obj1->updateLoginDate($id);
        header("Location:" . $url . "/dashboard.php");
    } else {
        $wrongLogIn = $obj1->wrongData($obj1->checkIfDataExcist());
    }
}


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
            <label><?php echo lang("remmemberme") ?></label>
            <input type="checkbox" class="" name='re' />

        </div>
        <input type="submit" value="<?php echo lang("submit") ?>" class="btn btn-primary btn-block" />
    </form>
    <?php
    if (isset($obj1) && !$error) {
        $obj1->printErrorsArray();
    } else if (isset($wrongLogIn) && $error) {
        echo $wrongLogIn;
    }
    ?>
    <p class="text-center text-capatlize">if you do not have an accounet please <a href="register.php">sign in</a> from here</p>
</section>


<?php
include "app/includes/views/footer.php";
ob_end_flush();
?>