<?php
  #include the Essential file;
 include_once 'Database.php';
  $result = $database->fetchDate('attendance_tbl','date',[]);
  $result->execute();







?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View Attendance Page</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
         <div class="container">
                <div class="card">
                      <div class="card-header">
                            <div class="card-title">
                                 <h2 class="text-center text-danger">View Attendance</h2>
                            </div>
                      </div>

                    <div class="card-body">
                             <table class="table">
                                   <thead>
                                      <tr>
                                          <th width="25%">#</th>
                                          <th width="25%">Date</th>
                                          <th width="25%">Total Present</th>
                                          <th width="25%">Action</th>
                                      </tr>
                                   </thead>
                                 <tbody>


                                         <?php
                                            $i = 1;
                                            while($data = $result->fetch(PDO::FETCH_ASSOC)){
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $data['date']; ?></td>

                                                    <?php
                                                    $count = 0;
                                                    $date = $data['date'];
                                                    $student_count = $database->getDataById('attendance_tbl',$date);
                                                    $student_count->execute();
                                                    $j=1;
                                                    while($all_students = $student_count->fetch(PDO::FETCH_ASSOC)){
                                                        if ($all_students['attendance'] =='p'){
                                                            $count +=1;
                                                        }
                                                        $j++;
                                                    }

                                                    ?>
                                                    <td>
                                                        <?php echo $count; ?>
                                                    </td>

                                                    <td>
                                                        <a href="viewDetailed.php?date=<?php echo $data['date']; ?>"
                                                           class="btn btn-info">View Attendance</a>
                                                    </td>
                                                </tr>

                                       <?php
                                             $i++;
                                            }

                                         ?>


                                 </tbody>
                             </table>
                    </div>
                </div>
         </div>
</body>
</html>
