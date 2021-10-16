<?php
  require_once '../dbcont.php';
  $link = create_connection();
  session_start();
  $email = $_SESSION['users'];
  $newamount = $_POST['amount'];
  $goodid = $_POST['goods'];
  $time = date("Y-m-d H:i:s");

  $cartidsql = "SELECT cartsid FROM carts WHERE useremail = ?/*'".$email."'*/";
  $cartidresult = execute_sql($link, /*'shoppingcart', */$cartidsql);
  $cartidresult -> execute(array($email));
  $cartid = $cartidresult -> fetch(PDO::FETCH_ASSOC)['cartsid']/*mysqli_fetch_assoc($result)['cartsid']*/;

  $sql = "UPDATE cartinfo SET amount = ?/*'".$newamount."'*/ WHERE info_cartid = ?/*'".$cartid."'*/ AND info_goodid = ?/*'".$goodid."'*/";
  $result = execute_sql($link, /*'shoppingcart', */$sql);
  $result -> execute(array($newamount, $cartid, $goodid));

  $sql = "UPDATE carts SET updatetime = ?/*'".$time."'*/ WHERE cartsid = ?/*'".$cartid."'*/";
  execute_sql($link, /*'shoppingcart', */$sql) -> execute(array($time, $cartid));

  $pricesql = "SELECT a.prices * b.amount AS total FROM goods AS a, cartinfo AS b WHERE b.info_goodid = ?/*'".$goodid."'*/ AND b.info_cartid = ?/*'".$cartid."'*/ AND a.goodsid = ?/*'".$goodid."'*/";
  $priceresult = execute_sql($link, /*'shoppingcart', */$pricesql);
  $priceresult -> execute(array($goodid, $cartid, $goodid));
  $total = $priceresult -> fetch(PDO::FETCH_ASSOC)['total']/*mysqli_fetch_assoc($priceresult)['total']*/;
  $json = [
    'ok' => true,
    'price' => $total,
    'member' => true
  ];
  $response = json_encode($json, JSON_UNESCAPED_UNICODE);
  echo $response;
  die();
 ?>
