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
$errors = array(); //declare empty array to add errors too

include "includes/library.php";
$pdo = connectdb(); 


$username = $_SESSION['username'];
$userid = $_SESSION['userid'];

// Retrieve book title and author from form submission

$title = $_POST['bookTitle'] ?? null;
$author = $_POST['bookAuthor'] ?? null;
$genre = $_POST['genre'] ?? null;
$lang = "English";
$description = $_POST['Desc'] ?? null;
$publication_date = $_POST['pubdata'] ?? null;
$isbn = $_POST['isbn'] ?? null;
$format = $_POST['format'] ?? null;
$rating = $_POST['rate'] ?? null;
$img = $_POST ['bookcover']?? null;
$directory = 'img/'; // Path to the directory where the image is stored
$full_path = $directory . $img; // Full file path

if (isset($_POST['submit']))
{
    // Check if the book exists in the database

  $sql= "SELECT* from brownburry_books where title =? && author =?";
  $stmt=$pdo->prepare($sql);
  $stmt->execute([$title,$author]);
  $row = $stmt->fetch();
  // if the book doesn't exists in the database it adds it 
  if(!$row){
    $query = "INSERT into brownburry_books values (null,?,?,?,?,?,?,?,?,?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$title,$author,$description,$lang,$genre,$publication_date,$rating,$isbn,$full_path]);
    $Nrow = $stmt->fetch();

    $sql= "SELECT* from brownburry_books where title =? && author =?";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$title,$author]);
    $row = $stmt->fetch();
    }
  
    if($row || $Nrow) {
    
      $book_id = $row['id'];
    // Check if the user has already added this book to their collection
     $vaild= "SELECT* from brownburry_System_userCollection where user =? && B_title =?";
     $stmt=$pdo->prepare($vaild);
     $stmt->execute([$username,$title]);
     $finds = $stmt->fetch();


     if($finds > 0){
        // Add error flag if user has already added this book to their collection

     // $errors['user'] = true; 
      } 
    else { 
       // Insert book into user's collection

      $query = "INSERT into brownburry_System_userCollection values (null,?,?,?)";
      $stmt = $pdo->prepare($query);
      $stmt->execute([$username,$title,$book_id]);
      
      header("Location:index.php");
      exit();

      }
  }
}


?>


<!--Frederick Nkwonta _January 2023-->
<!--purpose to allow the user to enter details about a new book so it can be added to the user collection-->
<!DOCTYPE html>
<html lang="en">

<head>
<?php

include 'includes/metadata.php';?>
<title> Add book </title>
<script defer src="./scripts/addbookV.js"></script>

</head>

<body>
  <?php include 'includes/header.php';?>
    <i class="fa-solid fa-book fa-8x"></i>
  </header>
  <?php include 'includes/nav.php';?>

    <!--form that adds books to the user collection once the  book title, author and format are either typed in or selected -->
    <form name="Addbook" id="Addbook_user" action="<?=htmlentities($_SERVER['PHP_SELF']);?>" method="post" autocomplete="on">
      <div class="bookdetail1">
        <!--prompt user for book title-->
        <div>
          <label for="bookTitle">Book Title </label>
          <input type="text" name="bookTitle" id="bookTitle" placeholder="Title" spellcheck="true" >
          <span class="error <?=isset($errors['bookT']) ? '' : "hidden";?>">Please enter a title</span>
        </div>

        <!--prompt user for book author-->
        <div>
          <label for="bookAuthor"> Author </label>
          <input type="text" name="bookAuthor" id="bookAuthor" placeholder="Author" spellcheck="true" >
          <span class="error <?=isset($errors['author']) ? '' : "hidden";?>">Please enter an Author's Name</span>
        </div>

        <!--prompt user for book rating-->

        <div> <label for="rating">Rating</label></div>
          <div class="rate">
            <input type="radio" id="star5" name="rate" value="5" />
            <label for="star5" title="text">5 stars</label>
            <input type="radio" id="star4" name="rate" value="4" />
            <label for="star4" title="text">4 stars</label>
            <input type="radio" id="star3" name="rate" value="3" />
            <label for="star3" title="text">3 stars</label>
            <input type="radio" id="star2" name="rate" value="2" />
            <label for="star2" title="text">2 stars</label>
            <input type="radio" id="star1" name="rate" value="1" />
            <label for="star1" title="text">1 star</label>
            <input type="radio" id="star0" name="rate" value="0" checked />
            <label for="star0" style="display:none">No rating</label>
         </div>

        <!--display different pre define genre user for user to select -->

        <div>
          <label for="genre">Genre:</label>
          <select name="genre" id="genre">
            <option value="">Choose One</option>
            <option value="drama">Drama</option>
            <option value="fantasy">Fantasy</option>
            <option value="fiction">Fiction</option>
            <option value="folklore">Folklore</option>
            <option value="classics">Classics</option>
          </select>
        </div>

        <!--Allow user to give description of the book-->
        <div>
          <label for="Desc"> Description</label>
          <textarea name="Desc" id="Desc" cols="30" rows="10" spellcheck="true"></textarea>
        </div>


        <!--prompts user for Publication Date -->
        <div>
          <label for="pubdata">Publication Date</label>
          <input type="date" name="pubdata" id="pubdata" >
          <span class="error <?=isset($errors['nopubdata']) ? '' : "hidden";?>"> Please select a date</span>

        </div>


        <!--prompts user for ISBN -->
        <div>
          <label for="isbn">ISBN</label>
          <input type="text" name="isbn" id="isbn" placeholder="ISBN" maxlength="13">
          <span class="error <?=isset($errors['lsbn']) ? '' : "hidden";?>">Please enter the ISBN 
        </span>

        </div>

        <!--displays book format and gives user option to pick from -->
        <div>
          <label for="format">Book Format</label>
          <select name="format" id="format" >
            <option value="">Choose one</option>
            <option value="HC">Hardcover</option>
            <option value="PB">Paperback</option>
            <option value="EPub">EPub</option>
            <option value="MB">Mobi</option>
            <option value="PF">PDF</option>
            <option value="AB">Audio Books</option>

          </select>
        </div>

      </div>


    <div class="detailbook2">
      <!--prompt user for book cover  -->
      <div>
        <label for="bookcover">Browse for Book cover:</label>
        <input type="file" name="bookcover" id="bookcover">
      </div>

      <!--prompt user for book cover via url  -->
      <div>
        <label for="urlcover">Url for Book cover:</label>
        <input type="url" name="urlcover" id="urlcover">
      </div>

      <!--prompt user for book cover via url  -->
      <div>
        <label for="ebookfile">Browse for eBook File:</label>
        <input type="file" name="ebookfile" id="ebookfile">
      </div>

      <!--clear the form  -->
      <div>
        <button type="reset" id="Clear"> Clear form</button>
      </div>

      <!--sents the infor  -->
      <div>
        <button type="submit" name="submit" id="addbook">Add book</button>
      </div>
    </div>
    </form>

    <?php include 'includes/footer.php';?>


</html>