<?php
  require_once '../dbcont.php';
  $link = create_connection();
  $infoid = $_POST['infoid'];
  $sql = "DELETE FROM cartinfo WHERE info_id = '".$infoid."'";
  execute_sql($link, 'shoppingcart', $sql);

  session_start();
  $email = $_SESSION['users'];
  $time = date("Y-m-d H:i:s");
  $sql = "UPDATE carts SET updatetime = '".$time."' WHERE useremail = '".$email."'";
  execute_sql($link, 'shoppingcart', $sql);

  $sql = "SELECT a.info_id FROM cartinfo AS a, carts AS b WHERE b.useremail = '".$email."' AND b.cartsid = a.info_cartid";
  $result = execute_sql($link, 'shoppingcart', $sql);
  if(mysqli_num_rows($result) == 0){
    $json = [
      'ok' => true,
      'nogoods' => true,
      'member' => true
    ];
    $response = json_encode($json, JSON_UNESCAPED_UNICODE);
    echo $response;
  }
 ?>
