<?php
  $id = $_POST['id'];
  include 'db.php';
  try {
    $sql = "SELECT * FROM users WHERE id=$id";
    $query = $conn->prepare($sql);
    $query ->execute();
  } catch (\Exception $e) {
    echo "ไม่สามารถดึงข้อมูลได้: " .$e->getMessage();
  }
  $row=$query -> fetch(PDO::FETCH_OBJ);
  echo json_encode($row);
 ?>
