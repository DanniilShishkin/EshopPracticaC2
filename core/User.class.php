<?php
class User {
    public $login;
    public $password;
    public $email;

    public function __construct($login, $password, $email) {
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
    }
}
?>
