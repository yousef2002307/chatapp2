<?php
class xegister extends connection
{
    protected $email;
    protected $pass;
    public $errarr = array();
    public function __construct($name, $age)
    {
        $this->email = $name;
        $this->pass = $age;
    }
    function redaclertionOfVals($email, $pass)
    {
        $this->email = $email;
        $this->pass = $pass;
    }
    function printVals()
    {
        echo $this->email . $this->pass;
    }
    function areTheySecure()
    {
        if (!(filter_var($this->email, FILTER_VALIDATE_EMAIL))) {
            $this->errarr[] = "your email in a wrong format";
        } else if (!(filter_var($this->pass, FILTER_VALIDATE_INT))) {
            $this->errarr[] = "your password must be an email";
        }
    }
    function arePasswordMatch($pass2)
    {
        if ($this->pass !== $pass2) {
            $this->errarr[] = "password are not match they must be a match";
        }
    }

    function isThereIsAnError()
    {
        if (count($this->errarr) == 0) {
            return false;
        } else {
            return true;
        }
    }
    function printErrorsArray()
    {
        foreach ($this->errarr as $err) {
            echo "<div class='alert alert-danger'>" . $err . "</div>";
        }
    }
    function insertData()
    {
        $stmt = $this->con()->prepare("INSERT INTO `users` ( `email`, `password`, `privllage`, `created_at`, `last_login`) VALUES (?, ?, 0, now(), now())");
        $stmt->execute((array($this->email, sha1($this->pass))));
    }
    function updatePhase2($img, $email, $pass)
    {
        global $url;
        $stmt = $this->con()->prepare("UPDATE `users` SET `image` = ? WHERE email = ? AND password = ? AND username = ? ");
        $stmt->execute((array($img, $email, sha1($pass), "")));
        header("Location:" . $url . "/register.php?do=phase3");
    }
    function updateuseranme($username, $email, $pass)
    {
        global $url;
        $stmt = $this->con()->prepare("UPDATE `users` SET username = ? WHERE email = ? AND password = ?  ");
        $stmt->execute((array($username, $email, sha1($pass))));
    }
    function setDefaultUserName($username, $email, $pass)
    {
        //first select last id of  user 
        $stmt = $this->con()->prepare("SELECT * FROM `users` ORDER BY id DESC LIMIT 1  ");
        $stmt->execute();
        $row = $stmt->fetch();
        $defaultuser = 'user_' . $row['id'];
        $_SESSION['id'] = $row['id'];
        //make another call to database to update uername
        $this->updateuseranme($defaultuser, $email, $pass);
    }
    function setId($username, $email, $pass)
    {
        //first select last id of  user 
        $stmt = $this->con()->prepare("SELECT * FROM `users` ORDER BY id DESC LIMIT 1  ");
        $stmt->execute();
        $row = $stmt->fetch();

        $_SESSION['id'] = $row['id'];
    }
}
