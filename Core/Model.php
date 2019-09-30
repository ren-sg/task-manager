<?php

namespace Core;

use App\Config;
use PDO;

abstract class Model {
    public static function getUser() {
        static $user = null;
        if (isset($_SESSION['USER_ID'])) {
            $db = self::getDB();
            $sql = 'SELECT id,username FROM users WHERE id=:id LIMIT 1';
            $sth = $db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $sth->execute([':id' => $_SESSION['USER_ID']]);
            $data = $sth->fetch();
            if (isset($data['id'])) {
                $user = $data;
            }
        }

        return $user;
    }

    protected static function getDB() {
        static $db = null;
        $db = new \PDO('sqlite:' . Config::PATH_TO_SQLITE_FILE);
        $db->query('SET NAMES utf8');
        $db->query('SET CHARACTER_SET utf8_unicode_ci');

        return $db;
    }
}
