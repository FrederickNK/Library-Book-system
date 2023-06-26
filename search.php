<?php
/****************************************
// ENSURES THE USER HAS ACTUALLY LOGGED IN
// IF NOT REDIRECT TO THE LOGIN PAGE HERE
 ******************************************/
session_start(); //start session


$Search = $_POST['searchb'] ?? null;
$searchType = $_POST['searchType']?? null;

$errors = array(); //declare empty array to add errors too

include "includes/library.php";
$pdo = connectdb(); 


//Check if the form has been submitted

if (isset($_POST['submit']))
{   //Check if the search term and search type have been provided

  if ($Search == null && $searchType == null || isset($Search) && $searchType == null ) 
  {
  
    $errors ['nobook'] = true;
  }
    //Perform search based on the selected search type

  if (isset($_POST['searchType'])) {

    //Search for books by title

    if ($searchType == "T") 
    {
    $T= "SELECT id,img,title,author,ISBN from brownburry_books where title =?";
    $stmt=$pdo->prepare($T);
    $stmt->execute([$Search]);
    $new = $stmt->fetchAll();

    if (!$new ) 
    {
      $errors ['noTitle'] = true;
    }
    }

     //Search for books by ISBN
    if ($searchType == "I") 
    {
    $I= "SELECT id,img,title,author,ISBN from brownburry_books where ISBN =?";
    $stmt=$pdo->prepare($I);
    $stmt->execute([$Search]);
    $new = $stmt->fetchAll();

    if (!$new ) 
  {
  
    $errors ['noISBN'] = true;
  }
    }
    
   
     //Search for books by author

    if ($searchType == "A" )
    {
    $A= "SELECT id,img,title ,author,ISBN from brownburry_books where author =?";
    $stmt=$pdo->prepare($A);
    $stmt->execute([$Search]);
    $new = $stmt->fetchAll();
    if (!$new ) 
  {
    $errors ['noAuthor'] = true;
  }
    }
   
  } 
}

?>



<!--Frederick Nkwonta _January 2023-->
<!--purpose: allowing the user to specify what to search for-->
<!DOCTYPE html>
<html lang="en">

<head>
<title> Search page </title>
<?php
include 'includes/metadata.php';
?>
</head>

<body>
  
    <?php include 'includes/header.php';?>

    <i class="fa-solid fa-magnifying-glass fa-7x"></i>
    <h2>Book search</h2>
  </header>

  <?php include 'includes/nav.php';?>

    <form id="search" name="search" action="<?=htmlentities($_SERVER['PHP_SELF'])?>" method="POST" autocomplete="off">

      <div>
        <label for="searchb">Search : </label>
        <input type="text" id="searchb" name="searchb" placeholder="Robert Greene">
      </div>

      <fieldset>
        <legend> Search For </legend>

        <div>
          <input type="radio" name="searchType" id="Author" value="A">
          <label for="Author">Author</label>
        </div>

        <div>
          <input type="radio" name="searchType" id="Title" value="T">
          <label for="Title">Title</label>
        </div>

        <div>
          <input type="radio" name="searchType" id="ISBN" value="I">
          <label for="ISBN">ISBN</label>
        </div>

      </fieldset>

      <button type="submit" name ="submit"  id="findbook"> Go</button>

    </form>

    <section>
  <h5> Search Results : 
  <!-- displays errors   -->
  <span class="error <?=isset($errors['nobook']) ? '' : "hidden";?>">  please select an option for sort by </span> 
  <span class="error <?=isset($errors['noTitle']) ? '' : "hidden";?>">  There is no book by that title  </span>
  <span class="error <?=isset($errors['noAuthor']) ? '' : "hidden";?>">  There is no book by that Author  </span>
  <span class="error <?=isset($errors['noISBN']) ? '' : "hidden";?>">  There is no book has that ISBN  </span>
  </h5>

  <?php if (count($errors) === 0) : ?> 
    <?php if(isset($_POST['submit']) && $new != 1 ): ?>
      
      <?php// display book searched and buttons  ?>

      <?php foreach ($new as $row):  ?>
        <?php $image_path = $row['img'] ?>
        <?php $id = $row['id'] ?>
        <div>  
           <img src="<?php echo $image_path ?>" alt = "<?php echo $row['title'] ?>" width="180" height="230">
           <p><?php echo $row['title'] ?> <br> <?php echo $row['author'] ?> <br> </p>
          <a href="deletebook.php?id=<?php echo $id ?>"> Delete </a> 
          <a href="editbook.php?id=<?php echo $id ?>"> Edit Book</a> 
          <a href="details.php?id=<?php echo $id ?>"> Book details</a> 
        </div>
      <?php endforeach ?>
    <?php endif ?>
  <?php endif ?>
  
</section>

    <?php include 'includes/footer.php';?>

</html>