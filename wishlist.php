<?php
session_start();
include("db_connection.php");
$f=$_POST['f'];
if($f==1){
    if (isset($_POST['name']) && isset($_SESSION['email'])) {
    $name = $_POST['name'];
    $email = $_SESSION['email'];

    $result = mysql_query("SELECT uid FROM recipe_login WHERE email = '$email'");
    if ($row = mysql_fetch_assoc($result)) {
        $uid = $row['uid'];
        mysql_query("INSERT INTO wishlist (name, uid) VALUES ('$name', $uid)");
    }
    }
}
else
{
     if (isset($_POST['name']) && isset($_SESSION['email'])) {
    $name = $_POST['name'];
    $email = $_SESSION['email'];

    $result = mysql_query("SELECT uid FROM recipe_login WHERE email = '$email'");
    if ($row = mysql_fetch_assoc($result)) {
        $uid = $row['uid'];
        mysql_query("DELETE from wishlist where uid = $uid and name = '$name'");
    }
    }
}
?>
