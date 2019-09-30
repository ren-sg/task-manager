<?php

namespace App\Models;

use PDO;

class TaskModel extends \Core\Model {
    public static function getAll($params = ['start_pos' => 0, 'per_page' => 20, 'sort' => 'id', 'dir' => 'ASC']) {
        $db = static::getDB();

        $sql = "SELECT * FROM tasks ORDER BY {$params['sort']} {$params['dir']} LIMIT :start_pos, :per_page";
        $sth = $db->prepare($sql);

        $sth->execute([
            ':start_pos' => $params['start_pos'],
            ':per_page' => $params['per_page'],
        ]);
        $tasks = $sth->fetchAll();

        return $tasks;
    }

    public static function count() {
        $db = static::getDB();
        $query = $db->query('SELECT COUNT(*) FROM tasks');

        return $query->fetchColumn();
    }

    public static function getByID($id) {
        $db = static::getDB();
        $sql = 'SELECT * FROM tasks WHERE id = :id LIMIT 1';
        $sth = $db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute([':id' => $id]);
        $task = $sth->fetch();

        return $task;
    }

    public static function add($data = []) {
        $db = static::getDB();
        $data = self::validate($data);
        if (self::validate($data)) {
            $sql = 'INSERT INTO tasks (user, email, text) VALUES (:username, :email, :text);';
            $query = $db->prepare($sql);
            $query->execute([
                ':username' => $data['username'],
                ':email' => $data['email'],
                ':text' => $data['text'],
            ]);
        }
    }

    public static function edit($data = []) {
        $db = static::getDB();
        $data = self::validate($data);
        if (self::validate($data)) {
            $sql = 'UPDATE tasks SET user = :username, email = :email, text = :text, status = :status WHERE id = :id';
            $query = $db->prepare($sql);
            $query->execute([
                ':username' => $data['username'],
                ':email' => $data['email'],
                ':text' => $data['text'],
                ':id' => $data['id'],
                ':status' => $data['status'],
            ]);
        }
    }

    public static function validate($data = []) {
        if (!$data['username']) {
            $data['username'] = 'guest';
        }
        if (!$data['email']) {
            throw new \InvalidArgumentException("Invalid Email: {$data['email']}");
        }
        if (!$data['text']) {
            throw new \InvalidArgumentException('Invalid task text');
        }
        if (isset($data['checked'])) {
            $data['status'] = 'Y';
        } else {
            $data['status'] = 'N';
        }

        return $data;
    }
}
