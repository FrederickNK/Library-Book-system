<?php

include 'includes/library.php';
$pdo = connectDB();


$errors = array(); //declare empty array to add errors too

//get values from post or set to NULL if doesn't exist
$username = $_POST['username'] ?? null;
$firstname = $_POST['firstname'] ?? null;
$lastname = $_POST['lastname'] ?? null;
$email = $_POST['emailaddress'] ?? null;
$pass = $_POST['passwd'] ?? null;
$verpass = $_POST['passwdv'] ?? null;

/*****************************************
 * Include library, make database connection,
 * and query for dropdown list information here
 ***********************************************/

 // only do this code if the form has been submitted

 if (isset($_POST['submit'])) { 

 // if (!isset($username) || strlen($username) === 0) {
   // $errors['username'] = true;
 // }

 // if (!isset($firstname) || strlen($firstname) === 0) {
  //  $errors['firstname'] = true;
  //}
  //if (!isset($lastname) || strlen($lastname) === 0) {
   // $errors['lastname'] = true;
  //}
  //if (!isset($email) || strlen($email) === 0) {
    //$errors['emailaddress'] = true;
  //}
  //if (!isset($pass) || strlen($pass) === 0) {
    //$errors['passwd'] = true;
  //}
  //if (strcmp($pass, $verpass) !== 0) {
   // $errors['passwdv'] = true;
  //}

  //only do this if there weren't any errors
  if (count($errors) === 0) {

    // hash password using default algorithm

    $hash = password_hash($pass, PASSWORD_DEFAULT);
    
    // check if username already exists in database

    $sql = "SELECT* FROM brownburry_Book_System WHERE username =? ";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$username]);
    $row = $stmt->fetch();

      // if username already exists, add error to array

    if($row > 0){
     //$errors['existUserN'] = true;
    }
  else
  {
      // otherwise, insert new user into database


    $query = "insert into brownburry_Book_System values (NULL, ?,?,?,?,?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username, $firstname, $lastname, $email, $hash]);
    header("Location:login.php");
    exit();
  }
}
}

?>


<!--Frederick Nkwonta _January 2023-->
<!--purpose: allows the use to register with the application-->
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$page_title = "Register";
include 'includes/metadata.php';?>
<title> <?php echo $page_title ?></title>
<script defer src="./scripts/createAccV.js"></script>
<script defer src="./scripts/viewpass.js"></script>


</head>

<body>
  <?php include 'includes/header.php';?>
  <figure><i class="fa-solid fa-user-plus fa-8x"></i></figure>

  </header>
<!--form that collects user info to register such first name last name ,email nad etc-->

<main>
  <h2> Registration Form</h2>
  <form id="register" name="register request" action="<?=htmlentities($_SERVER['PHP_SELF']);?>" method="post" autocomplete="off">
    <div>
      <label for="username"> Username:</label>
      <input
        autocomplete="off"
        type="text"
        name="username"
        id="username"
        placeholder="Username"
        value="<?=$username?>">
        <span class="error <?=isset($errors['username']) ? '' : "hidden";?>">Please enter a username</span>
        <span class="error <?=isset($errors['existUserN']) ? '' : "hidden";?>">User exist try again</span>

    </div>

    <div>
      <label for="firstname">First Name:</label>
      <input
        type="text"
        name="firstname"
        id="firstname"
        placeholder="First Name"
        value="<?=$firstname?>" >
        <span class="error <?=isset($errors['firstname']) ? '' : "hidden";?>">Please enter a First Name</span>

    </div>
    <div>

      <label for="lastname">Last Name:</label>
      <input
        type="text"
        name="lastname"
        id="lastname"
        placeholder="Last Name"
        value="<?=$lastname?>" >
        <span class="error <?=isset($errors['lastname']) ? '' : "hidden";?>">Please enter a Last Name</span>

    </div>

    <div>
      <label for="emailaddress">Email</label>
      <input
        type="email"
        name="emailaddress"
        id="emailaddress"
        placeholder="Email Address"
        value = "<?=$email?>">
        <span class="error <?=isset($errors['emailaddress']) ? '' : "hidden";?>">Please enter your email</span>

      </div>

    <div>
      <label for="passwd">Password:</label>
      <input
      type="password"
      name="passwd"
      id="passwd"
      placeholder="Password"
      value = "<?=$pass?>">
      <span class="error <?=isset($errors['passwd']) ? '' : "hidden";?>">Please enter your password</span>
    
    </div>

    <div>
      <label for="passwdv">Verify Password:</label>
      <input
      type="password"
      name="passwdv"
      id="passwdv"
      placeholder=" Verify Password "
      value = "<?=$verpass?>">
      <span class="error <?=isset($errors['passwdv']) ? '' : "hidden";?>">Enter the same password</span>


    </div>


    <div>
      <button type="submit" name="submit" id=submitAccount> Create Account</button>
    </div>
  </form>
  <?php include 'includes/footer.php';?>


</html>