<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
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

#outer{
    padding:20px;
    display:flex;
    gap:10px;
    
}
</style>
</head>
<body>
    

<?php
include("db_connection.php");
$sname=$_GET['sname'];
if(strlen($sname)>0){
$q=mysql_query("select * from recipes where name='".$sname."';");
}
else
{
    $q=mysql_query("select * from recipes;");
}
while($rs=mysql_fetch_array($q)){ ?>
<div id="cards">
<div><img id="recipe" src="<?php echo($rs[0]); ?> "></div>
<div><?php echo($rs[1]); ?></div>
<div><button onclick="get_recipe('<?php echo($rs[1]); ?>')">Get Recipe</button></div>
</div>
<?php } ?>

</body>
</html>
