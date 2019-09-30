<?php

namespace App\Controllers;

use Core\View;

class HomeController extends \Core\Controller {
    const per_page = 5;
    public $pager = [];

    public function getPager($query_params = [], $count = 0) {
        $pager = [
            'start_page' => 0,
            'per_page' => self::per_page,
            'next' => 2,
        ];
        $pager['pages'] = ceil($count / self::per_page);

        if (!isset($query_params['page']) || '1' == $query_params['page']) {
            $query_params['page'] = 1;
            $pager['current'] = 1;
        } else {
            $pager['current'] = $query_params['page'];
            $pager['prev'] = $query_params['page'] - 1;
            $pager['start_page'] = ($pager['start_page'] + $pager['per_page']) * $pager['current'] - $pager['per_page'];
        }

        $pager['next'] = ($query_params['page'] + 1) <= $pager['pages'] ? $query_params['page'] + 1 : null;
        $query_params['page'] = $pager['current'];
        unset($query_params['page']);
        $pager['query_string'] = http_build_query($query_params);

        return $pager;
    }

    public function indexAction($query_params = []) {
        $task_object = new \App\Models\TaskModel();
        $count = $task_object->count();
        $pager = $this->getPager($query_params, $count);
        $filter = [
            'start_pos' => $pager['start_page'],
            'per_page' => $pager['per_page'],
        ];
        $filter['sort'] = 'id';
        $sort_dir = $filter['dir'] = 'ASC';

        if (isset($query_params['dir']) && 'ASC' == $query_params['dir']) {
            $sort_dir = $filter['dir'] = 'DESC';
        }
        if (isset($query_params['sort'])) {
            $filter['sort'] = $query_params['sort'];
        }
        $tasks = $task_object->getAll($filter);

        $context = ['tasks' => $tasks, 'user' => $this->user, 'pager' => $pager, 'sort_dir' => $sort_dir];
        View::render('Home.html', $context);
    }
}
