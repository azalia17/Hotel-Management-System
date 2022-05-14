<?php
    session_start();
    $db = pg_connect("host=localhost port=5432 dbname=Hotel user=postgres password=123456");
    $ssn=$_GET['ssn'];

    $query = "DELETE FROM employee WHERE ssn='$ssn';";    
                                                                                        
    
    $result_delete = pg_query($query); 

    if (!$result_delete)
    {
        $_SESSION['status_deleted'] = "Delete failed!!";
    } else {
        $_SESSION['status_deleted'] = "Succesfully delete data!";
        header('Location:employee.php');
    }
?>