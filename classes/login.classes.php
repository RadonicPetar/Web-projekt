<?php

class Login extends Dbh{
    protected function getUser($email, $pwd){
        $statement = $this->connect()->prepare('SELECT users_pwd FROM users WHERE users_email = ?;');

        if(!$statement->execute(array($email))){
            $statement = null;
            header("location: ../home.php?error=statementfailed");
            exit();
        }

        if($statement->rowCount() == 0){
            $statement = null;
            header("location: ../home.php?error=usernotfound");
            exit(); 
        }

        $pwdHashed = $statement->fetchAll(PDO::FETCH_ASSOC);
        $checkPwd = password_verify($pwd, $pwdHashed[0]["users_pwd"]);

        if($checkPwd == false){
            $statement = null;
            header("location: ../home.php?error=wrongpassword");
            exit();
        }
        elseif($checkPwd == true){
            $statement = $this->connect()->prepare('SELECT * FROM users WHERE users_email = ?;');
           
            if(!$statement->execute(array($email))){
                $statement = null;
                header("location: ../home.php?error=statementfailed");
                exit();
            }

            if($statement->rowCount() == 0){
                $statement = null;
                header("location: ../home.php?error=usernotfound2");
                exit();
            }
    
            $user = $statement->fetchAll(PDO::FETCH_ASSOC);

            session_start();
            $_SESSION["userid"] = $user[0]["users_id"];
            $_SESSION["name"] = $user[0]["users_name"];

            $statement = null;
        }
    }
}
