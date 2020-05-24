<?php
namespace App\Database;

use PDO;
use PDOException;

class Database{

    public  $connection;
    public  $host="localhost";
    public  $dbname="todo_list";
    public  $user="root";
    public  $pass="";

    public  function __construct(){
        try  {



            $host=$this->host;
            $dbname=$this->dbname;
            $user=$this->user;
            $pass=$this->pass;


            $this->connection = new PDO("mysql:host=$host;dbname=$dbname",$user, $pass);

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }
        catch(PDOException $e){

            echo "Connection failed: " . $e->getMessage();
        }
    }
}
