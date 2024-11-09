<?php

include "../model/login.model.php";


class LoginCtrl extends Login {
    private $username;
    private $password;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function loginUser() {
        if (!$this->emptyInput()) {
            header("location: ../index.php?error=emptyinput");
            exit();
        }

        $this->login($this->username, $this->password);
    }

    private function emptyInput() {
        return !empty($this->username) && !empty($this->password);
    }
}
