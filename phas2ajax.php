<?php
ob_start();
session_start();
include "app/constants.php";
spl_autoload_register(function ($class) {
    require "app/includes/classes/" . $class . ".php";
});

$obj1 = new connection();
if ($_POST['val']) {
    $stmt = $obj1->con()->prepare("UPDATE `users` SET image = ? WHERE email = ? AND password = ? ");
    $stmt->execute(array('', $_SESSION['email'], sha1($_SESSION['pass'])));
    $_SESSION['phase1'] = true;
    $_SESSION['phase2'] = false;
} else {
    /* delete user from database */
    $stmt = $obj1->con()->prepare("DELETE FROM users WHERE username = ? AND email = ? AND password = ?");
    $stmt->execute(array('', $_SESSION['email'], sha1($_SESSION['pass'])));
    $_SESSION['phase1'] = false;
    $_SESSION['email'] = '';
    $_SESSION['pass'] = '';
}
ob_end_flush();
