<?php

class SignupContr extends Signup
{
    private $name;
    private $lname;
    private $email;
    private $pwd;
    private $pwdRepeat;

    public function __construct($name, $lname, $email, $pwd, $pwdRepeat)
    {
        $this->name = $name;
        $this->lname = $lname;
        $this->email = $email;
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
    }

    public function signupUser()
    {
        if ($this->emptyInput() == false) {
            header("location: ../home.php?error=emptyinput");
            exit();
        }
        



        if ($this->invalidEmail() == false) {
            header("location: ../home.php?error=email");
            exit();
        }
        if ($this->pwdMatch() == false) {
            header("location: ../home.php?error=passwordmatch");
            exit();
        }
        if ($this->uidTakenCheck() == false) {
            header("location: ../home.php?error=emailtaken");
            exit();
        }

        $this->setUser($this->name, $this->lname, $this->pwd, $this->email);
    }

    private function emptyInput()
    {
        if (empty($this->name) || empty($this->lname) || empty($this->email) || empty($this->pwd) || empty($this->pwdRepeat)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function invalidName()
    {
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->name) || !preg_match("/^[a-zA-Z0-9]*$/", $this->lname)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function invalidEmail()
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function pwdMatch()
    {
        if ($this->pwd !== $this->pwdRepeat) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function uidTakenCheck()
    {
        if (!$this->checkUser($this->email)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
}
