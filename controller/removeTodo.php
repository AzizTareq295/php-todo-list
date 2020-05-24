<?php

  require_once("../vendor/autoload.php");
  include_once("createView.php");

  use App\Model\Todo;

  $todo = new Todo();
  $view = new createView();


  $todos = $todo->deleteTodo($_GET['id']);

  $todoView = $view->view($todos['allTodo']);

  $todosInfo = ['allTodo' => $todoView, 'count' => $todos['countTodo']];

  echo json_encode($todosInfo);

?>