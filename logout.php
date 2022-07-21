<?php
session_start();
$id = isset($_SESSION['id']) ? $_SESSION['id'] : $_COOKIE['id'];

include "app/constants.php";
spl_autoload_register(function ($class) {
    require "app/includes/classes/" . $class . ".php";
});
include "app/includes/functions/functions.php";
$obj1 = new connection();

$stmt = $obj1->con()->prepare("UPDATE `users` SET `logout` = now() WHERE `users`.`id` = ?");
$stmt->execute(array($id));
$stmt2 = $obj1->con()->prepare("UPDATE `users` SET `is_writing` = 0 WHERE `users`.`id` = $id");
$stmt2->execute();
$_SESSION['dashboard'] = false;
if (isset($_SESSION['id'])) {
    session_unset();
    session_destroy();
    //header("Location:" . $url . "/index.php");
    header("Location:index.php");
    exit();
} else {
    setcookie("email", $email, time() - 3600 * 24 * 2000, "/");
    setcookie("pass", sha1($pass), time() - 3600 * 24 * 2000, "/");
    setcookie("id", $id, time() - 3600 * 24 * 2000, "/");
    header("Location:index.php");
    //  header("Location:" . $url . "/index.php");
    exit();
}
