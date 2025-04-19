<?php
            $conn = new mysqli('localhost', 'root','','dbms_it');

            if($conn->connect_error){
                echo "PHP Connection Failed".$conn->connect_error;
            }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>Document</title>

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            max-width: 100%;
            max-height: 100%;
            overflow: hidden;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4); 
        }

        .modal-content {
            position: fixed;
            background-color: #fefefe;
            margin: 15% auto;
            padding: 5px;
            border: 1px solid #888;
            width: 40%;
        }
    </style>
</head>
<body>
    <?php if (isset($_POST["Addloan"])): 
            $code = $_POST["Addloan"];
            $employee = $conn->query("SELECT Eid, employeeinfo.name FROM employeeinfo WHERE Eid = $code");
            $emp = $employee -> fetch_assoc();
            $loan = $conn->query("SELECT * FROM loan");
            $data = $loan -> fetch_assoc();
        ?>

        <form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
                <input type="hidden" name="Addloan" value="<?php echo $emp['Eid']; ?>">
                <div id="myModal" class="modal">
                    <div class="modal-content p-1">
                        <div class="modal-header">
                            <div class="container">
                                <div class="row"><h3><b>EMPLOYEE LOAN</b></h3></div>
                                <div class="row"><p>Add loan to <?php echo $emp['name'];?> </p></div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div>
                                <label class="form-label">Add Amount (Php)</label>
                                <input type="number" class="form-control" placeholder="Loan Amount" name="loan" required>
                            </div>
                            <div>
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control" name="loan_date" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button  type="submit" name="submitBtn" class="btn btn-primary">Save</button>
                            <button class="btn btn-primary close">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
            
        <script>
            window.onload = () => {
                document.getElementById("myModal").style.display = "block";
            };
        </script>
    <?php endif; ?>


    <?php
        if(isset($_POST["submitBtn"])){
            $original_code = $_POST['Addloan'];
            $loan_amount = $_POST["loan"];
            $loan_date = $_POST["loan_date"];

                $sql = "INSERT INTO loan (loan.Eid, loan.loanAmount, loan.date) VALUES 
                ($original_code, $loan_amount, '$loan_date')";

                if ($conn->query($sql) === TRUE) {
                    echo "<script> window.location.href = 'index.php'</script>";
                    } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
        }
    ?>

    <script>
        var modal = document.getElementById("myModal");
        var span = document.getElementsByClassName("close")[0];

        span.onclick = function() {
        modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        } 
    </script>
</body>
</html>