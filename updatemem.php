<?php
    require_once 'dbcont.php';
    session_start();
    $link = create_connection();
    $sql = "UPDATE members SET password = ?/*'".$_POST['pwd']."'*/, username = ?/*'".$_POST['username']."'*/, phone = ?/*'".$_POST['phone']."'*/ WHERE email = ?/*'".$_SESSION['users']."'*/";
    $result = execute_sql($link, /*'shoppingcart', */$sql);
    $result -> execute(array($_POST['pwd'], $_POST['username'], $_POST['phone'], $_SESSION['users']));
    /*mysqli_close($link);*/
    echo "<script>alert('會員資料更新成功');location.href='member.html';</script>;";
?>
