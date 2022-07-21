<?php
include "app/constants.php";


if (isset($_GET['lang'])) {

    if ($_GET['lang'] == 0) {
        include "app/includes/lang/english.php";
    } else {
        include "app/includes/lang/arabic.php";
    }
} else {
    if ($_COOKIE['lang'] == 0) {
        include "app/includes/lang/english.php";
    } else {
        include "app/includes/lang/arabic.php";
    }
}
include "app/includes/views/header.php";
include "app/constants.php";
spl_autoload_register(function ($class) {
    require "app/includes/classes/" . $class . ".php";
});
include "app/includes/functions/functions.php";
