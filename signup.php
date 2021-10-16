<?php
  require_once 'dbcont.php';
  $link = create_connection();
  $valsql = "SELECT * FROM members WHERE email = ?/*'".$_POST['email']."'*/";
  $valresult = execute_sql($link, /*'shoppingcart', */$valsql);
  $valresult -> execute(array($_POST['email']));

  if($valresult -> rowCount() == 1/*mysqli_num_rows($valresult) != 0*/){
    echo "此帳號已存在";
  }else {
    $sql = "INSERT INTO members VALUES(?, ?, ?, ?/*'".$_POST['email']."', '".$_POST['pwd']."', '".$_POST['username']."', '".$_POST['phone']."'*/)";
    $result = execute_sql($link, /*'shoppingcart',*/ $sql);
    $result -> execute(array($_POST['email'], $_POST['pwd'], $_POST['username'], $_POST['phone']));
    echo "<script>alert('註冊成功請重新登入');location.href='index.html';</script>;";
  }
 ?>
