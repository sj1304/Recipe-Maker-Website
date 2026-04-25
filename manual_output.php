<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
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
  padding-top:60px;
    padding-left:500px;
    padding-right:500px;
    padding-bottom:60px;
    margin:40px;
    display:grid;
    grid-template-columns: repeat(5, 1fr);
    gap:10px;
    background-color: #f4f4edff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-radius:5%;
    border:solid black 1px;
}

    #buttons {
      padding-right: 200px;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      $("#r").click(function () {
        window.location.href = 'home.php';
      });

      $("#m").click(function () {
        window.location.href = 'manual_input.php';
      });

      $("#a").click(function () {
        window.location.href = 'add_your_own.html';
      });
    });

    function seeMore(name) {
      window.location.href = "details.php?temp=" + encodeURIComponent(name);
    }

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
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid" id="nav">
  <div><img style="height:60px; width:60px; border-radius:50%;" src="logos.jpg"><span class="forte-title"><b> Cooking the Book</b></span></div>
      <div class="d-flex align-items-center flex-wrap" id="buttons">
        <input class="btn btn-outline-secondary" type="button" id="r" value="Randomize" />
        <input class="btn btn-outline-secondary" id="m" type="button" value="Manual Input" />
        <input class="btn btn-outline-secondary" type="button" id="a" value="Add Your Own" />
      </div>
      <div class="d-flex align-items-center flex-wrap" id="icons">
        <div id="wishlist">
          <button style="border:black solid 2px;" onclick="wish()" class="btn btn-light">
            <img src="heart.png" alt="Wishlist" />
          </button>
        </div>
        <div id="profile">
          <button style="border:black solid 2px;" onclick="profile()" class="btn btn-light">
            <img src="profile.jpg" alt="Profile" />
          </button>
        </div>
        <div id="logout">
          <button class="btn btn-danger" onclick="logout()">Log Out →</button>
        </div>
      </div>
    </div>
  </nav>
  <div style="display:grid; justify-content:center; padding-top:50px;">
<div style="padding-right:50px; padding-left:50px; color:rgba(78, 79, 59, 0.86);"><h2><u>You Have More than Enough Ingredients,</u></h2></div>
<div style="padding-right:100px; padding-left:100px; color:rgba(78, 79, 59, 0.86);"><h3><u>You can make the suggested recipes!!</u></h3></div>
</div>
<?php
include("db_connection.php");

$cooking_time = isset($_GET['time']) ? $_GET['time'] : "00:30:00"; // fallback if missing
$vegies = isset($_GET["vegies"]) ? $_GET["vegies"] : array();
$fruits = isset($_GET["fruits"]) ? $_GET["fruits"] : array();
$grains = isset($_GET["grains"]) ? $_GET["grains"] : array();

echo "<div id='outer'>";

$q = mysql_query("SELECT did FROM detailed_recipe;");
while ($rs = mysql_fetch_array($q)) {
  $f = 0;
  $did = $rs['did'];
  $cnt = 0;

  $q2 = mysql_query("SELECT count(did) FROM recipe_vegies WHERE did = $did;");
  $q3 = mysql_query("SELECT count(did) FROM recipe_fruits WHERE did = $did;");
  $q4 = mysql_query("SELECT count(did) FROM recipe_grains WHERE did = $did;");

  $rs1 = mysql_fetch_array($q2);
  $rs2 = mysql_fetch_array($q3);
  $rs3 = mysql_fetch_array($q4);

  $total_count = $rs1[0] + $rs2[0] + $rs3[0];

  foreach ($vegies as $vegie) {
    $q1 = mysql_query("SELECT name FROM detailed_recipe WHERE did IN (
      SELECT did FROM recipe_vegies WHERE vid IN (
        SELECT vid FROM vegies WHERE vegies.name = '$vegie'
      ) AND did = $did
    );");
    $tempname = mysql_fetch_array($q1);
    if ($tempname && isset($tempname['name'])) {
      $cnt++;
    }
  }

  foreach ($fruits as $fruit) {
    $q1 = mysql_query("SELECT name FROM detailed_recipe WHERE did IN (
      SELECT did FROM recipe_fruits WHERE fid IN (
        SELECT fid FROM fruits WHERE fruits.name = '$fruit'
      ) AND did = $did
    );");
    $tempname = mysql_fetch_array($q1);
    if ($tempname && isset($tempname['name'])) {
      $cnt++;
    }
  }

  foreach ($grains as $grain) {
    $q1 = mysql_query("SELECT name FROM detailed_recipe WHERE did IN (
      SELECT did FROM recipe_grains WHERE gid IN (
        SELECT gid FROM grains WHERE grains.name = '$grain'
      ) AND did = $did
    );");
    $tempname = mysql_fetch_array($q1);
    if ($tempname && isset($tempname['name'])) {
      $cnt++;
    }
  }

  if ($total_count == 0 || ($total_count > 0 && ($cnt / $total_count) >= 0.5)) {
    $f = 1;
  }

  if ($f == 1) {
    $rname = mysql_query("SELECT * FROM recipes WHERE name IN (
      SELECT name FROM detailed_recipe 
      WHERE did = $did AND cooking_time <= '$cooking_time'
    );");

    $rec_name = mysql_fetch_array($rname);
    if ($rec_name && isset($rec_name['name'])) {
      $recipeName = htmlspecialchars($rec_name['name']);
      $recipeImg = htmlspecialchars($rec_name['image']);

      echo "
        <div id='cards'>
          <b>$recipeName</b><br>
          <img id='recipe' src='$recipeImg' alt='Recipe Image'><br>
          <button class='btn btn-outline-dark mt-2' onclick=\"seeMore('$recipeName')\">See More</button>
        </div>";
    }
  }
}

echo "</div>";
?>
</body>
</html>
