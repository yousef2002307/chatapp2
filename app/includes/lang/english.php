<?php


function lang($parameter)
{
    $array = array(
        "title" => "chat app",
        "sitename" => "chat app",
        "email" => "email",
        "password" => "password",
        "submit" => "submit",
        "arabic" => "arabic",
        "english" => "english",
        "emailerror" => "wrong email format",
        "passerror" => "your password must be more than or equal to 4 numbers",
        "emptyerror" => "you can not leave any fiel empty",
        "wrongdata" => "you entered wrong data,please try agian",
        "remmemberme" => "remmember me",
        "logout" => "log out",
        "sayhi" => "hello",
        "your profile" =>  "your profile",
        "setting" => "settings"
    );
    return $array[$parameter];
}
