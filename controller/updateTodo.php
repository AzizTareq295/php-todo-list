<?php 
  require_once("../vendor/autoload.php");
  include_once("createView.php");

  use App\Model\Todo;

  $todo = new Todo();

  $view = new createView();

  $todos = $todo->updateTodo($_GET['id'], $_GET['todo']);

  $todoView = $view->view($todos['allTodo']);

  $todosInfo = ['allTodo' => $todoView, 'count' => $todos['countTodo']];

  echo json_encode($todosInfo);

?>