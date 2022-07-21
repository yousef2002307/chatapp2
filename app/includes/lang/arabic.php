<?php
function lang($parameter)
{
    $array = array(
        "title" => "تطبيق شات",

        "sitename" => "تطبيق شات",
        "email" => "الايميل الخاص بك",
        "password" => "كلمة السر",
        "submit" => "ادخل بياناتك",
        "arabic" => "عربي",
        "english" => "انجليزي",
        "emailerror" => "الايميل خطأ",
        "passerror" => "كلمة السر يجب ان تكون 4 او اكثر",
        "emptyerror" => "لاتترك اي حقل خالي",
        "wrongdata" => "هناك خطأ في البيانات التي ادخلتها",
        "remmemberme" => "تذكرني",
        "logout" => "تسحيل الخروج",
        "sayhi" => "اهلا",
        "your profile" =>  "ملفك الشخصي",
        "setting" => "الاعدادت"
    );
    return $array[$parameter];
}
