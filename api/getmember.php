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
  $sql = "SELECT * FROM members where email = '".$_SESSION["users"]."'";
  $result = execute_sql($link, 'shoppingcart', $sql);
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
      $array = [];
      $row = mysqli_fetch_assoc($result);
      array_push($array,[
        'email' => $row['email'],
        'pwd' => $row['password'],
        'name' => $row['username'],
        'phone' => $row['phone']
      ]);
    }
      $json = [
        'ok' => true,
        'memberinfo' => $array,
        'member' => true
      ];
      $response = json_encode($json, JSON_UNESCAPED_UNICODE);
      echo $response;
      die();
    }
 ?>
