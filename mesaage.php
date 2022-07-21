<?php
ob_start();
session_start();
include "app/constants.php";
spl_autoload_register(function ($class) {
    require "app/includes/classes/" . $class . ".php";
});
include "app/includes/functions/functions.php";

$count = $_POST['count2'];
$like = $_POST['like'];
$obj1 = new connection();
$id = isset($_SESSION['id']) ? $_SESSION['id'] : $_COOKIE['id'];

if (isthereanymessages($id)) {
    $stmt = $obj1->con()->prepare("SELECT messages.id AS id2, messages.message_from,messages.message_to,messages.message,users.* FROM messages INNER JOIN users ON users.id = messages.message_from OR users.id = messages.message_to WHERE users.id = ? AND (messages.message_to = ? OR messages.message_from = ?) ORDER BY messages.id");
    $stmt->execute(array($id, $count, $count));
    $rows = $stmt->fetchAll();


    foreach ($rows as $row) {
        if ($row['message_from'] == $id) {
            if ($row['message'] == $like) {

                echo "
        <div class='right' data-id = {$row['id2']} data-message={$row['message_from']}><i class='fas fa-thumbs-up'></i> </div>
        ";
            } else {
                echo "
        <div class='right' data-id = {$row['id2']} data-message={$row['message_from']}><span>{$row['message']}</span> </div>
        ";
                // <span> <i class="fas fa-thumbs-up"></i></span>
            }
        } else {
            if ($row['message'] == $like) {

                echo "
        <div class='left' data-id = {$row['id2']} data-message={$row['message_from']}><i class='fas fa-thumbs-up'></i> </div>
        ";
            } else {
                echo "
        <div class='left' data-id = {$row['id2']} data-message={$row['message_from']}><span>{$row['message']} </span></div>
        ";
            }
        }
    }
    $stmt = $obj1->con()->prepare("SELECT * FROM `messages` WHERE (message_from = $id AND message_to = $count) OR (message_from = $count AND message_to = $id) ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $row2 = $stmt->fetch();
    if ($row2['message_from'] == $id) {
        if ($row2['seen'] == 0) {
            echo '<i class="fas fa-check "></i>';
        } else if ($row2['seen'] == 1) {
            echo '<i class="fas fa-check "></i><i class="fas fa-check "></i>';
        } else {
            echo '<i class="fas fa-check check2"></i><i class="fas fa-check check2"></i>';
        }
    }
    $stmt8 = $obj1->con()->prepare("SELECT * FROM users WHERE is_writing = ? AND users.id = ?");
    $stmt8->execute(array($id, $count));
    $row8 = $stmt8->rowCount();
    if ($row8 > 0) {
        echo "<div class='right writing'>  your friend is writing now......... </div>";
    }
    //
    //echo '<i class="fas fa-check check2"></i><i class="fas fa-check check2"></i>';
    //echo '<i class="fas fa-check-double "></i>';








} else {
    echo '<div class="py-4 text-center"> you have no chats <a href="' . $url . '/dashboard.php?page=suggest"> here is some suggestions of friends to make chat with </a> </div> ';
}





ob_end_flush();
