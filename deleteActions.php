<?php
        $conn = new mysqli('localhost', 'root','','dbms_it');

        if($conn->connect_error){
            echo "PHP Connection Failed".$conn->connect_error;
        }

        try{
          if(isset($_POST['delBtn'])){
            $delValue = $_POST['delBtn'];
            $tblName = $_POST['tbl_name'];
            $pKey = $_POST['pKey'];

            $sql = "DELETE FROM $tblName WHERE $pKey = $delValue";
            if ($conn->query($sql) === TRUE) {
                echo "<script> window.location.href = 'index.php';</script>";
              } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
              }
        }
        }catch(Exception $e){
          echo "<script>alert('Table is referenced in other table. Cannot Delete.'); window.location.href = 'index.php';</script>";
        }
?>
