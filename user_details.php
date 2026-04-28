<?php
session_start();
include("db_connection.php");
if(isset($_SESSION['email'])){    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Recipe Book</title>

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
  justify-content: space-between;
  flex-wrap: wrap;
  padding: 10px 20px;
  background-color: rgba(212, 212, 208, 0.86);
}

#recipe {
  height: 100px;
  width: 100px;
  border-radius: 10px;
  object-fit: cover;
}

#cards {
  padding: 50px;
  background-color: rgba(232, 233, 185, 0.86);
  height: 250px;
  width: 250px;
  border: rgba(78, 79, 59, 0.86) solid 2px;
  border-radius: 40px;
  text-align: center;
}

#cards:hover {
  background-color: rgba(248, 248, 227, 0.86);
  filter: opacity(0.9);
  transition: all 0.3s ease-in-out;
}

#outer {
  padding: 20px 40px;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 20px;
  justify-items: center;
  background-color:#f4f4edff;
  margin-left:50px;
  margin-right:50px;
  border-radius:15px;
box-shadow: 0 12px 12px rgba(0,0,0,0.1);
border:rgba(78, 79, 59, 0.86) solid 1px;
}

#buttons {
  padding-right: 200px;
}

.user-info {
  max-width: 1000px;
  margin: 30px auto 10px;
  padding: 20px;
  background-color: #f4f4edff;
  border-radius: 15px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  text-align: center;
  border:rgba(78, 79, 59, 0.86) solid 1px;
}

.user-info h2 {
  margin-bottom: 10px;
  color: #4e4f3b;
}

.user-info p {
  margin: 5px 0;
  font-size: 27px;
  color: #555;
}

.user-info i {
  margin-right: 10px;
  color: #6c757d;
}

.recipe-title {
  text-align: center;
  margin-top: 50px;
  margin-bottom:10px;
  font-size: 35px;
  font-weight: bold;
  font-family: 'Georgia', serif;
  color: #515241ff;
  background-color:#f4f4edff;
  margin-left:60px;
  margin-right:60px;
border-radius: 25px;
border:rgba(78, 79, 59, 0.86) solid 1px;
}

</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $("#r").click(function(){
        window.location.href = 'home.php';
    });

    $("#m").click(function(){
        window.location.href = 'manual_input.php';
    });

    $("#a").click(function(){
        window.location.href = 'add_your_own.html';
    });
});

function Search(){
    var x;
    var sname = document.getElementById("sname").value;
    if(window.XMLHttpRequest){
        x = new XMLHttpRequest();
    } else {
        x = new ActiveXObject("Microsoft.XMLHTTP");
    }
    x.onreadystatechange = function(){
        if(x.readyState == 4 && x.status == 200){
            document.getElementById("outer").innerHTML = x.responseText;
            document.getElementById("outer").style.display = "flex";
        }
    }
    document.getElementById("outer").style.display = "none";
    x.open("get", "Searched.php?sname=" + sname, true);
    x.send();
}

function get_recipe(temp) {
    window.location.href = "details.php?temp=" + encodeURIComponent(temp);
}

function wish() {
    window.location.href = 'user_wishlist.php';
}

function profile() {
    window.location.href = 'user_details.php';
}
</script>
</head>

<body>
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid" id="nav">
  <div><img style="height:60px; width:60px; border-radius:50%;" src="logos.jpg"><span class="forte-title"><b> Cooking the Book</b></span></div>

    <div class="d-flex align-items-center flex-wrap" id="buttons">
      <input class="btn btn-outline-secondary" type="button" id="r" value="Randomize">
      <input class="btn btn-outline-secondary" id="m" type="button" value="Manual Input">
      <input class="btn btn-outline-secondary" type="button" id="a" value="Add Your Own">
    </div>

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
        <button class="btn btn-danger">Log Out →</button>
      </div>
    </div>
  </div>
</nav> 

<?php
$userq = mysql_query("select * from recipe_login where uid=".$_SESSION['uid']);
$userrs = mysql_fetch_array($userq);
$recipe_addedq = mysql_query("select * from recipes where name in(select name from detailed_recipe where uid=" . $_SESSION['uid'] . ")");
?>

<!-- USER INFO CARD -->
<div class="user-info">
    <h2><i class="fas fa-user"></i><?php echo htmlspecialchars($userrs['username']); ?></h2>
    <p><i class="fas fa-envelope"></i><i><u><?php echo htmlspecialchars($userrs['email']); ?></u></i></p>
</div>

<!-- SECTION TITLE -->
<div class="recipe-title"><u>Recipes Added By You</u></div>

<!-- RECIPE CARDS -->
<div id="outer">
<?php while($rs = mysql_fetch_array($recipe_addedq)){ ?>
  <div id="cards">
    <div><img id="recipe" src="<?php echo($rs['image']); ?>"></div>
    <div><strong><?php echo($rs['name']); ?></strong></div>
    <div><button onclick="get_recipe('<?php echo($rs['name']); ?>')">Get Recipe</button></div>
  </div>
<?php } ?>
</div>

<?php 
} else {
    echo "<script>alert('please Login first');</script>";
    echo "<script>window.location.href='login.html'</script>";
}
?>
</body>
</html>
