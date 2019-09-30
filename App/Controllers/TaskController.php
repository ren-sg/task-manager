<?php

namespace App\Controllers;

use Core\View;
use InvalidArgumentException;

class TaskController extends \Core\Controller {
    public $messages = [];

    public function addAction($query_params = []) {
        if (array_key_exists('submit', $_POST)) {
            $this->submit('add', $_POST);
        }
        $context = ['messages' => $this->messages, 'user' => $this->user];

        View::render('TaskCreate.html', $context);
    }

    public function editAction($query_params = []) {
        if (array_key_exists('submit', $_POST)) {
            $this->submit('edit', array_merge($_POST, ['id' => $query_params['id']]));
        }
        if ('admin' != $this->user['username']) {
            header('Location: /');
        }
        $context = ['messages' => $this->messages, 'user' => $this->user, 'query' => http_build_query($query_params)];
        if (isset($query_params['id'])) {
            $task_object = new \App\Models\TaskModel();
            $task = $task_object->getByID($query_params['id']);
            $context['task'] = $task;
        }

        View::render('TaskEdit.html', $context);
    }

    protected function submit($type, $params) {
        $task_object = new \App\Models\TaskModel();

        try {
            if ('add' == $type) {
                $tasks = $task_object->add($params);
            } elseif ('edit' == $type) {
                $tasks = $task_object->edit($params);
            }
            $this->messages['success'] = 'Success';
        } catch (InvalidArgumentException $e) {
            $this->messages['error'] = $e->getMessage();
        }
    }
}
