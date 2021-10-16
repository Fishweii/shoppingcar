<?php
  require_once '../dbcont.php';
  $link = create_connection();
  session_start();
  $email = $_SESSION['users'];
  $time = date("Y-m-d H:i:s");
  $sql = "SELECT a.goodsname, a.prices * b.amount AS total,a.goodsid, a.stock, b.amount, c.useremail, b.info_id FROM goods AS a, cartinfo AS b, carts AS c WHERE b.info_goodid = a.goodsid and b.info_cartid = c.cartsid AND c.useremail = ?/*'".$email."'*/";
  $result = execute_sql($link, /*'shoppingcart', */$sql);
  $result -> execute(array($email));

  if($result -> rowCount() != 0/*mysqli_num_rows($result) != 0*/){
    /*$array = [];
    while($row = mysqli_fetch_assoc($result)){
      array_push($array,[
        'goodsname' => $row['goodsname'],
        'prices' => $row['total'],
        'amount' => $row['amount'],
        'infoid' => $row['info_id'],
        'goodstock' => $row['stock'],
        'goodsid' => $row['goodsid']
      ]);
    }*/
    $row = $result -> fetchALL(PDO::FETCH_ASSOC);
    $json = [
      'ok' => true,
      'cartsinfo' => $row/*$array*/,
      'member' => true
    ];
    $response = json_encode($json, JSON_UNESCAPED_UNICODE);
    echo $response;
    die();

  }else{
    $json = [
      'ok' => true,
      'cartsinfo' => false,
      'member' => true
    ];
    $response = json_encode($json, JSON_UNESCAPED_UNICODE);
    echo $response;
    die();
  };

 ?>
