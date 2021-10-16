<?php
  require_once '../dbcont.php';
  $link = create_connection();
  session_start();
  $email = $_SESSION['users'];
  $time = date("Y-m-d H:i:s");
  $sql = "INSERT INTO carts(useremail, createtime, updatetime) VALUES(?, ?, ?/*'".$email."', '".$time."', '".$time."'*/)";

  $cartsql = "SELECT * FROM carts WHERE useremail = ?/*'".$email."'*/";   /*查詢使用者的購物車是否存在 */
  $cartresult = execute_sql($link, /*'shoppingcart', */$cartsql);
  $cartresult -> execute(array($email));
  

  $goodsid = $_POST['goodsid'];

  

  if($cartresult -> rowCount() != 0){   /*購物車存在 */
    $cartid = $cartresult -> fetch(PDO::FETCH_ASSOC)['cartsid']/*mysqli_fetch_assoc($result)['cartsid']*/;    /*找到購物車id */

    $infogoodsql = "SELECT * FROM cartinfo WHERE info_goodid = ?/*'".$goodsid."'*/ AND info_cartid = ?/*'".$cartid."'*/";   /*查詢購物車內是否有這項商品 */
    $infogoodresult = execute_sql($link, /*'shoppingcart', */$infogoodsql);
    $infogoodresult -> execute(array($goodsid, $cartid));

    if($infogoodresult -> rowCount() == 0){     /*此商品尚未在購物車裡 */
      $sql = "INSERT INTO cartinfo(info_cartid, info_goodid, amount) VALUES(?/*'".$cartid."'*/, ?/*'".$goodsid."'*/, ?/*1*/)";      /*新增商品資訊 */
      execute_sql($link, /*'shoppingcart', */$sql) -> execute(array($cartid, $goodsid, 1));    
      $sql = "UPDATE carts SET updatetime = ?/*'".$time."'*/ WHERE cartsid = ?/*'".$cartid."'*/";
      execute_sql($link, /*'shoppingcart', */$sql) -> execute(array($time, $cartid));
    }else{    /*此商品存在購物車 */
      $stocksval = "SELECT stock FROM goods WHERE goodsid = ?/*'".$goodsid."'*/";   /*獲得商品庫存 */
      $stockresult = execute_sql($link, /*'shoppingcart', */$stocksval);
      $stockresult -> execute(array($goodsid));
      $stock = $stockresult -> fetch(PDO::FETCH_ASSOC)['stock'];

      $amountsql = "SELECT amount FROM cartinfo WHERE info_goodid = ?/*'".$goodsid."'*/ AND info_cartid = ?/*'".$cartid."'*/";    /*獲得購物車裡的商品數量 */
      $amountresult = execute_sql($link, /*'shoppingcart', */$amountsql);
      $amountresult -> execute(array($goodsid, $cartid));
      $amount = $amountresult -> fetch(PDO::FETCH_ASSOC)['amount'];

      if($stock < $amount + 1/*mysqli_fetch_assoc($stockresult)['stock'] < mysqli_fetch_assoc($amountresult)['amount'] + 1*/){
        echo "庫存不足";
      }else{
        $sql = "UPDATE cartinfo SET amount = amount + 1 WHERE info_goodid = ?/*'".$goodsid."'*/ AND info_cartid = ?/*'".$cartid."'*/";
        execute_sql($link, /*'shoppingcart', */$sql) -> execute(array($goodsid, $cartid));
        $sql = "UPDATE carts SET updatetime = ?/*'".$time."'*/ WHERE cartsid = ?/*'".$cartid."'*/";
        execute_sql($link, /*'shoppingcart', */$sql) -> execute(array($time, $cartid));
      }
    }
  }else{      /*新增購物車 */
    execute_sql($link, /*'shoppingcart',*/ $sql) -> execute($email, $time, $time);

    $sql = "SELECT * FROM carts WHERE useremail = ?/*'".$email."'*/";
    $result = execute_sql($link, /*'shoppingcart', */$valsql);
    $result -> execute(array($email));
    /*$cartid = mysqli_fetch_assoc($result)['cartsid'];*/
    $result -> fetch(PDO::FETCH_ASSOC)['cartsid'];

    $sql = "INSERT INTO cartinfo(info_cartid, info_goodid, amount) VALUES(?/*'".$cartid."'*/, ?/*'".$goodsid."'*/, ?/*1*/)";
    execute_sql($link, /*'shoppingcart', */$sql) -> execute(array($cartid, $goodsid, 1));
  }
  
 ?>
