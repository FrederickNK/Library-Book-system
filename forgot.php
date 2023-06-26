<?php

require "includes/library.php";
$pdo = connectDB();

$email = $_POST['emailaddress'] ?? null;
$errors = array(); //declare empty array to add errors too

if (isset($_POST['submit']))
{
  $sql = "SELECT* FROM brownburry_Book_System WHERE email =? ";
  $stmt=$pdo->prepare($sql);
  $stmt->execute([$email]);
  $row = $stmt->fetch();

  if($row == 0){
    $errors['exists'] = true; 
  }
  else
  {
    session_start(); //start session
    $_SESSION['emal'] = $email;
    header("Location:mail.php");
    exit();
  }
 

}

?>


<!--Frederick Nkwonta _January 2023-->
<!--purpose: collects the username and/or email address to allow the user to request a password reset.-->
<!DOCTYPE html>
<html lang="en">

<head>
<?php
$page_title = "Forgot";
include 'includes/metadata.php';?>
</head>

<body>
  <?php include 'includes/header.php';?>
    <i class="fa-sharp fa-solid fa-circle-exclamation fa-8x"></i>
  </header>

  <main>

    <form id="resetpass" name="resetpass" action="login.php" method="post">
      <h2>Forgot Password</h2>
      <!--prompt the user for email address.-->

      <div>
        <label for="emailaddress"> Email:</label>
        <input type="email" name="emailaddress" id="emailaddress" placeholder="Enter your email" required>
        <span class="error <?=isset($errors['exists']) ? '' : "hidden";?>">Email does not exists</span>

      </div>
      <!--request for password reset.-->
      <div>
        <button type="submit" id="passreset"> Reset Password</button>
      </div>
    </form>
    <?php include 'includes/footer.php';?>
</body>

</html>