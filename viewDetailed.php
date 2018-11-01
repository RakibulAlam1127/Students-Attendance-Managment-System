<?php
 #include the essential file;
include_once 'Database.php';
   if (isset($_GET['date'])){
       $date = $_GET['date'];
   }else{
       header('Location:viewAttendance.php');
   }
   $result = $database->getDataById('attendance_tbl',$date);
   $result->execute();






?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>View Detailed Page</title>
</head>
<body>
    <div class="container">
            <div class="card">
                  <div class="card-header">
                       <div class="card-title">
                            <h2 class="text-center text-danger">View Attendance Detailed Of - <?php echo $date; ?></h2>
                       </div>
                  </div>
                <div class="card-body">
<!--                      Our attendance detailed will be goes here.-->
                    <table class="table">
                        <thead>
                        <tr>
                             <th>#</th>
                            <th>Student Id</th>
                            <th>Attend</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                           <?php
                              if ($result->rowCount() > 0){
                                  $i = 1;
                                  while ($data = $result->fetch(PDO::FETCH_ASSOC)){
                                      ?>
                                      <tr>
                                          <td><?php echo $data['id']; ?></td>
                                          <td><?php echo $data['student_id']; ?></td>
                                            <td>
                                                <?php
                                                   if ($data['attendance'] == 'p'){
                                                       ?>
                                                       <input type="radio" checked>Present
                                                       <?php
                                                   }else{
                                                       ?>
                                                       <input type="radio" >Absent
                                                       <?php
                                                   }
                                                ?>
                                            </td>
                                          <td>
                                              <a href="upgrade.php?student_id=<?php echo $data['student_id'];?>&&date=<?php echo $data['date'];?>" class="btn btn-sm btn-info">Upgrade Attendance</a>
                                          </td>
                                      </tr>
                           <?php
                                      $i++;
                                  }
                              }
                           ?>
                        </tbody>
                    </table>
                    <a href="viewAttendance.php" style="margin-left: 50%" class="btn btn-primary">Back</a>

                </div>
            </div>
    </div>
</body>
</html>