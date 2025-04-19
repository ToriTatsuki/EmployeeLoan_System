<?php
            $conn = new mysqli('localhost', 'root','','dbms_it');

            if($conn->connect_error){
                echo "PHP Connection Failed".$conn->connect_error;
            }

            $tableName = "loan";
            $pKey = "loanID";

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
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4); 
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
            overflow: hidden;
            display: flex;
            flex-direction: column; 
        }

        .modal-body{
            overflow-y: auto;
            max-height: 30vh;
        }
    </style>
</head>
<body>
    <?php if (isset($_POST["viewLoan"])): 
            $code = $_POST["viewLoan"];
            $loan = $conn->query("SELECT * FROM loan WHERE Eid = $code");
            $emp = $conn->query("SELECT Eid, employeeinfo.name FROM employeeinfo WHERE Eid = $code");
            $data = $emp->fetch_assoc();
        ?>
                <div id="viewModal" class="modal">
                    <div class="modal-content over p-1">
                        <div class="modal-header">
                            <div class="container">
                                <div class="row"><h3><b>EMPLOYEE LOAN</b></h3></div>
                                <div class="row"><p><?php echo $data['name'];?>'s loan details </p></div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Loan Amount
                                        </th>
                                        <th>
                                            Date
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = $loan->fetch_assoc()) : ?>
                                        <tr>
                                            <td>
                                                <?php echo $row['Eid']?>
                                            </td>
                                            <td>
                                                <?php echo $row['loanAmount']?>
                                            </td>
                                            <td>
                                                <?php echo $row['date']?>
                                            </td>
                                            <td>
                                                <form action="deleteActions.php" method="POST" onsubmit = 'return confirmDel();'>
                                                <input type='hidden' name='tbl_name' value="<?php echo $tableName;?>"></input>
                                                <input type='hidden' name='pKey' value="<?php echo $pKey;?>"></input>   
                                                    <button type="submit" name="delBtn" value="<?php echo $row["loanID"]?>" class="btn btn-danger d-inline-flex align-items-center h-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endwhile;?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" id="close">Cancel</button>
                        </div>
                    </div>
                </div>
        <script src="script/script.js"></script>
        <script>

            window.onload = () => {
                document.getElementById("viewModal").style.display = "block";
            };

            document.getElementById("close").addEventListener('click', function(){
                document.getElementById("viewModal").style.display = "none";
            });
        </script>
    <?php endif; ?>
</body>
</html>