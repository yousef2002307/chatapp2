<?php
class securityGuard extends connection
{
    protected $email;
    protected $pass;
    protected $errarr = array();
    public function __construct($name, $age)
    {
        $this->email = $name;
        $this->pass = $age;
    }
    function areThereAnyErrors()
    {
        $bool = true;

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errarr, lang("emailerror"));
            $bool = false;
        }
        if (strlen(strval($this->pass)) < 4) {
            array_push($this->errarr, lang("passerror"));
            $bool = false;
        }
        if ($this->email == '' || $this->pass == '') {
            array_push($this->errarr, lang("emptyerror"));
            $bool = false;
        }
        return $bool;
    }
    function printErrorsArray()
    {
        foreach ($this->errarr as $err) {
            echo "<div class='alert alert-danger'>" . $err . "</div>";
        }
    }
    function checkIfDataExcist()
    {
        $password = sha1($this->pass);
        $email = $this->email;
        $stmt = $this->con()->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->execute(array($email, $password));
        $count = $stmt->rowCount();
        return $count;
    }
    function wrongData($count)
    {
        if ($count == 0) {
            return "<div class='alert alert-danger'>" . lang("wrongdata") . "</div>";
        } else {
            return "";
        }
    }
    function getId($par1, $par2)
    {

        $stmt = $this->con()->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->execute(array($par1, sha1($par2)));
        $rows = $stmt->fetch();
        $count = $stmt->rowCount();
        return $rows['id'];
    }
    function updateLoginDate($id)
    {
        $stmt = $this->con()->prepare("UPDATE `users` SET `last_login` = now() WHERE `users`.`id` = ?");
        $stmt->execute(array($id));
    }
}
