<?php
session_start();
include("db_connection.php");
if(isset($_SESSION['email'])){
// Get username
$un = mysql_query("SELECT username FROM recipe_login WHERE uid=" . $_SESSION['uid'] . ";");
$username = mysql_fetch_array($un);
$username = $username['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wishlist - <?php echo $username; ?></title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

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

    #wishlist img, #profile img {
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
    }

    #cards {
      padding: 50px;
      background-color: rgba(232, 233, 185, 0.86);
      height: 250px;
      width: 250px;
      border: rgba(78, 79, 59, 0.86) solid 2px;
      border-radius: 40px;
    }

    #cards:hover {
      background-color: rgba(248, 248, 227, 0.86);
      filter: opacity(0.9);
    }

    nav {
      padding-bottom: 20px;
    }

    #outer {
    
      padding: 20px 200px;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
      /*justify-content: center;*/
    }

    #buttons {
      padding-right: 200px;
    }

    .wishlist-title {
      font-size: 24px;
      font-weight: bold;
      margin: 30px 20px 10px;
      color: rgba(78, 79, 59, 0.86);
      font-family: 'Segoe UI', sans-serif;
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
      <!-- Brand/Title -->
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
          <button onclick="wish()" style="border:black solid 2px;" class="btn btn-light">
            <img src="heart.png" alt="Wishlist">
          </button>
        </div>
        <div id="profile">
          <button onclick="profile()" style="border:black solid 2px;" class="btn btn-light">
            <img src="profile.jpg" alt="Profile">
          </button>
        </div>
        <div id="logout">
          <button onclick="logout()" class="btn btn-danger">Log Out →</button>
        </div>
      </div>
    </div>
  </nav>

  <!-- Wishlist Title -->
  <div class="wishlist-title" style="text-align: center; font-size: 50px; margin-top: 20px; font-weight: bold;"><strong>Wishlist of <i><?php echo htmlspecialchars($username); ?></i></strong></div>

  <!-- Recipes Grid -->
  <div id="outer">
    <?php
    $q = mysql_query("SELECT * FROM recipes WHERE name IN (SELECT name FROM wishlist WHERE uid=" . $_SESSION['uid'] . ");");
    while ($rs = mysql_fetch_array($q)) {
    ?>
      <div id="cards">
        <div><img id="recipe" src="<?php echo($rs[0]); ?> "></div>
        <div><?php echo($rs[1]); ?></div>
        <div><button onclick="get_recipe('<?php echo($rs[1]); ?>')">Get Recipe</button></div>
      </div>
    <?php } }
    else
    {
      echo("<script>alert('please login first')</script>");
      echo("<script>window.location.href='login.html'</script>");
    }
    ?>
  </div>

  <script>
    function get_recipe(temp) {
      window.location.href = "details.php?temp=" + encodeURIComponent(temp);
    }
  </script>
</body>
</html>
