<?php
ob_start();
session_start();
include "app/constants.php";
spl_autoload_register(function ($class) {
    require "app/includes/classes/" . $class . ".php";
});
include "app/includes/functions/functions.php";

$arrofiteration = [];
$arrayofid = [];
$count = $_POST['count'];
$like = $_POST['like'];
$obj1 = new connection();
$id = isset($_SESSION['id']) ? $_SESSION['id'] : $_COOKIE['id'];
updateLastLogin($id);

///////////////////////////////

if (seen1($id)) {
    $obj1 = new connection();
    $stmt = $obj1->con()->prepare("UPDATE messages INNER JOIN users ON users.id = messages.message_to AND messages.seen !=2 SET messages.seen = 1 WHERE users.id = $id ");
    $stmt->execute();
}
////////////////

///////////////////////////////
$stmt = $obj1->con()->prepare("SELECT * FROM `messages` WHERE message_from = ? or message_to = ? ORDER BY id DESC");
$stmt->execute(array($id, $id));
$rows = $stmt->fetchAll();
foreach ($rows as $row) {
    if (!isset($arrofiteration[$row['message_from']]) && $row['message_from'] != $id) {
        array_push($arrayofid, $row['message_from']);
        $arrofiteration[$row['message_from']] = 2;
    } else if (!isset($arrofiteration[$row['message_to']]) && $row['message_to'] != $id) {
        array_push($arrayofid, $row['message_to']);
        $arrofiteration[$row['message_to']] = 2;
    }
}
$bool = true;

for ($i = 0; $i < count($arrayofid); $i++) {
    $id2 = $arrayofid[$i];

    $stmt2 = $obj1->con()->prepare("SELECT * FROM messages INNER JOIN users ON users.id = messages.message_from OR users.id = messages.message_to WHERE users.id = ? AND (messages.message_from = ? OR messages.message_to = ?) ORDER BY messages.id DESC LIMIT 1");
    $stmt2->execute(array(intval($arrayofid[$i]), $id, $id));
    $rows2 = $stmt2->fetchAll();
    foreach ($rows2 as $row) {

        $img = $row['image'] == "" ? 'images.jpg' : $row['image'];
        $username = $row['username'];
        if ($i == 0 && $count == 0) {
            echo "<div class='singelchat active' data-id='{$id2}' data-img='{$img}' data-user='{$username}'>";
        } else if ($count == $id2) {
            echo "<div class='singelchat active ' data-id='{$id2}' data-img='{$img}' data-user='{$username}'>";
        } else {
            echo "<div class='singelchat  ' data-id='{$id2}' data-img='{$img}' data-user='{$username}'>";
        }
        if ($row['image'] != '') {
            echo "
    <div>
                                <img src='{$url}/app/uploads/{$row['image']} '>
                            </div>
    
    ";
        } else {
            echo "
        <div>
                                <img src='{$url}/app/layout/img/images.jpg' />
                            </div>
        ";
        }

        echo "
    <div>
                                <bold>{$row['username']}</bold>
                              
    ";
        if ($id == $row['message_from']) {
            if ($row['message'] == $like) {
                echo "<span>  you : <i class='fas fa-thumbs-up'></i></span>";
            } else {
                if (unseenMessages($id, $id2)) {
                    echo "<bold class='bold'>  you : {$row['message']}</bold>";
                } else {
                    echo "<span>  you : {$row['message']}</span>";
                }
            }
        } else {
            if ($row['message'] == $like) {
                echo "<span>  {$row['username']} : <i class='fas fa-thumbs-up'></i></span>";
            } else {
                if (unseenMessages($id, $id2)) {
                    echo "<bold class='bold'>  {$row['username']} : {$row['message']}</bold>";
                } else {
                    echo "<span>  {$row['username']} : {$row['message']}</span>";
                }
            }
        }

        echo "</div>";
        if (unseenMessages($id, $id2)) {


            echo "<p>" . unseenMessages($id, $id2) . "   </p>";
        }
        echo "</div>";
    }
}

ob_end_flush();
