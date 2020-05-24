<?php 

  class createView {

    public function view($array){

      $html = '';


      foreach ($array as $item) {

        $id = $item['id'];

        $todo_name = $item['todo'];

        $fieldClass = $item['is_completed'] == 1 ? "todo-edit-input complete-todo-input" : "todo-edit-input";

        $html .= "
          <div class='todo'>
            <div class='complete-todo' onclick='completeTodo($id)'>
              <svg class='bi bi-check-circle' width='1em' height='1em' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                <path fill-rule='evenodd' d='M15.354 2.646a.5.5 0 010 .708l-7 7a.5.5 0 01-.708 0l-3-3a.5.5 0 11.708-.708L8 9.293l6.646-6.647a.5.5 0 01.708 0z' clip-rule='evenodd '/>
                <path fill-rule='evenodd' d='M8 2.5A5.5 5.5 0 1013.5 8a.5.5 0 011 0 6.5 6.5 0 11-3.25-5.63.5.5 0 11-.5.865A5.472 5.472 0 008 2.5z' clip-rule='evenodd'/>
              </svg>
            </div>
            <input type='text' class='$fieldClass' id='todo-id-$id' 
            value='".$todo_name."' onclick='editTodo(this, $id)' readonly onkeydown='if (event.keyCode == 13) { event.preventDefault(); updateTodo(this, $id) }'>   

            <div class='todo-discart' id='todo-discart-$id' onclick='deleteTodo($id)'>
              <svg class='bi bi-x' width='1em' height='1em' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                <path fill-rule='evenodd' d='M11.854 4.146a.5.5 0 010 .708l-7 7a.5.5 0 01-.708-.708l7-7a.5.5 0 01.708 0z' clip-rule='evenodd'/>
                <path fill-rule='evenodd' d='M4.146 4.146a.5.5 0 000 .708l7 7a.5.5 0 00.708-.708l-7-7a.5.5 0 00-.708 0z' clip-rule='evenodd'/>
              </svg>
            </div>
          </div>
        ";

      }

      return $html;

    }

  }

?>