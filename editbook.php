<?php
session_start();

// Redirect to login page if user not logged in
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

$username = $_SESSION['username'];
$errors = array(); //declare empty array to add errors too

// Import necessary functions and establish database connection
require_once 'includes/library.php';
$pdo = connectDB();

// Check if book ID is provided and exists in database
$C_Title ="" ;
$C_author ="";
$C_Descr ="";
if (isset($_GET['id'])) {
  
    $book_id = $_GET['id'];

  $sql = "SELECT * FROM brownburry_books WHERE id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$book_id]);
  $book = $stmt->fetch();

  //  if book ID is not found
  if (!$book) {
    $errors['nobook'] = true;
  }

  $_SESSION['bookid'] = $book['id'];
  $C_Title = $book['title'];
  $C_author = $book['author'];
  $C_Descr = $book['Description'];

  
  $uservalid = "SELECT * FROM brownburry_System_userCollection WHERE user = ? AND B_title = ? ";
  $stmt = $pdo->prepare($uservalid);
  $stmt->execute([$username,$C_Title]);
  $valid = $stmt->fetch();

  if (!$valid) {
      header("Location:index.php");
      exit();
    }
}
 // Get updated book information from form

  $N_title = $_POST['title'] ?? null;
  $N_author = $_POST['author'] ?? null;
  $N_Desc = $_POST['description'] ?? null;
    

  if (isset($_POST['submit']))
  {
        // Check if new book title already exists in database

    $sql = "SELECT * FROM brownburry_books WHERE title = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$N_title]);
    $book = $stmt->fetch();

    //  if book title not found
    if (!$book) {
        $errors['nobook'] = true; 
        $N_title = $_POST['title'] ?? null;
        $N_author = $_POST['author'] ?? null;
        $N_Desc = $_POST['description'] ?? null;
      }
    
    if (count($errors) === 0) {
    $N_id = $book['id'];
        // Update book information in user's collection

    $updater = "UPDATE brownburry_System_userCollection set B_title=?, book_id=? where user=? AND book_id=?";
    $stmt = $pdo->prepare($updater);
    $stmt->execute([$N_title,$N_id,$username,$_SESSION['bookid']]);
    $C_Title = $N_title;
    $C_author = $N_author;
    $C_Descr = $N_Desc;
    $_SESSION['bookid'] = $N_id;
    header("Location:index.php");
      exit();
    }
  }

?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Book - Brownburry Book System</title>
  <?php include 'includes/metadata.php'; ?>
</head>
<body>
  <?php include 'includes/header.php';?>
    <h2>Hello, <?php echo $_SESSION['username']; ?>!</h2>
  </header>

  <?php include 'includes/nav.php'; ?>

  <h2>Edit Book</h2>

  <form action="<?=htmlentities($_SERVER['PHP_SELF'])?>" method="POST" autocomplete="off">
    <div>
    <label for="title">Title:</label>
    <input type="text" name="title" value="<?php echo $C_Title ?>" >
    <span class="error <?=isset($errors['nobook']) ? '' : "hidden";?>">No book by that title in our database</span>

    </div>
    <div>
    <label for="author">Author:</label>
    <input type="text" name="author" value="<?php echo $C_author ?>" >
    </div>
    <div>
    <label for="description">Description:</label>
    <textarea name="description" cols= "30" rows="10"><?php echo $C_Descr ?> </textarea>
    </div>
    <div>
    <label for="image">Cover Image:</label>
    <input type="file" name="image">
    </div>

    <div >
        <button type="submit" name="submit" id=submitlog> Save Changes</button>
      </div>
  </form>

 
