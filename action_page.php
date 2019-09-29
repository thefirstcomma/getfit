<html>
<body>

<?php
$link = mysqli_connect("localhost", "root", "", "demo");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>

Welcome <?php echo $_POST["name"]; ?><br>
Chest: <?php echo $_POST["chest"]; ?><br>
Stomach: <?php echo $_POST["stomach"]; ?><br>
Waist: <?php echo $_POST["waist"]; ?><br>


<?php
$sql = "INSERT INTO bodysize (first_name, last_name, email) VALUES ('Peter', 'Parker', 'peterparker@mail.com')";

if(mysqli_query($link, $sql)){
    echo "Records inserted successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);

?>
</body>
</html>