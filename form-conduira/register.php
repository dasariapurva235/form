<html>
<head></head>
<link rel="stylesheet" type="text/css" href="styles.css">
<body>
<?php
session_start();
$user = "root"; 
$host = "localhost"; 
$password = ""; 
$dbname = "register"; 

$con = mysqli_connect($host, $user, $password,$dbname);

if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}
if(isset($_POST['submit'])){
   $fname = trim($_POST['firstname']);
   $lname = trim($_POST['lastname']);
   $email = trim($_POST['email']);
   $branch=$_POST['branch'];

  $isValid = true;
   if($fname == '' || $lname == '' || $email == '' || $branch==''){
     $isValid = false;
    echo "<h1>Please fill all fields.</h1>";
   }

   if ($isValid && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
     $isValid = false;
    echo "<h1>Invalid Email-ID.</h1>";
   }	

   if($isValid){
     $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $result = $stmt->get_result();                    
     $stmt->close();
     if($result->num_rows > 0){
       $isValid = false;
       echo "<h1>Email-ID exists already.</h1>";
	 }	  
    }
   if($isValid){
      $sql = "INSERT INTO users (firstname,lastname,email,branch)
	 VALUES ('$fname','$lname','$email','$branch')";
	 if (mysqli_query($con, $sql)) {
		echo "<h1>Registered successfully</h1><br><br>";
		echo "<h1>Welcome $fname $lname!<h1>";
	 } 
     else{
		 echo "<h1>Could not register. Please try again.</h1>";
     
   }
   }
}
   mysqli_close($con);

?>
</body>
</html>
