<?php

class LoginContr extends Login
{
    private $email;
    private $pwd;

    public function __construct($email, $pwd)
    {
        $this->email = $email;
        $this->pwd = $pwd;
    }

    public function loginUser()
    {
        if ($this->emptyInput() == false) {
            header("location: ../home.php?error=emptyinput");
            exit();
        }

        if ($this->invalidEmail() == false) {
            header("location: ../home.php?error=email");
            exit();
        }

        $this->getUser($this->email, $this->pwd);
    }

    private function emptyInput()
    {
        if (empty($this->email) || empty($this->pwd)) {
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
}
