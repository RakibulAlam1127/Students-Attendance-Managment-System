<?php
  error_reporting('absent');
     #Include the Database file;
  include_once 'Database.php';
session_start();
$atten = $database->fetchDate('attendance_tbl','date',[]);
$atten->execute();
$atten_date = $atten->fetchAll(PDO::FETCH_ASSOC);





    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $attendance = $_POST['atten'];
        $currentDate = date('Y-m-d');
        $search_date = $database->searchDate('attendance_tbl');
        $search_date->execute();
        if($search_date->rowCount() >=1){
            $_SESSION['message'] = 'Attendance Was Already Taken';
        }else{
            foreach ($attendance as $key => $value) {
                $database->insertData('attendance_tbl',[
                    'date' => $currentDate,
                    'attendance' => $value,
                    'student_id' => $key
                ]);
            }
        }
}




$result = $database->selectData('students_tbl','*',[]);
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
    <title>Students Attendance System</title>
</head>
<body>
       <div class="container">
             <div class="card">
                 <div class="card-heade">
                     <div class="card-title">
                          <h2 class="text-center text-muted">Students Attendance System</h2>
                     </div>
                 </div>
                 <?php
                    if (!empty($_SESSION['message'])){
                        ?>
                        <div class="alert alert-warning">
                            <?php
                             echo $_SESSION['message'];
                            ?>
                        </div>
                 <?php
                        unset($_SESSION['message']);
                    }
                 ?>
                 <div class="card-body">
                     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                           <table class="table table-striped">
                               <thead>
                                   <tr>
                                       <th width="25%">Attendance</th>
                                       <th width="25%">Id</th>
                                       <th width="25%">Name</th>
                                       <th width="25%">E-Mail</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   <?php
                                     if ($result->rowCount() > 0){
                                       $i=1;
                                       while ($data = $result->fetch(PDO::FETCH_ASSOC)){
                                           ?>
                                           <tr>
                                               <td>
                                                   <input type="radio" name="atten[<?php echo $data['student_id']; ?>]" value="p">Present
                                                   <input type="radio" name="atten[<?php echo $data['student_id']; ?>]" value="a">Absent
                                               </td>
                                               <td><?php echo $data['student_id'];?></td>
                                               <td><?php echo $data['student_name'];?></td>
                                               <td><?php echo $data['student_email'];?></td>
                                           </tr>
                                   <?php
                                           $i++;
                                       }
                                     }
                                   ?>
                               </tbody>

                           </table>
                         <input type="submit" name="submit" class="btn btn-success" value="Save Attendance">
                     </form>


                 </div>
             </div>
       </div>
</body>
</html>