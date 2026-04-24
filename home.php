<?php
session_start();
include("db_connection.php");
if(isset($_SESSION['email']))
{
$uid=mysql_query("select uid from recipe_login where email='".$_SESSION['email']."'");
$uid1=mysql_fetch_array($uid);  
$_SESSION['uid']=$uid1['uid'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
#nav .forte-title {
      font-size: 30px;
      color: rgba(78, 79, 59, 0.86);
      font-family: 'Forte', cursive;
      padding-right: 100px;
    }
    #nav input[type="button"], #nav button {
      margin-right: 15px;
    }
    #wishlist img,
    #profile img {
      width: 30px;
      height: 30px;
    }
    #nav {
      display: flex;
      align-items: center;
      /*justify-content: space-between;*/
      flex-wrap: wrap;
      padding: 10px 20px;
      background-color: rgba(212, 212, 208, 0.86);
    }

 
#recipe{
    height:100px;
    width:100px;
}

#cards{
    padding:50px;
    background-color: rgba(232, 233, 185, 0.86);
    height:250px;
    width:250px;
    border:rgba(78, 79, 59, 0.86) solid 2px;
    border-radius:40px;
}

#cards:hover{
background-color:rgba(248, 248, 227, 0.86);
filter:opacity(0.9);
}

nav{
    padding-bottom:20px;
}

#outer{
    padding:20px;
    display:grid;
    grid-template-columns: repeat(5, 1fr);

    gap:10px;
    
}

#buttons{
      padding-right: 200px;
    }

</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function()
{
    $("#r").click(function(){
 $("#Random").replaceWith("<div><input type='text' name='sname'id='sname' placeholder='What do you want to eat Today?'><input class='btn btn-outline-secondary' type='button' id='s' value='search' onclick='Search();' style='padding-right:5px;'></div>")
 $(".forte-title").css("padding-right", "0");

});

   $("#m").click(function()
  {
    window.location.href= 'manual_input.php';

  });
    
  $("#a").click(function()
  {
    window.location.href= 'add_your_own.html';

  });

  
});
   
function Search(){

  var x;
var sname=document.getElementById("sname").value;
if(window.XMLHttpRequest){
x=new XMLHttpRequest();
}
else{
x=new ActiveXObject("Microsoft.XMLHTTP");
}
x.onreadystatechange=function(){
if(x.readyState==4 && x.status==200){

document.getElementById("outer").innerHTML=x.responseText;
document.getElementById("outer").style.display = "flex";
}
}
document.getElementById("outer").style.display = "none";
x.open("get","Searched.php?sname="+sname,true);
x.send();
}

function get_recipe(temp) {
  window.location.href = "details.php?temp=" + encodeURIComponent(temp);
}

//js nav functions

function wish()
{
  window.location.href='user_wishlist.php';
}

function profile(){
  window.location.href='user_details.php';
}
 
function logout()
{

  window.location.href="logout.php";
 
}


</script>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid" id="nav">
  <div><img style="height:60px; width:60px; border-radius:50%;" src="logos.jpg"><span class="forte-title"><b> Cooking the Book</b></span></div>
   

    <!-- Left Side Buttons -->
    <div class="d-flex align-items-center flex-wrap" id="buttons">
      <div id="Random">
        <input class="btn btn-outline-secondary" type="button" id="r" value="Randomize">
      </div>
      <div id="manual">
        <input class="btn btn-outline-secondary" id='m' type="button" value="Manual Input">
      </div>
      <div id="Add">
        <input class="btn btn-outline-secondary" type="button" id="a" value="Add Your Own">
      </div>
    </div>

    <!-- Right Side Icons and Logout -->
    <div class="d-flex align-items-center flex-wrap">
      <div id="wishlist">
        <button style="border:black solid 2px;" class="btn btn-light" onclick="wish()">
          <img src="heart.png" alt="Wishlist">
        </button>
      </div>
      <div id="profile">
        <button style="border:black solid 2px;" class="btn btn-light" onclick="profile()">
          <img src="profile.jpg" alt="Profile">
        </button>
      </div>
      <div id="logout">
        <button class="btn btn-danger" onclick="logout()">Log Out →</button>
      </div>
    </div>

  </div>
</nav>
<div id="outer">

<?php

$q=mysql_query("select * from recipes;");

while($rs=mysql_fetch_array($q)){ ?>
<div id="cards">
<div><img id="recipe" src="<?php echo($rs[0]); ?> "></div>
<div><?php echo($rs[1]);?>
</div>
<div><button onclick="get_recipe('<?php echo($rs[1]); ?>')">Get Recipe</button></div>
</div>
<?php }}
else{
  echo "<script>alert('please Login first');</script>";
  echo "<script>window.location.href='login.html'</script>";
}
?>
</div>


</body>
</html>