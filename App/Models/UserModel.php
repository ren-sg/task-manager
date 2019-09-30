<?php

namespace App\Models;

use PDO;

class UserModel extends \Core\Model {
    public static function login($data = []) {
        if (!isset($_SESSION['USER_ID']) && self::validate($data)) {
            $db = static::getDB();
            $sql = 'SELECT * FROM users WHERE username = :username AND password = :password LIMIT 1';
            $sth = $db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $sth->execute([':username' => $data['username'], ':password' => $data['password']]);
            $user = $sth->fetch();
            if (isset($user['id'])) {
                $_SESSION['USER_ID'] = $user['id'];

                return $user;
            }
        }

        return false;
    }

    public static function logout() {
        if (isset($_SESSION['USER_ID'])) {
            unset($_SESSION['USER_ID']);

            return true;
        }

        return false;
    }

    public static function getUserByID($id) {
        var_dump(self::$user);
    }

    public static function validate($data = []) {
        if (!$data['username']) {
            throw new \InvalidArgumentException("Invalid username: {$data['username']}");
        }
        if (!$data['password']) {
            throw new \InvalidArgumentException("Invalid password: {$data['password']}");
        }

        return $data;
    }
}
