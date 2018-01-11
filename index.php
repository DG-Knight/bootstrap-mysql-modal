<?php
include 'db.php';
try {
  $sql = "SELECT * FROM users";
  $query = $conn->prepare($sql);
  $query ->execute();
} catch (\Exception $e) {
  echo "ไม่สามารถดึงข้อมูลได้: " .$e->getMessage();
}
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
    <title>PHP MySQL AJAX Bootstrap Modal </title>
  </head>
  <body>
    <div class="container" style="width:700px;">
      <h2 align="center">Hello PHPMySQL AJAX Bootstrap Modal</h3>
      <br><br>
      <div align="right">
        <button type="button" name="add" id="add" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add</button>
      </div>
      <br>
      <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
              <th witth="5">#</th>
              <th width="27.5%">Firstname</th>
              <th width="27.5%">Lastname</th>
              <th width="10%">View</th>
              <th width="10%">Edit</th>
              <th width="10%">Delete</th>
            </tr>
          <tbody>
            <?php
            if ($query->rowCount()>0) {
              $i = 1;
              while ($data = $query -> fetch(PDO::FETCH_OBJ)) {
            ?>
            <tr>
              <th><?=$i++;?></th>
              <th><?=$data->first_name;?></th>
              <th><?=$data->last_name;?></th>
              <th><input type="button" name="view" value="View" class="btn btn-info view_data" id="<?=$data->id;?>" /></th>
              <th><input type="button" name="edit" value="Edit" class="btn btn-primary update_data" id="<?=$data->id;?>" /></th>
              <th><input type="button" name="delete" value="Delete" class="btn btn-danger delete_data" id="<?=$data->id;?>" /></th>
            </tr>
            <?php }} ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php include "viewModal.php";?>
    <?php include "insertModal.php";?>
    <script type="text/javascript" src="bootstrap/js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
  </body>
  <script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
  <script>
    $(document).ready(function(){
      //ถ้ามีการกดปุ่ม add ให้ทำการเซ็ตค่าใน textbox เป็นค่าว่าง
      $('#add').click(function(){
        $('#fname').val("");//textbox id fname เป็นค่าว่าง
        $('#lname').val("");//textbox id lname เป็นค่าว่าง
        $('#email').val("");//textbox id email เป็นค่าว่าง
      });
      //INSERT
      $('#insert-form').on('submit',function(e){ //อ้างอิงถึง id ที่ชื่อ insert-form mี่อยู่ใน insertModal และเมื่อมีการกด submit ให้ทำ? /*ดูบรรทัดถัดไป*/
        e.preventDefault();//เวลาที่ทำการ debug ดูข้อมูลได้เลยไม่ต้องรีเฟสหน้า ใช้เพื่อดูการไหลของข้อมูลระหว่าง insert-form ไปยังไฟล์ insert.php
        $.ajax({ //เรียกใช้ ajax
          url:"insert.php", //ส่งข้อมูลไปที่ insert.php
          method:"post", //ด้วย method post
          data:$('#insert-form').serialize(),//มัดข้อมูลร่วมกันแล้วส่งข้อมูลไปเป็นก้อนในรูปแบบ string
          beforeSend:function(){ //ก่อนที่จะส่งข้อมูล
            $('#insert').val("Insert...");//ให้ทำการเปลี่ยนข้อความบนปุ่มเป็น Insert...
          },
          success:function(data){// หากส้งข้อมูลสำเร็จ
            $('#insert-form')[0].reset()//ให้รีเซ็ตข้อมูลที่อยู่ใน form ทั้งหมด
            $('#addModal').modal('hide');//ปิด Modal
            location.reload();//โหลดหน้าเว็บใหม่อีกครั้ง
          }
        });
      });
      //update
      $('.update_data').click(function(){//เมื่อมีการกดปุ่ม view_data
        var uid=$(this).attr("id");//รับค่า id จากปุ่มวิวมาใส่ไว้ใน uid
        $.ajax({
          url:"fetch.php",
          method:"post",
          data:{id:uid},
          dataType:"json",
          success:function(data){
            $('#id').val(data.id);
            $('#fname').val(data.first_name);
            $('#lname').val(data.last_name);
            $('#email').val(data.email);
            $('#insert').val("Update");//เปลี่ยนข้อมความในปุ่ม insert เป็น Update
            $('#addModal').modal('show');
          }
        });
      });
      //delete
      $('.delete_data').click(function(){//ตรวจสอบคลาส delete_data เมื่อมีการกดปุ่ม
        var uid=$(this).attr("id");//รับค่า id จากปุ่มdeleteมาใส่ไว้ใน uid
        //var status=confirm("Are you want delete ?");
        swal({title: 'Are you sure?',
              text: "You want be delete this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                  if (result.value) {//เช็กค่าว่าเป็น T|F
                      console.log(result.value);//ปริ้นค้าออกทาง console log
                      $.ajax({  url:"delete.php", //ส่งข้อมูลไปทีไฟล์ delete.php
                                method:"post", //ด้วย method post
                                data:{id:uid},//ส่งข้อมูลไปในรูปแบบ JSON
                                success:function(data){ // หากส่งข้อมูลสำเร็จ
                                  console.log(data);
                                  swal(
                                    'Deleted!',
                                    'Your user has been deleted.',
                                    'success'
                                  ).then((result)=>{
                                    if (result.value) {
                                      location.reload();//โหลดหน้าเว็บใหม่อีกครั้ง
                                    }
                                  });
                                }
                              });
                  }
                });
      });
      //View
      $('.view_data').click(function(){//เมื่อมีการกดปุ่ม view_data
        var uid=$(this).attr("id");//รับค่า id จากปุ่มวิวมาใส่ไว้ใน uid
        $.ajax({
          url:"select.php", //ส่งข้อมูลไปทีไฟล์ select.php
          method:"post", //ด้วย method post
          data:{id:uid},//ส่งข้อมูลไปในรูปแบบ JSON
          success:function(data){ // หากส้งข้อมูลสำเร็จ
            $('#detail').html(data);//นำข้อมูลไปแสดงที่ Modal body ตรง id detail ในไฟล์ viewModal.php
            $('#dataModal').modal('show');//เรียก Modal มาแสดง
          }
        });
      });
    });
  </script>
</html>
