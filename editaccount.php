<?php
/****************************************
// ENSURES THE USER HAS ACTUALLY LOGGED IN
// IF NOT REDIRECT TO THE LOGIN PAGE HERE
 ******************************************/
session_start(); //start session
  //check session for whatever user info was stored
if(!isset($_SESSION['username'])){
    //no user info, redirect
  header("Location:index.php");
  exit();
}
require "includes/library.php";

$Cusername = $_SESSION['username'] ?? null;

// CONNECT TO DATABASE
$pdo = connectDB();

$errors = array(); //declare empty array to add errors too


// get the contents of naughty/nice list, behavior first so we can use PDO Fetch_group to get two different arrays
$sql= "SELECT* from brownburry_Book_System where username =?";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$Cusername]);
    $row = $stmt->fetch();

    //get values from database
    $Cid = $row['id'];
    $Cfirstname = $row['firstname'];
    $Clastname = $row['lastname'];
    $Cemail = $row['email'];
    $truncated_hash = substr($row['password'], 0, 8); // Truncate to first 20 characters
    $Cpass = $truncated_hash;

    //get values from post or set to NULL if doesn't exist
  $username = $_POST['username'] ?? null;
  $firstname = $_POST['firstname'] ?? null;
  $lastname = $_POST['lastname'] ?? null;
  $email = $_POST['emailaddress'] ?? null;
  $pass = $_POST['passwd'] ?? null;
  $verpass = $_POST['passwdv'] ?? null;

    if (isset($_POST['submit'])) { //only do this code if the form has been submitted
     
      if (!isset($username) || strlen($username) === 0  ) {
        $errors['username'] = true; 
      }
      if (!isset($firstname) || strlen($firstname) === 0) {
        $errors['firstname'] = true; 
      }
      if (!isset($lastname) || strlen($lastname) === 0) {
        $errors['lastname'] = true; 
      }
      if (!isset($email) || strlen($email) === 0) {
        $errors['emailaddress'] = true; 
      }
      if (!isset($pass) || strlen($pass) === 0) {
        $errors['passwd'] = true; 
      }
      
    
    
      if (count($errors) === 0) {
      
      $hash = password_hash($pass, PASSWORD_DEFAULT);

      $updater = "UPDATE brownburry_Book_System set username=?,firstname=?,lastname=?,email=?,password=? where id=?";
      $stmt = $pdo->prepare($updater);
      $stmt->execute([$username,$firstname,$lastname,$email,$hash,$Cid]);
      
      session_start(); //start session
      $_SESSION['username'] = $username;

      header("Location:index.php");
      exit();
      }
      
    }

    
?>







<!--Frederick Nkwonta _January 2023-->
<!--purpose: allows the use to register with the application-->
<!DOCTYPE html>
<html lang="en">
<head>
<?php

include 'includes/metadata.php';?>
<title> Register </title>
<script defer src="./scripts/deleteaccount.js"></script>
</head>

<body>
  <?php include 'includes/header.php';?>
  <figure><i class="fa-solid fa-user-plus fa-8x"></i></figure>

  </header>
<!--form that collects user info to register such first name last name ,email nad etc-->

<?php include 'includes/nav.php';?>


  <h2> My Account </h2>
  <form id="register" name="register request" action="<?=htmlentities($_SERVER['PHP_SELF']);?>" method="post" autocomplete="off">
    <div>
      <label for="username"> Username:</label>
      <input
        autocomplete="off"
        type="text" 
        name="username"
        id="username"
        placeholder="Username" 
        value="<?php echo $Cusername; ?>"/>

        <span class="error <?=isset($errors['username']) ? '' : "hidden";?>">User name invaild</span>
        <span class="error <?=isset($errors['existUserN']) ? '' : "hidden";?>">User exist try again</span>

    </div>

    <div>
      <label for="firstname">First Name:</label>
      <input 
        type="text" 
        name="firstname" 
        id="firstname" 
        placeholder="First Name"
        value="<?php echo htmlentities($Cfirstname) ?>" />
        <span class="error <?=isset($errors['firstname']) ? '' : "hidden";?>">Please enter a First Name</span>

    </div>
    <div>

      <label for="lastname">Last Name:</label>
      <input 
        type="text" 
        name="lastname" 
        id="lastname" 
        placeholder="Last Name" 
        value="<?= htmlentities($Clastname)?>" />
        <span class="error <?=isset($errors['lastname']) ? '' : "hidden";?>">Please enter a Last Name</span>

    </div>

    <div>
      <label for="emailaddress">Email</label>
      <input 
        type="email" 
        name="emailaddress" 
        id="emailaddress" 
        placeholder="Email Address" 
        value = "<?=htmlentities($Cemail)?>"/>
        <span class="error <?=isset($errors['emailaddress']) ? '' : "hidden";?>">Please enter your email</span>

      </div>

    <div>
      <label for="passwd">Password:</label>
      <input 
      type="password" 
      name="passwd" 
      id="passwd" 
      placeholder="Password" 
      value = "<?=htmlentities($Cpass)?>"/>
      <span class="error <?=isset($errors['passwd']) ? '' : "hidden";?>">Please enter your password</span>

     
    </div>
    
    <div>
      <button type="submit" name="submit" id=submitAccount> Save Changes</button>
    </div>
  </form>
  <div>
    <button id="deletebutton" name = "deleteA">Delete Account</button>
   </div>
  <?php include 'includes/footer.php';?>
</body>

</html>