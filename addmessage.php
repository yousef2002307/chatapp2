<?php

ob_start();
session_start();
include "app/constants.php";
spl_autoload_register(function ($class) {
    require "app/includes/classes/" . $class . ".php";
});
include "app/includes/functions/functions.php";
if (!isset($_POST['like'])) {
    $value = $_POST['value'];
    $towho = $_POST['towho'];
    $obj1 = new connection();
    $id = isset($_SESSION['id']) ? $_SESSION['id'] : $_COOKIE['id'];
    $stmt = $obj1->con()->prepare("INSERT INTO `messages` ( `message`, `message_from`, `message_to`, `seen`, `time_sent`) VALUES (:zmessage, :zfrom,:zto, '0', now())");
    $stmt->execute(array(
        "zmessage" => $value,
        "zfrom" => $id,
        "zto" => $towho
    ));
    $stmt2 = $obj1->con()->prepare("UPDATE `users` SET `is_writing` = 0 WHERE `users`.`id` = $id");
    $stmt2->execute();
} else {
    $like = $_POST['like'];
    $towho = $_POST['towho'];
    $obj1 = new connection();
    $id = isset($_SESSION['id']) ? $_SESSION['id'] : $_COOKIE['id'];
    $stmt = $obj1->con()->prepare("INSERT INTO `messages` ( `message`, `message_from`, `message_to`, `seen`, `time_sent`) VALUES (:zmessage, :zfrom,:zto, '0', now())");
    $stmt->execute(array(
        "zmessage" => $like,
        "zfrom" => $id,
        "zto" => $towho
    ));
}


ob_end_flush();
