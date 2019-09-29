<html>
<body>

<?php
$link = mysqli_connect("localhost", "root", "", "demo");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$name = mysqli_real_escape_string($link, $_REQUEST['name']);
$chest = mysqli_real_escape_string($link, $_REQUEST['chest']);
$stomach = mysqli_real_escape_string($link, $_REQUEST['stomach']);
$waist = mysqli_real_escape_string($link, $_REQUEST['waist']);

$sql = "INSERT INTO bodysize (name, chest, stomach, waist) VALUES ('$name', '$chest', '$stomach', '$waist')";

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