<?php
  require_once '../dbcont.php';
  $link = create_connection();
  session_start();
  if(!isset($_SESSION['users'])){
    $json = [
      'ok' => false,
      'member' => false,
      'message' => 'Please login first.'
    ];
    $response = json_encode($json);
    echo $response;
    die();
  }else{
    $sql = "SELECT * FROM goods";
    $result = execute_sql($link, /*'shoppingcart', */$sql);
    $result -> execute();
    if(!$result){
      $json = [
        'ok' => false,
        'message' => 'no any result',
        'member' => true
      ];
      $response = json_encode($json);
      echo $response;
      die();
      }else{
        if($result -> rowCount() > 0/*mysqli_num_rows($result) > 0*/){
          $row = $result -> fetchALL(PDO::FETCH_ASSOC);   
          /*$array = [];
          while($row = mysqli_fetch_assoc($result)){
            array_push($array,[
              'id' => $row['goodsid'],
              'name' => $row['goodsname'],
              'stock' => $row['stock'],
              'prices' => $row['prices']
            ]);
          }*/

          $json = [
          'ok' => true,
          'goodsinfo' => $row/*$array*/,
          'member' => true
          ];
          $response = json_encode($json, JSON_UNESCAPED_UNICODE);
          echo $response;
          die();
      }
    }
  }
 ?>
