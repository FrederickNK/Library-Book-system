<?php
session_start(); // start session

include "includes/library.php";
$errors = []; // initialize $errors array

if(!isset($_SESSION['username'])){
    //no user info, redirect
  header("Location:login.php");
  exit();
}
$pdo = connectdb(); 
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
  
    $sql= "SELECT * FROM brownburry_books WHERE id = ?";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$book_id]);
    $book = $stmt->fetch();
      
    if (!$book) 
    { 
        echo "Book not found.";
    }
    else 
    {
        $title = $book['title'];
        $author = $book['author'];
        $description = $book['Description'];
        $language = $book['language'];
        $Genre = $book['Genre'];
        $Publica = $book['Publication_date'];
        $ISBN = $book['ISBN'];
        $img = $book['img'];
        $rating =  $book['Rating'];

    }
}
?>

<!--Frederick Nkwonta _January 2023-->
<!--purpose: display all the details for a particular book-->
<!DOCTYPE html>
<html lang="en">
<script defer src="./scripts/bookdetails1.js"></script>

<head>
<?php
$page_title = "Details";
include 'includes/metadata.php';?>
</head>

<div id="book-details-modal" class="modal">
  <div class="modal-content">
    <p>
      <b>Title :</b> <?php echo $title ?><br>
      <b>Author :</b> <?php echo $author ?> <br>
      <b>Country : </b> United States <br>
      <b>Language : </b> <?php echo $language ?> <br>
      <b>Genre :</b> <?php echo $Genre ?><br>
      <b>Book Format : </b> Hardcover <br>
      <b>Publication date :</b> <?php echo $Publica ?><br>
      <b>ISBN :</b> <?php echo $ISBN ?> <br> <!--not the real isbn-->
      <b> rating: </b> <?php for ($i = 1; $i <= $rating; $i++) { ?><span class="fa fa-star"></span><?php } ?>
    </p>
  </div>
</div>
</body>

</html>