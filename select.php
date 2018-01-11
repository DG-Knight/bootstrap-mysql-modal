<?php
$id = $_POST['id'];
//echo $id;
include 'db.php';
$opt = '';
try {
  $sql = "SELECT * FROM users WHERE id=$id";
  $query = $conn->prepare($sql);
  $query ->execute();
} catch (\Exception $e) {
  echo "ไม่สามารถดึงข้อมูลได้: " .$e->getMessage();
}

$opt.='<div class="table-responsive">
<table class="table table-bordered">';
while ($row=$query -> fetch(PDO::FETCH_OBJ)) {
      $opt.='<tr>
              <td><lable>ID</lable></td>
              <td>'.$row->id.'</td>
            </tr>';
      $opt.='<tr>
              <td><lable>Firstname</lable></td>
              <td>'.$row->first_name.'</td>
            </tr>';
      $opt.='<tr>
              <td><lable>Lastname</lable></td>
              <td>'.$row->last_name.'</td>
             <tr>';
      $opt.='<tr>
              <td><lable>Email</lable></td>
              <td>'.$row->email.'</td>
             <tr>';
}
    $opt.='</table></div>';
echo $opt;
 ?>
