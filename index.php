<?php
            $conn = new mysqli('localhost', 'root','','dbms_it');

            if($conn->connect_error){
                echo "PHP Connection Failed".$conn->connect_error;
            }

            $tableName = "employeeinfo";
            $pKey = "Eid";
            $totalLoan = $conn->query("SELECT DISTINCT employeeinfo.Eid, employeeinfo.name, employeeinfo.position, employeeinfo.salary, employeeinfo.age, employeeinfo.address, employeeinfo.deptCode, SUM(loan.loanAmount) as totalLoan FROM loan RIGHT JOIN employeeinfo ON loan.Eid = employeeinfo.Eid GROUP BY employeeinfo.Eid");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>Employee Loan</title>

    <style>
        .sidnav {
            display: flex;
            flex-wrap: nowrap;
            height: 100vh;
            height: -webkit-fill-available;
            max-height: 100vh;
            overflow-x: auto;
            overflow-y: hidden;
        }
        .cred{
          font-size: 12px;
        }
    </style>

</head>
<body>
    <?php
        include("Shared/nav.html");
    ?>

    
    <div class="container">
      <div class="row">
      </div>
      <div class="row">
        <div class="col">
          <table class="table mt-2">
          <thead class="border border-secondary align-middle">
            <tr>
              <th scope="col">Employee ID</th>
              <th scope="col">Name</th>
              <th scope="col">Position</th>
              <th scope="col">Salaray </th>
              <th scope="col">Age</th>
              <th scope="col">Address</th>
              <th scope="col">Dept. Code</th>
              <th scope="col">Loan Total</th>
              <th scope="col">
                <div class="col">
                  <a href="addemployee.php">
                    <button class="btn btn-success text-center d-flex justify-content-center align-items-center w-100 ">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square me-1" viewBox="0 0 16 16">
                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                      </svg>
                      Add Employee
                    </button>
                  </a>
                </div>
              </th>
            </tr>
          </thead>
          <tbody class="border border-secondary align-middle">
            <tr>
              <?php while($row = $totalLoan->fetch_assoc()): ?>
                <tr>
                      <td>
                          <?php echo $row['Eid'];?>
                      </td>
                      <td>
                          <?php echo $row['name'];?>
                      </td>
                      <td>
                          <?php echo $row['position'];?>
                      </td>
                      <td>
                          <?php echo "Php ".$row['salary'];?>
                      </td>
                      <td>
                          <?php echo $row['age']?>
                      </td>
                      <td>
                          <?php echo $row['address']?>
                      </td>
                      <td>
                          <?php echo $row['deptCode']?>
                      </td>
                      <td>
                          <?php 
                            if(empty($row['totalLoan'])){
                              echo 'No Loan';
                            }else{
                              echo "Php ".$row['totalLoan'];
                            };
                          ?>
                      </td>
                      <td>
                          <div class='btn-group' role='group'>
                            <form action="<?php $_SERVER["PHP_SELF"]?>" method='POST'>
                              <button type='submit' name='viewLoan' value="<?php echo $row["Eid"]?>" class='btn btn-secondary mx-1 d-inline-flex align-items-center h-100'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                  <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                  <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                </svg>
                              </button>
                            </form>
                            <form action="<?php $_SERVER["PHP_SELF"]?>" method='POST'>
                              <button type='submit' name='Addloan' value="<?php echo $row["Eid"]?>" class='btn btn-secondary  d-inline-flex align-items-center h-100'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                </svg>
                              </button>
                            </form>
                            <form action='editemployee.php' method = 'POST'>
                                <button type='submit' value="<?php echo $row["Eid"]?>" name='EdBtn' class='btn btn-warning mx-1'>Edit</button>
                            </form>
                            <form action ='deleteActions.php' method='POST' onsubmit = 'return confirmDel();'>
                                <input type='hidden' name='tbl_name' value="<?php echo $tableName;?>"></input>
                                <input type='hidden' name='pKey' value="<?php echo $pKey;?>"></input>
                                <button type='submit' name='delBtn' value="<?php echo $row["Eid"]?>" class='btn btn-danger'>Delete</button>
                            </form>
                          </div>
                      </td>
                  </tr>
              <?php endwhile; ?>
            </tr>
          </tbody>
        </table>
        </div>
      </div>
    </div>
<p class="cred d-flex justify-content-center">PLSP-BSIT 2A Jean Edrich Lorico</p>
    <script src="script/script.js"></script>

    <?php
        include("modal.php");
    ?>

    <?php
        include("viewLoan.php");
    ?>
</body>
</html>