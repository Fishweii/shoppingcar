<?php
  $email = $_POST['email'];
  $pwd = $_POST['pwd'];
  require_once 'dbcont.php';
  $link = create_connection();
  $sql = "SELECT * FROM members WHERE email = ?/*'".$email."'*/ AND password = ?/*'".$pwd."'*/";
  $result = execute_sql($link, /*'shoppingcart', */$sql);
  $result -> execute(array($email, $pwd));

  if($result -> rowCount() == 1/*mysqli_num_rows($result) != 0*/){
    session_start();
    $_SESSION['users'] = $_POST['email'];
    echo "<script>alert('登入成功');location.href='goodslist.html';</script>;";
  }else{
    echo "<script>alert('帳號或密碼錯誤');location.href='index.html';</script>;";
  }
 ?>
