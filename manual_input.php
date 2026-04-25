<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Recipe Viewer</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
   /* padding-bottom:20px;*/
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



    .ingredient-img {
      height: 60px;
      width: 60px;
      object-fit: cover;
      border: 1px solid #ccc;
    }

    .ingredient-section {
      display: flex;
      align-items: flex-start;
      gap: 15px;
      margin-bottom: 20px;
    }

    .selection-area {
      flex: 1;
    }

    .image-preview-area {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 5px;
      width: 140px;
      flex-shrink: 0;
    }

    .time-box {
      height: 50%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    /*.time-box .btn {
      align-self: end;
    }*/
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

    function updateImages(selectId, imageDivId, outputId) {
      const select = document.getElementById(selectId);
      const selectedOptions = Array.from(select.selectedOptions);
      const selectedNames = selectedOptions.map(option => option.text);
      const imageDiv = document.getElementById(imageDivId);
      document.getElementById(outputId).value = selectedNames.join(" ");
      imageDiv.innerHTML = "";
      selectedOptions.forEach(option => {
        const imgPath = option.getAttribute("data-image");
        if (imgPath) {
          const img = document.createElement("img");
          img.src = imgPath;
          img.alt = option.text;
          img.className = "ingredient-img rounded";
          imageDiv.appendChild(img);
        }
      });
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
  /*  function s1() {
      //alert("Search triggered! (You can connect this to actual logic)");
      window.location.href="manual_output.php";
    }*/
  </script>
</head>
<body>
  
<?php include("db_connection.php"); ?>

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

<form action="manual_output.php" method="get">  
  <div style="background-color:rgba(232, 233, 185, 0.86); border-radius:3%;" class="container mt-4">
    <h3 style="padding-top:20px;"><u>What do you have with you?</u></h3>
    <div style="padding:20px;" class="row">
      <!-- Left Column -->
      <div class="col-md-9">

        <!-- Veggies Section -->
        <div class="ingredient-section">
          <div class="selection-area">
            <label><b>Veggies:</b></label><br>
            <?php $q = mysql_query("SELECT * FROM vegies;"); ?>
            <select name="vegies[]" id="vegies" multiple class="form-select mt-2" onchange="updateImages('vegies','vegie-images','vegies_output')" size="4">
              <?php while ($rs = mysql_fetch_array($q)) { ?>
                <option value="<?php echo $rs['name']; ?>" data-image="<?php echo $rs['image']; ?>">
                  <?php echo $rs['name']; ?>
                </option>
              <?php } ?>
            </select>
            <input type="text" id="vegies_output" readonly class="form-control mt-2">
          </div>
          <div class="image-preview-area" id="vegie-images"></div>
        </div>

        <!-- Fruits Section -->
        <div class="ingredient-section">
          <div class="selection-area">
            <label><b>Fruits:</b></label><br>
            <?php $q = mysql_query("SELECT * FROM fruits;"); ?>
            <select name="fruits[]" id="fruits" multiple class="form-select mt-2" onchange="updateImages('fruits','fruit-images','fruits_output')" size="4">
              <?php while ($rs = mysql_fetch_array($q)) { ?>
                <option value="<?php echo $rs['name']; ?>" data-image="<?php echo $rs['image']; ?>">
                  <?php echo $rs['name']; ?>
                </option>
              <?php } ?>
            </select>
            <input type="text" id="fruits_output" readonly class="form-control mt-2">
          </div>
          <div class="image-preview-area" id="fruit-images"></div>
        </div>

        <!-- Grains Section -->
        <div class="ingredient-section">
          <div class="selection-area">
            <label><b>Grains:</b></label><br>
            <?php $q = mysql_query("SELECT * FROM grains;"); ?>
            <select name="grains[]" id="grains" multiple class="form-select mt-2" onchange="updateImages('grains','grain-images','grains_output')" size="4">
              <?php while ($rs = mysql_fetch_array($q)) { ?>
                <option value="<?php echo $rs['name']; ?>" data-image="<?php echo $rs['image']; ?>">
                  <?php echo $rs['name']; ?>
                </option>
              <?php } ?>
            </select>
            <input type="text" id="grains_output" readonly class="form-control mt-2">
          </div>
          <div class="image-preview-area" id="grain-images"></div>
        </div>
      </div>

      <!-- Right Column: Time and Search -->
      <div class="col-md-3">
        <div class="border p-3 rounded bg-light shadow-sm time-box">
          <div>
            <label class="form-label"><b>How much time do you have?</b></label>
            <input type="text" name="time" class="form-control form-control-sm mb-3" placeholder="e.g. 120(convert in minutes)">
          
      </div>
    </div>
          <button style="height=200px; font-size:30px; width:200px; color:white; border-radius:50px; background-color:rgba(56, 56, 52, 0.86);;" >Search</button>
        </div>
    </div>
  </div>
  </form>
</body>
</html>
