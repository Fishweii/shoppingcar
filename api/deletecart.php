<?php
  require_once '../dbcont.php';
  session_start();
  $link = create_connection();
  $email = $_SESSION['users'];
  $sql = "DELETE FROM carts WHERE useremail = '".$email."'";
  execute_sql($link, 'shoppingcart', $sql);
 ?>
