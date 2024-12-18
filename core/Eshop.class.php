<?php
class Eshop {
    private static $db;

    public static function init($dbSettings) {
        $dsn = "mysql:host={$dbSettings['HOST']};dbname={$dbSettings['NAME']};charset=utf8";
        try {
            self::$db = new PDO($dsn, $dbSettings['USER'], $dbSettings['PASS']);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Соединение с базой данных установлено успешно!";
        } catch (PDOException $e) {
            die("Ошибка соединения с базой данных: " . $e->getMessage());
        }
    }

    public static function userAdd(User $user) {
        $stmt = self::$db->prepare("CALL spSaveAdmin(:login, :password, :email)");
        $stmt->bindParam(':login', $user->login);
        $stmt->bindParam(':password', $user->password);
        $stmt->bindParam(':email', $user->email);
        return $stmt->execute();
    }

    public static function userCheck(User $user): bool {
        $stmt = self::$db->prepare("CALL spGetAdmin(:login)");
        $stmt->bindParam(':login', $user->login);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && password_verify($user->password, $result['password']);
    }

    public static function userGet($login): User {
        $stmt = self::$db->prepare("CALL spGetAdmin(:login)");
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return new User($result['login'], $result['password'], $result['email']);
    }

    public static function createHash(string $password): string {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function isAdmin(): bool {
        return isset($_SESSION['admin']);
    }

    public static function logIn($login) {
        $_SESSION['admin'] = $login;
    }

    public static function logOut() {
        unset($_SESSION['admin']);
    }
}


?>
