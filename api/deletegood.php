<?php
  require_once '../dbcont.php';
  $link = create_connection();
  $infoid = $_POST['infoid'];

  $sql = "DELETE FROM cartinfo WHERE info_id = ?/*'".$infoid."'*/";
  execute_sql($link, /*'shoppingcart', */$sql) -> execute(array($infoid));

  session_start();
  $email = $_SESSION['users'];
  $time = date("Y-m-d H:i:s");

  $sql = "UPDATE carts SET updatetime = ?/*'".$time."'*/ WHERE useremail = ?/*'".$email."'*/";
  execute_sql($link, /*'shoppingcart', */$sql) -> execute(array($time, $email));

 ?>
