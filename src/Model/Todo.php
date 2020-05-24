<?php
namespace App\Model;

use App\Database\Database as DB;
use PDO;

class Todo extends DB{

  public function __construct(){
    parent::__construct();
  }

  public function addTodo($data){
    $db = $this->connection;
    $sql = "INSERT INTO `todos`(`todo`) VALUES (?)";
    $conn = $db->prepare($sql);
    $conn->bindParam(1,$data['todo']);
    $conn->execute();

    $todos = $this->showTodo();

    return $todos;

  }

  public function showTodo()
  {
    $db = $this->connection;
    $sql = "SELECT * FROM `todos`";
    $conn = $db->prepare($sql);
    $conn->setFetchMode(PDO::FETCH_ASSOC);
    $conn->execute();

    $allTodo = $conn->fetchAll();

    $countActiveTodo = $this->countTodo();

    return ['allTodo'=>$allTodo, 'countTodo'=>count($countActiveTodo)];

  }

  public function updateTodo($id, $todo)
  {
    $db = $this->connection;
    
    $sql = "UPDATE `todos` SET `todo`='$todo' WHERE `id`='$id'";
    $conn = $db->prepare($sql);
    $conn->execute();

    $todos=$this->showTodo();

    return $todos;
  }

  public function deleteTodo($id)
  {
    $db = $this->connection;
    $sql = "DELETE FROM `todos` WHERE `id`=$id";
    $conn = $db->prepare($sql);
    $conn->execute();

    $todos=$this->showTodo();

    return $todos;
  }

  public function completeTodo($id){

    $db = $this->connection;
    
    $sql = "UPDATE `todos` SET `is_completed`='1' WHERE `id`='$id'";
    $conn = $db->prepare($sql);
    $conn->execute();

    $todos=$this->showTodo();

    return $todos;
  }

  public function clearComplete($status)
  {
    $db = $this->connection;
    $sql = "DELETE FROM `todos` WHERE `is_completed`= 1 ";
    $conn = $db->prepare($sql);
    $conn->execute();

    $todos=$this->todoVariation($status);

    return $todos;
  }


  public function todoVariation($status){
    $db = $this->connection;

    if ($status == 2) {
      $sql = "SELECT * FROM `todos`";
    }
    else{
      $sql = "SELECT * FROM `todos` WHERE `is_completed`= '$status'";
    }

    $conn = $db->prepare($sql);
    $conn->setFetchMode(PDO::FETCH_ASSOC);
    $conn->execute();

    $todos = $conn->fetchAll();

    $countActiveTodo = $this->countTodo();

    return ['allTodo'=>$todos, 'countTodo'=>count($countActiveTodo)];
  }

  public function countTodo()
  {
    $db = $this->connection;

    $sql = "SELECT * FROM `todos` WHERE `is_completed`= '0'";

    $conn = $db->prepare($sql);
    $conn->setFetchMode(PDO::FETCH_ASSOC);
    $conn->execute();

    $todos = $conn->fetchAll();

    return $todos;
  }

}