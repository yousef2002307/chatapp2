<?php

/* that function make redirection if the cookie or session is set*/
function redirect()
{
    global $url;
    if (isset($_COOKIE['id']) || isset($_SESSION['id'])) {
        header("Location:" . $url . "/dashboard.php");
    }
}
/*that function sanatize inputs */
function sanatizeInputs($input)
{
    $email = filter_var($input, FILTER_SANITIZE_EMAIL);

    $email = htmlspecialchars($input);
    return $email;
}
////check if the name of the value excist before in the database
function doesValExcistBefore($nameOfTable, $field, $val)
{
    $obj1 = new connection();
    $stmt = $obj1->con()->prepare("SELECT * FROM $nameOfTable WHERE $field = ?");
    $stmt->execute(array($val));
    $count = $stmt->rowCount();
    return $count;
}
/* get the numbers of unseen messages between two users */
function unseenMessages($first, $seconed)
{
    $obj1 = new connection();
    $stmt = $obj1->con()->prepare("SELECT * FROM `messages` WHERE (message_to = $first AND message_from = $seconed AND (seen = 0 OR seen = 1))");
    $stmt->execute();
    $count = $stmt->rowCount();
    return $count;
}
////////////////// update last login/////////////////
function updateLastLogin($id)
{
    $obj1 = new connection();
    $stmt = $obj1->con()->prepare("UPDATE `users` SET last_login = now(), `is_open` = '1' WHERE `users`.`id` = $id");
    $stmt->execute();
}
/////////////////////check if seen 1 apply or not//////////////////////////////////
function seen1($id)
{
    $obj1 = new connection();
    $stmt = $obj1->con()->prepare("SELECT * FROM `users` WHERE users.id = $id");
    $stmt->execute();
    $row = $stmt->fetch();
    $date1 = time();

    $date2 = date($row['last_login']);
    $date3 = date('Y-m-d h:i:s', $date1);

    if ($date2 >= $date3) {
        return true;
    } else {
        echo false;
    }
}
///isthereanymessages function /////////////////////////////////
function isthereanymessages($id)
{
    $obj1 = new connection();
    $stmt = $obj1->con()->prepare("SELECT * FROM `messages` WHERE message_from = $id OR message_to = $id");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count == 0) {
        return false;
    } else {
        return true;
    }
}
