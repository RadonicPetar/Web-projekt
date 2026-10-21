<?php

class Signup extends Dbh
{
    protected function setUser($name, $lname, $pwd, $email)
    {
        $statement = $this->connect()->prepare('INSERT INTO users (users_name, users_lname, users_pwd, users_email) VALUES (?, ?, ?, ?);');

        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        if (!$statement->execute(array($name, $lname, $hashedPwd, $email))) {
            $statement = null;
            header("location: ../home.php?error=statementfailed");
            exit();
        }

        $statement = null;
    }

    protected function checkUser($email)
    {
        $statement = $this->connect()->prepare('SELECT users_email FROM users WHERE users_email = ?;');

        if (!$statement->execute(array($email))) {
            $statement = null;
            header("location: ../home.php?error=statementfailed");
            exit();
        }

        if ($statement->rowCount() > 0) {
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }

        return $resultCheck;
    }
}
