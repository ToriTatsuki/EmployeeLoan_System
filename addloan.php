<?php
            $conn = new mysqli('localhost', 'root','','dbms_it');

            if($conn->connect_error){
                echo "PHP Connection Failed".$conn->connect_error;
            }
            
            $code = $_POST["EdBtn"];

            $sql = "SELECT * FROM employeeinfo";
            $dept = $conn->query("SELECT * FROM departmentinfo");
            $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Building</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="Styles/site.css"> 
</head>
<body>
    <?php
        include("Shared/nav.html");
    ?>

    <div class="container">
        <div class="row">
            <h1><b>Add Employee</b></h1>
            <p>Add employee data to database records.</p>
        </div>
    </div>

    <form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
        <div class="container mt-2">
            <div class="row g-2">
                <div class="col">
                    <input class="form-control" placeholder="Full name" name="eName" required>
                </div>
                <div class="col">
                    <input class="form-control" placeholder="Position" name="ePos" required>
                </div>
                <div class="col">
                    <input type="number" class="form-control" placeholder="Salary" name="eSal" required>
                </div>
            </div>
            <div class="row g-2 mt-2">
                <div class="col">
                    <input type="number" class="form-control" placeholder="Age" name="eAge" required>
                </div>
                <div class="col">
                    <input class="form-control" placeholder="Address" name="eAdd" required>
                </div>
                <div class="col">
                    <select class="form-select" name="eDept">
                        <option selected disabled>-- Department --</option>
                        <?php
                            while ($row = $dept->fetch_assoc()) {
                                echo "<option value='" . $row['deptCode'] . "'>" . $row['deptDescription']. "</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row g-2 mt-2 d-flex justify-content-center">
                <div class="col-2">
                    <button type="submit" name="submitBtn" class="btn btn-success w-100">Add</but>
                </div>
                <div class="col">
                    <button class="btn btn-primary" onclick="history.back()">Go Back</button>
                </div>
            </div>
        </div>
    </form>

    <?php

        if(isset($_POST["submitBtn"])){
            $eName = $_POST['eName'];
            $ePos = $_POST['ePos'];
            $eSal = $_POST['eSal'];
            $eAge = $_POST['eAge'];
            $eAdd = $_POST['eAdd'];
            $eDept = $_POST['eDept'];


                $sql = "INSERT INTO employeeinfo (employeeinfo.name, position, salary, age, employeeinfo.address, deptCode) VALUES 
                ('$eName', '$ePos', $eSal, $eAge, '$eAdd', '$eDept')";
                if ($conn->query($sql) === TRUE) {
                    echo "<script> window.location.href = 'index.php'</script>";
                    } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
        }
    ?>
</body>
</html>