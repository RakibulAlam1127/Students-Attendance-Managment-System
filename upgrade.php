<?php
 include_once 'Database.php';
 if (isset($_GET['student_id']) && isset($_GET['date'])){
    $student_id = $_GET['student_id'];
    $date = $_GET['date'];
 }else{
     header('Location:viewDetailed.php');
     exit();
 }
$data = [
    'student_id' =>$student_id,
    'date' =>$date
];
 $result = $database->selectData('attendance_tbl','*',$data);

$result->execute();
$rows = $result->rowCount();
var_dump($rows);
die();

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
    <title>Upgrade</title>
</head>
<body>
      <div class="container">
            <div class="card">
                <div class="card-header">
                      <div class="card-title">
                           <h3>Upgrade Attendance</h3>
                      </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                         <table class="table table-striped">
                             <thead>
                             <th width="30%">#</th>
                               <th width="30%">Student id</th>
                                <th width="30%">Attendance</th>
                             </thead>
                             <tbody>
                                 <tr>
                                    <td></td>
                                     <td></td>
                                     <td>

                                         <input type="radio"  name="upgrade[<?php ?>]">present
                                         <input type="radio"  name="upgrade[<?php ?>]">absent
                                     </td>
                                 </tr>
                             </tbody>
                         </table>
                        <input type="submit" name="upgrade" value="Upgrade Attendance" class="btn btn-primary">
                    </form>
                </div>
            </div>
      </div>
</body>
</html>