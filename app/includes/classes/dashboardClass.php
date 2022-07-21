<?php

class dashboardClass extends securityGuard
{
    /*  what is this function do is to get the username from the session or cookie */
    public function getNameOfTheUser()
    {
        $id = 0;
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
        } elseif (isset($_COOKIE['id'])) {
            $id = $_COOKIE['id'];
        }
        $stmt = $this->con()->prepare("SELECT username from users WHERE id = ?");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $rows = $stmt->fetch();
            return $rows['username'];
        }
    }
    /* to show welcoming message on the newly registed user */
    public function welcomingMessage()
    {

        if (isset($_GET['status']) && $_GET['status'] == 'new') {
            echo "<div class='welcommsg'> hello " . $this->getNameOfTheUser() . " to our chat app, enjoy! </div>";
        }
    }
    ////edit profile section////////////////////////////////////////////////////////////
    public function returnSpecificData($item, $id)
    {
        $stmt = $this->con()->prepare("SELECT * FROM `users` WHERE id = ?");
        $stmt->execute(array($id));
        $rows = $stmt->fetch();
        return $rows[$item];
    }
    function areThereAnyErrors2($email, $user, $pass)
    {
        $this->errarr = array();
        $bool = true;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errarr, "your email is not in correct format");
            $bool = false;
        }
        if (!empty($pass)) {
            if (strlen(strval($pass)) < 4) {
                array_push($this->errarr, "your pass must be longer than 2 ");
                $bool = false;
            }
        }
        if ($email == '' || $user == '') {
            array_push($this->errarr, "you can not leave email and user fields empty");
            $bool = false;
        }
        return $bool;
    }
    ///////////////////////////////////////////
    public function addDataIfFileFieldIsEmpty($email, $user, $oldpass, $newpass)
    {
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
        } else {
            $id = $_COOKIE['id'];
        }
        if (empty($newpass)) {
            $stmt8 = $this->con()->prepare("UPDATE `users` SET email = ?, `username` = ?, password = ? WHERE `users`.`id` = ?");
            $stmt8->execute(array($email, $user, $oldpass, $id));
        } else {
            $stmt8 = $this->con()->prepare("UPDATE `users` SET email = ?, `username` = ?, password = ? WHERE `users`.`id` = ?");
            $stmt8->execute(array($email, $user, sha1($newpass), $id));
        }
    }

    ////////////////////
    public function addDataIfFileFieldIsNotEmpty($email, $user, $oldpass, $newpass, $file)
    {
        if ($file['error'] == 1) {
            echo "sorry try another img";
        } else {
            $photopath = pathinfo($file['name']);
            $acceptedTypes = array("jpg", "png", "jpeg");
            if (in_array($photopath['extension'], $acceptedTypes)) {
                $newname = uniqid("IMG-");
                $newpath = "app/uploads/" . $newname . "." . $photopath['extension'];
                $oldimg = $file['tmp_name'];
                move_uploaded_file($oldimg, $newpath);
                $newname = $newname . "." . $photopath['extension'];
            }
            /////////////update user
            if (isset($_SESSION['id'])) {
                $id = $_SESSION['id'];
            } else {
                $id = $_COOKIE['id'];
            }
            if (empty($newpass)) {
                $stmt8 = $this->con()->prepare("UPDATE `users` SET email = ?, `username` = ?, password = ?, image = ? WHERE `users`.`id` = ?");
                $stmt8->execute(array($email, $user, $oldpass, $newname, $id));
            } else {
                $stmt8 = $this->con()->prepare("UPDATE `users` SET email = ?, `username` = ?, password = ?, image = ? WHERE `users`.`id` = ?");
                $stmt8->execute(array($email, $user, sha1($newpass), $newname, $id));
            }
        }
    }
}
