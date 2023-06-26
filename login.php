<?php
// Collect username, password, and remember checkbox values from form

$username = $_POST['username'] ?? null;
$pass = $_POST['passwd']?? null;
$Remember = $_POST['rememberme'] ?? null;

$errors = array(); //declare empty array to add errors too

// Include library and connect to database
include "includes/library.php";
$pdo = connectdb(); 

// If submit button is clicked, check if user exists in database and if password is correct

if (isset($_POST['submit']))
{
    // Prepare and execute SQL statement to select user with given username

    $sql= "SELECT* from brownburry_Book_System where username =?";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$username]);
    $row = $stmt->fetch();


    // If user doesn't exist, add error to array
    if(!$row){
        $errors['user'] = true;
      }
    else 
    {
        // If user exists, verify password
        if (password_verify($pass, $row['password'])) { 
            //where $pass is collected, and $row is our database row, and pass the field name.
            session_start(); //start session
            $_SESSION['username'] = $username;
            $_SESSION['userid'] = $userid;
            $_SESSION['passwd'] = $pass;

            
            // If remember checkbox is checked, set cookie 
            if ($Remember == "R")  {
              setcookie("mysitecookie",$username,time()+60);
             }
            
          // Redirect to main page
            header("Location:index.php");
            exit();
         //redirect to main page
      } else {
            $errors['login'] = true;
  
        }
    }
}
// If mysitecookie exists, set $username variable to its value
if(isset($_COOKIE['mysitecookie'])){
  $username=$_COOKIE['mysitecookie'];
}
 
?>



<!--Frederick Nkwonta _January 2023-->
<!--purpose: collects username and password to allow the user to login.-->


<!DOCTYPE html>
<html lang="en">

<head>
<?php
$page_title = "Login";
include 'includes/metadata.php';?>
<title> <?php echo $page_title ?></title>
<script defer src="./scripts/viewpass.js"></script>

</head>

<body>
  <?php include 'includes/header.php';?>
    <i class="fa-solid fa-user fa-8x"></i>
  </header>
  <main>

    <!--Form that collect the user username and password before going to the home page -->

    <form id="loginin" name="login request" action="<?=htmlentities($_SERVER['PHP_SELF'])?>" method="POST" autocomplete="off">
      <div>
        <h2>Login</h2>
      </div>
      <div>
        <label for="username"> Username:</label>
        <input type="text" name="username" id="username" placeholder="Username" value="<?php echo $username?>">
      </div>

      <div>
        <label for="passwd">Password:</label>
        <input type="password" name="passwd" id="passwd" placeholder="Password " required>
        <i class="fa-solid fa-eye" id="togglePassword" style="margin-left: -20px; cursor: pointer;"></i>

      </div>

      <div>

          <span class="<?=!isset($errors['user']) ? 'hidden' : "";?>">*That user doesn't exist</span>
          <span class="<?=!isset($errors['login']) ? 'hidden' : "";?>">*Incorrect login info</span>
        </div>
        

      <!--check box that will make the system rememeber the user info  -->

      <div class="RM">
        <label for="rememberme"> Remember me</label>

        <input type="checkbox" name="rememberme" id="rememberme" value="R">
      </div>
      <!--  -->
        <div >
        <button type="submit" name="submit" id=submitlog> Log in</button>
      </div>
      <div class=logbuttons>
        <a href="register.php">Create Account</a>
        <a href="forgot.php">Forgot password</a>
      </div>

    </form>
    <?php include 'includes/footer.php';?>

</html>