<?php
  require_once '../dbcont.php';
  session_start();
  $link = create_connection();
  $email = $_SESSION['users'];

  $cartidsql = "SELECT b.cartsid FROM cartinfo AS a, carts AS b WHERE b.useremail = ? AND b.cartsid = a.info_cartid";
  $cartidresult = execute_sql($link, $cartidsql);
  $cartidresult -> execute(array($email));
  $cartid = $cartidresult -> fetch(PDO::FETCH_ASSOC)['cartsid'];

  $sql = "DELETE FROM cartinfo WHERE info_cartid = ?/*'".$email."'*/";
  execute_sql($link, /*'shoppingcart', */$sql) -> execute(array($cartid));
 ?>
