<?php

session_start(); //start session


require "includes/library.php";

// CONNECT TO DATABASE
$pdo = connectDB();
if (!isset($_SESSION['username'])) {
    $username = "Guest";
  }
  else 
  {
    $username = $_SESSION['username']; 
  }
//$query = "SELECT id, title, author,Description, img  FROM `brownburry_books`";
//$stmt = $pdo->query($query);
$query = "SELECT b.id, b.title, b.author, b.Description, b.img FROM brownburry_books b JOIN brownburry_System_userCollection ub ON b.id = ub.book_id WHERE ub.user = ?";
$stmt=$pdo->prepare($query);
$stmt->execute([$username]);
$image_path ;

?>
<!--Frederick Nkwonta _January 2023-->
<!--purpose: display all the books in the user's collection.-->
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$page_title = "Index";
include 'includes/metadata.php';
?>
<title> <?php echo $page_title ?></title>
<script defer src="./scripts/deletebook.js"></script>
<script defer src="./scripts/bookdetails.js"></script>
</head>

<body>
    <?php include 'includes/header.php';?>

        <i class="fa-solid fa-house-chimney fa-8x"></i>

        <?php include 'includes/header_b.php';?>
    
        <!-- find book take you to the search page -->
        
        <?php include 'includes/nav.php';?>

        <h2> Your Collection</h2>

        <!-- use to sort book by pre defined options -->
        <div>
            <label for="sortby">Sort by:</label>
            <select name="booksort" id="sortby" required>
                <option value="">Choose one</option>
                <option value="title">Title</option>
                <option value="year">Year</option>
                <option value="rating">Rating</option>
                <option value="booknumber">Book Number</option>
                <option value="dateadded">Date Added</option>
            </select>
        </div>

         <!-- if the user has more than 25 on the present allow you to go forward to see more pages -->
         <div>
            <a href="#" class="previous"> &laquo; Previous</a>
            <a href="#" class="next"> Next &raquo;</a>
        </div>

      <section>

        <?php foreach ($stmt as $row):  ?>
           <!-- Generate the HTML code for the book -->
           <div>
            <?php $image_path = $row['img'] ?>
            <?php $id = $row['id'] ?>

           <img src="<?php echo $image_path ?>" alt = "<?php echo $row['title'] ?>" width="180" height="230">
           <p><?php echo $row['title'] ?> <br> <?php echo $row['author'] ?> <br> </p>
            
            
             <a href="deletebook.php?id=<?php echo $id ?>"> Delete </a> 
             <a href="editbook.php?id=<?php echo $id ?>"> Edit Book</a> 
             <a href="details.php?id=<?php echo $id ?>"> Book details</a> 

           
        </div>

        <?php endforeach?>
   
        
      </section>

    <?php include 'includes/footer.php';?>



</html>