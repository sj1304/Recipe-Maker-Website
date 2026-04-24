<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Recipe Viewer</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    body {
      background-color: #fdfdf5;
      font-family: 'Segoe UI', sans-serif;
    }

    .forte-title {
      font-size: 30px;
      color: rgba(78, 79, 59, 0.86);
      font-family: 'Forte', cursive;
      padding-right: 200px;
    }

    #nav {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      padding: 10px 20px;
      background-color: rgba(212, 212, 208, 0.86);
    }

    #buttons {
      display: flex;
      gap: 15px;
      margin-right: 15px;
    }

    #wishlist img,
    #profile img {
      width: 30px;
      height: 30px;
    }

    .recipe-card {
      max-width: 1000px;
      margin: 30px auto;
      padding: 25px;
      border: 2px solid rgba(78, 79, 59, 0.86);
      border-radius: 25px;
      background-color: rgba(248, 248, 227, 0.86);
    }

    .recipe-card img.main {
      width: 1000px;
      height: 600px;
      border-radius: 10px;
      margin-bottom: 20px;
    }

    .recipe-detail strong {
      display: inline-block;
      width: 150px;
    }

    .recipe-detail {
      margin-bottom: 10px;
    }

    .section-title {
      font-size: 22px;
      font-weight: bold;
      margin-top: 20px;
    }

    nav {
      padding-bottom: 20px;
    }

    #icons {
      display: flex;
      gap: 15px;
    }

    .ingredient-img {
      height: 150px;
      object-fit: cover;
    }

    #like:hover {
transform: scale(1.3);
      color: deeppink;
}
  </style>

  <script>
    $(document).ready(function () {
      $("#r").click(function () {
        window.location.href = "home.php";
      });

      $("#m").click(function () {
        window.location.href = "manual_input.php";
      });

      $("#a").click(function () {
        window.location.href = "add_your_own.html";
      });
    });

    function Search() {
      var sname = document.getElementById("sname").value;
      var x;

      if (window.XMLHttpRequest) {
        x = new XMLHttpRequest();
      } else {
        x = new ActiveXObject("Microsoft.XMLHTTP");
      }

      x.onreadystatechange = function () {
        if (x.readyState == 4 && x.status == 200) {
          document.getElementById("outer").innerHTML = x.responseText;
          document.getElementById("outer").style.display = "flex";
        }
      };

      document.getElementById("outer").style.display = "none";
      x.open("get", "Searched.php?sname=" + sname, true);
      x.send();
    }

    function like(element, name) {
  let f = 0;

  if (element.style.color == 'red') {
    element.style.color = 'grey';
    element.style.transform = 'scale(1.1)';
    f = 0;
  } else if (element.style.color == 'grey') {
    element.style.color = 'red';
    element.style.transform = 'scale(1.3)';
    f = 1;
  }

  // Send name and f to PHP
  var xhttp = new XMLHttpRequest();
  xhttp.open("POST", "wishlist.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("name=" + encodeURIComponent(name) + "&f=" + f);
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
          <button onclick="wish()" style="border:black solid 2px;" class="btn btn-light">
            <img src="heart.png" alt="Wishlist" />
          </button>
        </div>
        <div id="profile">
          <button onclick="profile()" style="border:black solid 2px;" class="btn btn-light">
            <img src="profile.jpg" alt="Profile" />
          </button>
        </div>
        <div id="logout">
          <button onclick="logout()" class="btn btn-danger">Log Out →</button>
        </div>
      </div>
    </div>
  </nav>

  <?php
  include("db_connection.php");

  $temp = $_GET['temp'];

  $q = mysql_query("SELECT * FROM recipes where name='".$temp."';");
  $rs = mysql_fetch_array($q);
  $image = $rs[0];
  $name = $rs[1];

  $q1 = mysql_query("SELECT * FROM detailed_recipe where name='".$temp."';");
  $rs1 = mysql_fetch_array($q1);
  $instructions = $rs1['instructions'];
  $cooking_time = $rs1['cooking_time'];
  $funfact = $rs1['funfact'];
  $did = $rs1['did'];

  $q2 = mysql_query("select vid from recipe_vegies where did=".$did.";");
  $q4 = mysql_query("select fid from recipe_fruits where did=".$did.";");
  $q5 = mysql_query("select gid from recipe_grains where did=".$did.";");
  ?>

  <div class="recipe-card shadow">
    <h2 class="text-center mb-4"><strong><?php echo htmlspecialchars($name); ?></strong></h2>
    <img src="<?php echo htmlspecialchars($image); ?>" alt="Recipe Image" class="img-fluid mx-auto d-block main" />

    <div class="recipe-detail"><strong>Cooking Time:</strong> <?php echo($cooking_time); ?> mins<i id="like" class="fas fa-heart" style="margin-left:600px; color:grey; font-size: 50px;" onclick="like(this,'<?php echo($name); ?>')"></i>
</div>

    <!-- Vegies Section -->
     
    <div class="section-title">Vegies:</div>
    <div class="row">
      <?php
      
      while($rs3 = mysql_fetch_array($q2)) {
        $q3 = mysql_query("select * from vegies where vid=".$rs3['vid'].";");
        $rs4 = mysql_fetch_array($q3);
        $vegie_name = $rs4['name'];
        $vegie_image = $rs4['image'];
      ?>
      <div class="col-md-4 text-center mb-3">
        <img src="<?php echo($vegie_image); ?>" alt="<?php echo($vegie_name); ?>" class="img-fluid rounded shadow ingredient-img">
        <div class="mt-2"><strong><?php echo($vegie_name); ?></strong></div>
      </div>
      <?php } ?>
    </div>

    <!-- Fruits Section -->
    <div class="section-title">Fruits:</div>
    <div class="row">
      <?php
      while($rs3 = mysql_fetch_array($q4)) {
        $q3 = mysql_query("select * from fruits where fid=".$rs3['fid'].";");
        $rs4 = mysql_fetch_array($q3);
        $fruit_name = $rs4['name'];
        $fruit_image = $rs4['image'];
      ?>
      <div class="col-md-4 text-center mb-3">
        <img src="<?php echo($fruit_image); ?>" alt="<?php echo($fruit_name); ?>" class="img-fluid rounded shadow ingredient-img">
        <div class="mt-2"><strong><?php echo($fruit_name); ?></strong></div>
      </div>
      <?php } ?>
    </div>

    <!-- Grains Section -->
    <div class="section-title">Grains:</div>
    <div class="row">
      <?php
      while($rs3 = mysql_fetch_array($q5)) {
        $q3 = mysql_query("select * from grains where gid=".$rs3['gid'].";");
        $rs4 = mysql_fetch_array($q3);
        $grain_name = $rs4['name'];
        $grain_image = $rs4['image'];
      ?>
      <div class="col-md-4 text-center mb-3">
        <img src="<?php echo($grain_image); ?>" alt="<?php echo($grain_name); ?>" class="img-fluid rounded shadow ingredient-img">
        <div class="mt-2"><strong><?php echo($grain_name); ?></strong></div>
      </div>
      <?php } ?>
    </div>

    <!-- Instructions -->
    <div class="section-title">Instructions:</div>
    <p><em><?php echo nl2br(htmlspecialchars($instructions)); ?></em></p>

    <!-- Fun Fact -->
    <div class="section-title">Fun Fact:</div>
    <p><em><?php echo nl2br(htmlspecialchars($funfact)); ?></em></p>
  </div>
</body>
</html>
