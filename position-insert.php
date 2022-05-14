<?php
    session_start();
$db = pg_connect("host=localhost port=5432 dbname=Hotel user=postgres password=123456");
$count = "SELECT COUNT(position_id)::int as id from position";
$total_count = pg_query($count);
$row = pg_fetch_row($total_count);
$id2 = $row[0] + 1;

$name = $_POST['position'];

    
    $query = "INSERT INTO position (position_id, position_name) VALUES ($id2, '$name')";

$result_insert = pg_query($query); 

    if (!$result_insert)
    {
        $_SESSION['insert_position_failed'] = "Insert failed!!";
    } else {
      $_SESSION['insert_position_success'] = "Succesfully added $name!";
      header('Location:employee.php');
    }



?>