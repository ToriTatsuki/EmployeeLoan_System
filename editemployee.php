<?php
            $conn = new mysqli('localhost', 'root','','dbms_it');

            if($conn->connect_error){
                echo "PHP Connection Failed".$conn->connect_error;
            }
            
            $code = $_POST["EdBtn"];

            $deptCode = $conn->query("SELECT * FROM departmentinfo");
            $result = $conn->query("SELECT * FROM employeeinfo WHERE employeeinfo.Eid = $code");
            $data = $result -> fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit-Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="Styles/site.css"> 
</head>
<body>
    <?php
        include("Shared/nav.html");
    ?>

    <div class="container">
        <div class="row">
            <h1><b>Edit Employee</b></h1>
            <p>Edit employee data to database records.</p>
        </div>
    </div>

    <form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
        <div class="container mt-2">
            <input type="hidden" name="EdBtn" value="<?php echo $data['Eid']; ?>">
            <div class="row g-2">
                <div class="col">
                    <input class="form-control" placeholder="Full name" name="eName" value="<?php echo $data["name"]?>" required>
                </div>
                <div class="col">
                    <input class="form-control" placeholder="Position" name="ePos" value="<?php echo $data["position"]?>" required>
                </div>
                <div class="col">
                    <input type="number" class="form-control" placeholder="Salary" name="eSal" value="<?php echo $data["salary"]?>" required>
                </div>
            </div>
            <div class="row g-2 mt-2">
                <div class="col">
                    <input type="number" class="form-control" placeholder="Age" name="eAge" value="<?php echo $data["age"]?>" required>
                </div>
                <div class="col">
                    <input class="form-control" placeholder="Address" name="eAdd" value="<?php echo $data["address"]?>" required>
                </div>
                <div class="col">
                    <select class="form-select" name="eDept" required>
                        <option disabled value="<?php echo $data["deptCode"]?>">-- Department --</option>
                        <?php foreach ($deptCode as $dept): ?>
                            <option value="<?= $dept['deptCode']; ?>" 
                                <?= $data['deptCode'] == $dept['deptCode'] ? 'selected' : '' ?>>
                                <?= $dept['deptCode']." -- ".$dept['deptDescription']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row g-2 mt-2 d-flex justify-content-center">
                <div class="col-2">
                    <button type="submit" name="submitBtn" class="btn btn-success w-100">Update</but>
                </div>
                <div class="col">
                    <button class="btn btn-primary" onclick="history.back()">Go Back</button>
                </div>
            </div>
        </div>
    </form>

    <?php
        if (isset($_POST['submitBtn'])) {
            $original_code = $_POST['EdBtn'];

            $eName = $_POST['eName'];
            $ePos = $_POST['ePos'];
            $eSal = $_POST['eSal'];
            $eAge = $_POST['eAge'];
            $eAdd = $_POST['eAdd'];
            $eDept = $_POST['eDept'];

            $sql = "UPDATE employeeinfo 
                    SET employeeinfo.name = '$eName', position = '$ePos', salary = $eSal, age = $eAge, employeeinfo.address = '$eAdd', deptCode = '$eDept' 
                    WHERE Eid = '$original_code'";

            if ($conn->query($sql) === TRUE) {
                echo "<script>window.location.href='index.php';</script>";
            } else {
                echo "Error: " . $conn->error;
            }
        }
    ?>
</body>
</html>