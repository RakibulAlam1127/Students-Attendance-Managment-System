<?php
  class Database{
    public $connection;
    private $stmt;

    public function __construct($dsn,$user,$password){
        $this->connection = new PDO($dsn,$user,$password);
    }

    public function connection()
    {
       return $this->connection;
    }

      /**
       * @param $table
       * @param string $columns
       * @param array $data
       * @return bool|PDOStatement
       */
      public function selectData($table, $columns = '*', array $data = [])
      {
           $query = 'SELECT '.$columns.' FROM '.$table;

           if (!empty($data)){
               $string = [];
               foreach ($data as $key => $value){
                   /** @var TYPE_NAME $string */
                   $string[] = "`{$key}` = :{$key}";
               }
               $query .= /** @lang text */
                   ' WHERE '.implode(',',$string);
           }

           $this->stmt = $this->connection->prepare($query);
           foreach ($data as $key => $value){
                   $this->stmt->bindParam(':'.$key,$value);
           }

           return $this->stmt;

      }


      /**
       * @param $table
       * @param $data
       * @return bool
       */
      public function insertData($table, $data)
      {
          $placeholder = [];
          foreach ($data as $key => $value) {
              $placeholder[] = ':' . $key;
          }
          /** @var TYPE_NAME $query */
          $query = 'INSERT INTO '.$table.' ('.implode(',',array_keys($data)).') VALUES ('.implode(',',$placeholder).')';
              $this->stmt = $this->connection->prepare($query);

              foreach ($data as $placeholder => $value){
                  /** @var TYPE_NAME $this */
                  $this->stmt->bindValue(':'.$placeholder,$value);
              }


              return $this->stmt->execute();

      }


      /**
       * @param $table
       * @param string $columns
       * @param array $data
       * @return bool|PDOStatement
       */
      public function fetchDate($table, $columns='*', array $data = [])
      {
          /** @var TYPE_NAME $query */
          $query = 'SELECT DISTINCT '.$columns.' FROM '.$table;
          if (!empty($data)){
              $string = [];
              foreach ($data as $key => $value) {
                  $string[] = "{`$key`} = :{$key}";
              }
              /** @var TYPE_NAME $query */
              $query .= 'WHERE '.implode(',',$string);
          }

          /** @var TYPE_NAME $this */
          $this->stmt = $this->connection->prepare($query);
          foreach ($data as $placeholder => $value){
              $this->stmt->bindValue(':'.$placeholder,$value);
          }
          return $this->stmt;
      }

      public function getDataById($table,$date)
      {
          $query = 'SELECT * FROM '.$table.' WHERE date = :date';
          $this->stmt = $this->connection->prepare($query);
          $this->stmt->bindValue(':date',$date);
          return $this->stmt;

      }

      /**
       * @param $table
       * @param $student_id
       * @param $date
       */
      public function upgradeView($table, $student_id, $date)
      {
          $query = 'SELECT * FROM '.$table.' WHERE student_id = :student_id AND date = :date';
          $this->stmt = $this->connection->prepare($query);
          $this->stmt->bindValue(':student_id',$student_id);
          $this->stmt->bindValue(':date',$date);
          return $this->stmt;
      }

      /**
       * @param $table
       * @param $attendance
       * @param $student_id
       * @param $date
       * @return bool|PDOStatement
       */
      public function upgradeAttendance($table, $attendance, $student_id, $date)
      {

          $sql = 'UPDATE '.$table.' SET attendance = :attendance WHERE student_id ='.$student_id.' AND date = '.$date;
          $this->stmt =$this->connection->prepare($sql);
          $this->stmt->bindParam(':attendance',$attendance);
          return $this->stmt;

      }




  }

  define('DSN','mysql:dbname=students_attendance_system;hostname=localhost');
  define('USER_DB','root');
  define('PASSWORD_DB','');

  $database = new Database(DSN,USER_DB,PASSWORD_DB);
//  $currentDate = date('Y-m-d');
//  $student_id = '161-15-864';
//  $database->upgradeAttendance('attendance_tbl','p','161-154-867',$currentDate);
