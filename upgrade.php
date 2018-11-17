<?php
 include_once 'Database.php';
 if (isset($_GET['student_id']) && isset($_GET['date'])){
    $student_id = $_GET['student_id'];
    $date = $_GET['date'];
 }else{
     header("Location:viewDetailed.php");
     exit();
 }

$student_id = $_GET['student_id'];
$date = $_GET['date'];
 $result = $database->upgradeView('attendance_tbl',$student_id,$date);
$result->execute();

$datas =  $result->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['upgrade'])){
    $attendance = $_POST['atten'];
    foreach ($attendance as $key => $atten){
        $upgrade_attendance = $database->update_attendance('attendance_tbl',$atten,$student_id,$date);
    }
 
   if ($upgrade_attendance){
       header('Location:viewAttendance.php');
       exit();
   }




}
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
                    <form action="upgrade.php?student_id=<?php echo $student_id.'&&date='.$date?>" method="post">
                         <table class="table table-striped">
                             <thead>
                             <th width="25%">#</th>
                             <td width="25%">Date</td>
                               <th width="25%">Student id</th>
                                <th width="25%">Attendance</th>
                             </thead>
                             <tbody>
                                  <tr>
                                      <?php
                                         foreach ($datas as $data){
                                             ?>
                                             <td><?php echo $data['id'];?></td>
                                             <td><?php echo $data['date']; ?></td>
                                             <td><?php echo $data['student_id']; ?></td>
                                             <?php
                                             if ($data['attendance'] == 'p'){
                                                 ?>
                                                 <td>
                                                     <input type="radio" name="atten[<?php echo $data['student_id']?>]" value="p" checked>Present
                                                     <input type="radio" name="atten[<?php echo $data['student_id']?>]" value="a">Absent
                                                 </td>
                                                 <?php
                                             }else{
                                                 ?>
                                                 <td>
                                                     <input type="radio" name="atten[<?php echo $data['student_id']?>]" value="p">present
                                                     <input type="radio" name="atten[<?php echo $data['student_id']?>]" value="a" checked>absent
                                                 </td>
                                                 <?php
                                             }
                                             ?>
                                      <?php
                                         }
                                      ?>
                                  </tr>
                             </tbody>
                         </table>
                        <a href="viewAttendance.php"  class="btn btn-primary">Back</a>
                        <input type="submit" style="float: right" name="upgrade" value="Upgrade Attendance" class="btn btn-info">
                    </form>
                </div>
            </div>
      </div>
</body>
</html>