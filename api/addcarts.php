<?php
  require_once '../dbcont.php';
  $link = create_connection();
  session_start();
  $email = $_SESSION['users'];
  $time = date("Y-m-d H:i:s");
  $sql = "INSERT INTO carts(useremail, createtime, updatetime) VALUES('".$email."', '".$time."', '".$time."')";
  $valsql = "SELECT * FROM carts WHERE useremail = '".$email."'";
  $result = execute_sql($link, 'shoppingcart', $valsql);
  $goodsid = $_POST['goodsid'];
  $stocksval = "SELECT stock FROM goods WHERE goodsid = '".$goodsid."'";
  $stockresult = execute_sql($link, 'shoppingcart', $stocksval);
  $cartid = mysqli_fetch_assoc($result)['cartsid'];
  $amountsql = "SELECT amount FROM cartinfo WHERE info_goodid = '".$goodsid."' AND info_cartid = '".$cartid."'";
  $amountresult = execute_sql($link, 'shoppingcart', $amountsql);
  if(mysqli_fetch_assoc($stockresult)['stock'] < mysqli_fetch_assoc($amountresult)['amount'] + 1){
    echo "庫存不足";
  }else{
    if(mysqli_num_rows($result) != 0){
      $valsql = "SELECT * FROM cartinfo WHERE info_goodid = '".$goodsid."' AND info_cartid = '".$cartid."'";
      $result = execute_sql($link, 'shoppingcart', $valsql);
      if(mysqli_num_rows($result) != 0){
        $sql = "UPDATE cartinfo SET amount = amount + 1 WHERE info_goodid = '".$goodsid."' AND info_cartid = '".$cartid."'";
        execute_sql($link, 'shoppingcart', $sql);
        $sql = "UPDATE carts SET updatetime = '".$time."' WHERE cartsid = '".$cartid."'";
        execute_sql($link, 'shoppingcart', $sql);
      }else{
        $sql = "INSERT INTO cartinfo(info_cartid, info_goodid, amount) VALUES('".$cartid."', '".$goodsid."', 1)";
        execute_sql($link, 'shoppingcart', $sql);
        $sql = "UPDATE carts SET updatetime = '".$time."' WHERE cartsid = '".$cartid."'";
        execute_sql($link, 'shoppingcart', $sql);
      }

    }else{
      execute_sql($link, 'shoppingcart', $sql);
      $valsql = "SELECT * FROM carts WHERE useremail = '".$email."'";
      $result = execute_sql($link, 'shoppingcart', $valsql);
      $cartid = mysqli_fetch_assoc($result)['cartsid'];
      $sql = "INSERT INTO cartinfo(info_cartid, info_goodid, amount) VALUES('".$cartid."', '".$goodsid."', 1)";
      execute_sql($link, 'shoppingcart', $sql);
    }
  }

 ?>
