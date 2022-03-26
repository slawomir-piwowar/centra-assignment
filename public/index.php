<?php
declare(strict_types=1);

use Dotenv\Dotenv;
use KanbanBoard\Application;
use KanbanBoard\ApplicationNew;
use KanbanBoard\Authentication;
use KanbanBoard\Github;
use KanbanBoard\Utilities;

require_once __DIR__ . '/../vendor/autoload.php';

if ($_GET['test']) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    $repositories = explode('|', Utilities::env('GH_REPOSITORIES'));
    $authentication = new Authentication();
    $token = $authentication->login();
    $github = new Github($token, Utilities::env('GH_ACCOUNT'));
    $board = new Application($github, $repositories, array('waiting-for-feedback'));
    $data = $board->board();
    $m = new Mustache_Engine(array(
        'loader' => new Mustache_Loader_FilesystemLoader('../src/views'),
    ));
    echo $m->render('index', array('milestones' => $data));
    exit;
}

ApplicationNew::init()->run();
