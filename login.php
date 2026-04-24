<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  

<?php
session_start();
include("db_connection.php");
$nm=$_GET["nm"];
$em=$_GET["em"];
$q=mysql_query("select * from recipe_login;");
$f=0;
while($rs=mysql_fetch_array($q)){
if($rs[0]==$nm && $rs[1]==$em)
{$f=1;
  $_SESSION['email']=$em;
  header("Location:home.php");
  
}
}
if($f==0){
 echo("<script>alert('Invalid username or password');</script>");
 echo '<script>window.location.href="login.html";</script>';
}


?></body>
</html>


