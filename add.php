<?php 
//Connects to your Database 
 $database="YOUR.database.info.hostedresource.com";
 $username="YOURusername";
 $password="YOURpassword";
 $db("YOURdatabase"); 

//obj dns; above is all I need to tamper with when moving severs; DB names and tables WILL be the same;
$dsn = "mysql:host=$host;dbname=$database";
 
//object db to call when needed;
$db = new PDO($dsn, $user, $password);

//dev test
//$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

//obj to call to put #&carr into table
$put = "INSERT INTO fullaccounts (username,userpassword,useremail,userphone,usercarrier)
     VALUES (:username,:userpassword,:useremail,:userphone,:usercarrier)";
$post = $_POST['post'];

 //This makes sure they did not leave any fields blank

 if (!$_POST['username'] | !$_POST['pass'] | !$_POST['pass2'] ) {

 		die('You did not complete all of the required fields');

 	}



 // checks if the username is in use

 	if (!get_magic_quotes_gpc()) {

 		$_POST['username'] = addslashes($_POST['username']);

 	}

 $usercheck = $_POST['username'];

 $check = mysqli_query("SELECT username FROM users WHERE username = '$usercheck'") 

or die(mysqli_error());

 $check2 = mysqli_num_rows($check);



 //if the name exists it gives an error

 if ($check2 != 0) {

 		die('Sorry, the username '.$_POST['username'].' is already in use.');

 				}


 // this makes sure both passwords entered match

 	if ($_POST['pass'] != $_POST['pass2']) {

 		die('Your passwords did not match. ');

 	}



 	// here we encrypt the password and add slashes if needed

 	$_POST['pass'] = md5($_POST['pass']);

 	if (!get_magic_quotes_gpc()) {

 		$_POST['pass'] = addslashes($_POST['pass']);

 		$_POST['username'] = addslashes($_POST['username']);

 			}

 // now insert it into the database
 	$stmt = $db->prepare($put);
 	      
        $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
        $stmt->bindParam(':userpassword', $_POST['userpassword'], PDO::PARAM_STR);
        $stmt->bindParam(':useremail', $_POST['useremail'], PDO::PARAM_STR);
        $stmt->bindParam(':userphone', $_POST['userphone'], PDO::PARAM_STR);
        $stmt->bindParam(':usercarrier', $_POST['usercarrier'], PDO::PARAM_STR);

        $stmt->execute();


 	?>

 <h1>Registered</h1>

 <p>Thank you, you have registered - you may now <a href="login.php">login</a>.</p>

 <?php 
 } 

 else 
 {	
 ?>
 
 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

 <table border="0">

 <tr><td>Username:</td><td>

 <input type="text" name="username" maxlength="60">

 </td></tr>

 <tr><td>Password:</td><td>

 <input type="password" name="pass" maxlength="10">

 </td></tr>

 <tr><td>Confirm Password:</td><td>

 <input type="password" name="pass2" maxlength="10">

 </td></tr>

 <tr><th colspan=2><input type="submit" name="submit" 
value="Register"></th></tr> </table>

 </form>


 <?php

 }
 ?> 
