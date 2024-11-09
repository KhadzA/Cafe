<?php

include "../model/signup.model.php";


class signupCtrl extends Signup {

    private $username;
    private $email;
    private $password;
    private $confirmPassword;

    public function __construct($username, $email, $password, $confirmPassword) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
    }

    public function signupUser() {
        if (!$this->emptyInput()) {
            header("location: ../index.php?error=emptyinput");
            exit();
        }
        if (!$this->invalidInput()) {
            header("location: ../index.php?error=invalidinput");
            exit();
        }
        if (!$this->invalidEmail()) {
            header("location: ../index.php?error=invalidemail");
            exit();
        }
        if (!$this->passwordMatch()) {
            header("location: ../index.php?error=passwordmismatch");
            exit();
        }
        if (!$this->userTaken()) {
            header("location: ../index.php?error=useroremailtaken");
            exit();
        }

        $this->setUser($this->username, $this->email, $this->password);
    }

    private function emptyInput() {
        return !empty($this->username) && !empty($this->email) && !empty($this->password) && !empty($this->confirmPassword);
    }

    private function invalidInput() {
        return preg_match("/^[a-zA-Z0-9]*$/", $this->username);
    }

    private function invalidEmail() {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    private function passwordMatch() {
        return $this->password === $this->confirmPassword;
    }

    private function userTaken() {
        return $this->checkUser($this->username, $this->email);
    }
}
