<?php 
  require_once("vendor/autoload.php");
  use App\Model\Todo;

  $todo = new Todo();

  $todos = $todo->showTodo();

  $todoList = $todos['allTodo'];
  $countTodo  = $todos['countTodo'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="asset/style/style.css">
</head>
<body>
  <div class="todos">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-8 text-center">
          <h2 class="display-4 font-weight-bold">Todos</h2>
        </div>
        <div class="col-6">
          <div class="todo-body">
            <div class="add-todo">
              
              <span class="<?php count($todoList) > 0 ? print('todo-arrow') : print("todo-arrow invisible") ?>" id="todo-down-icon" >
                <svg class="bi bi-chevron-down" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 01.708 0L8 10.293l5.646-5.647a.5.5 0 01.708.708l-6 6a.5.5 0 01-.708 0l-6-6a.5.5 0 010-.708z" clip-rule="evenodd"/>
                </svg>
              </span>
              <input type="text" class="todo-input" name="todo" placeholder="What needs to be done?" onkeydown="if (event.keyCode == 13) { addTodo(this) }">
            </div>

            <div class="todo-info">
              
              <div id="todo-info" class="<?php count($todoList) > 0 ? print('todo-info') : print("todo-info d-none") ?>">
                <?php 
                  foreach ($todoList as $todo) {
                    $fieldClass = $todo['is_completed'] == 1 ? "todo-edit-input complete-todo-input" : "todo-edit-input";
                ?>
                  <div class="todo">
                    <div class="complete-todo" onclick="completeTodo(<?php echo $todo['id'] ?>)">
                      <svg class="bi bi-check-circle" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M15.354 2.646a.5.5 0 010 .708l-7 7a.5.5 0 01-.708 0l-3-3a.5.5 0 11.708-.708L8 9.293l6.646-6.647a.5.5 0 01.708 0z" clip-rule="evenodd"/>
                        <path fill-rule="evenodd" d="M8 2.5A5.5 5.5 0 1013.5 8a.5.5 0 011 0 6.5 6.5 0 11-3.25-5.63.5.5 0 11-.5.865A5.472 5.472 0 008 2.5z" clip-rule="evenodd"/>
                      </svg>
                    </div>
                    <input type="text" class="<?php echo $fieldClass ?>" id="todo-id-<?php echo $todo['id']?>" value="<?php echo $todo['todo']?>" onclick="editTodo(this, <?php echo $todo['id']?>)" readonly onkeydown="if (event.keyCode == 13) { event.preventDefault(); updateTodo(this, <?php echo $todo['id']?>) }">   

                    <div class="todo-discart" id="todo-discart-<?php echo $todo['id']?>" onclick="deleteTodo(<?php echo $todo['id']?>)">
                      <svg class="bi bi-x" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 010 .708l-7 7a.5.5 0 01-.708-.708l7-7a.5.5 0 01.708 0z" clip-rule="evenodd"/>
                        <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 000 .708l7 7a.5.5 0 00.708-.708l-7-7a.5.5 0 00-.708 0z" clip-rule="evenodd"/>
                      </svg>
                    </div>
                  </div>
                    
                <?php  
                  }
                ?>
              </div>
            </div>

            <div class="<?php count($todoList) > 0 ? print('todo-menu') : print('todo-menu d-none') ?>" id="todo-menu">
              <div class="row">
                <div class="col-3">
                  <span class="pl-2"><span id="count-todo"><?php echo $countTodo ?></span> items left</span>
                </div>
                <div class="col-6">
                  <div class="todo-menu-list">
                    <ul>
                      <li><button class="menu-btn" id='allTodo' onclick="todoVariation(this, 2)">All</button></li>
                      <li><button class="menu-btn" id='activeTodo' onclick="todoVariation(this, 0)">Active</button></li>
                      <li><button class="menu-btn" id="completeTodo" onclick="todoVariation(this, 1)">Completed</button></li>
                    </ul>
                  </div>
                </div>
                <div class="col-3">
                  <span class="clear-complete-todo d-none" id='clear-todo-list' onclick="clearComplete()">Clear complete</span>
                </div>
              </div>
            </div>

            
            
          </div>


          <div class="<?php count($todoList) > 0 ? print('box-shadow') : print('box-shadow d-none') ?>" id='box-shadow'>
            <div class="box-1"></div>
            <div class="box-2"></div>
          </div>

          
        </div>

      </div>
    </div>
  </div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script>

  // $(document).ready(function(){
    let menuStatus = '2'

    $('#allTodo').addClass('active')

    function addTodo(e) {

      let todo = e.value;

      const data = {
        todo
      }

      $.ajax({
        url: "controller/addTodo.php",
        type: "post",
        data: data,
        success: function (success) {
          let resData = $.parseJSON(success)
          $('#todo-info').removeClass('d-none')
          $('#todo-info').html(resData.allTodo)
          $('#count-todo').html(resData.count)

        }
      })

      e.value = ''
      $('#todo-down-icon').removeClass('invisible')
      $('#todo-menu').removeClass('d-none')
      $('#box-shadow').removeClass('d-none')

    }

    

    function editTodo(e, id) {
      $('#' + e.id).removeAttr('readonly')
      $('#' + e.id).addClass('edit-todo')
      $('#todo-discart-'+ id).addClass('todo-discart-remove')
    }

    function updateTodo(e, id) {
      
      $.ajax({
        url: `controller/updateTodo.php?id=${id}&todo=${e.value}`,
        type: "get",
        success: function (success) {
          let resData = $.parseJSON(success)
          $('#todo-info').html(resData.allTodo)
          $('#count-todo').html(resData.count)
        }
      })

      $('#' + e.id).attr('readonly', true)
      $('#' + e.id).removeClass('edit-todo')
      $('#todo-discart-'+ id).removeClass('todo-discart-remove')

    }

    function deleteTodo(id){
      $.ajax({
        url: `controller/removeTodo.php?id=${id}`,
        type: "get",
        success: function (success) {
          let resData = $.parseJSON(success)
          $('#todo-info').html(resData.allTodo)
          $('#count-todo').html(resData.count)
        }
      })
    }

    function completeTodo(id){

      $.ajax({
        url: `controller/completeTodo.php?id=${id}`,
        type: "get",
        success: function (success) {
          let resData = $.parseJSON(success)
          $('#todo-info').html(resData.allTodo)
          $('#count-todo').html(resData.count)
          $('#clear-todo-list').removeClass('d-none')
        }
      })
    }

    function clearComplete(){
      $.ajax({
        url: `controller/clearComplete.php?status=${menuStatus}`,
        type: "get",
        success: function (success) {
          let resData = $.parseJSON(success)
          $('#todo-info').html(resData.allTodo)
          $('#count-todo').html(resData.count)
          $('#clear-todo-list').addClass('d-none')
        }
      })
    }

    function todoVariation(e, status){
      $('.menu-btn').removeClass('active')
      $('#'+ e.id).addClass('active')

      menuStatus = status

      $.ajax({
        url: `controller/todoVariation.php?status=${status}`,
        type: "get",
        success: function (success) {
          let resData = $.parseJSON(success)
          $('#todo-info').html(resData.allTodo)
          $('#count-todo').html(resData.count)
        }
      })
    }
  // })
  

</script>



</body>
</html>