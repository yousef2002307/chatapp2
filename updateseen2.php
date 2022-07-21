<?php
ob_start();
session_start();
include "app/constants.php";
spl_autoload_register(function ($class) {
    require "app/includes/classes/" . $class . ".php";
});
include "app/includes/functions/functions.php";
if (isset($_POST['val'])) {
    $val = $_POST['val'];
    $obj1 = new connection();
    $id = isset($_SESSION['id']) ? $_SESSION['id'] : $_COOKIE['id'];
    $stmt = $obj1->con()->prepare("UPDATE `messages` SET seen = '2' WHERE message_from = $val AND message_to = $id");
    $stmt->execute();
} else if (isset($_POST['writing'])) {
    $obj1 = new connection();
    $writing = $_POST['writing'];
    $id = isset($_SESSION['id']) ? $_SESSION['id'] : $_COOKIE['id'];
    $stmt = $obj1->con()->prepare("UPDATE `users` SET `is_writing` = $writing WHERE `users`.`id` = $id");
    $stmt->execute();
} else if (isset($_POST['blur'])) {
    $obj1 = new connection();

    $id = isset($_SESSION['id']) ? $_SESSION['id'] : $_COOKIE['id'];
    $stmt = $obj1->con()->prepare("UPDATE `users` SET `is_writing` = 0 WHERE `users`.`id` = $id");
    $stmt->execute();
}












ob_end_flush();
