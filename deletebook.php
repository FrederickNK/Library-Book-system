<?php
/****************************************
// ENSURES THE USER HAS ACTUALLY LOGGED IN
// IF NOT REDIRECT TO THE LOGIN PAGE HERE
 ******************************************/
session_start(); //start session
$errors = []; // initialize $errors array

if(!isset($_SESSION['username'])){
    //no user info, redirect
  header("Location:login.php");
  exit();
}
$username = $_SESSION['username'] ?? null;

include "includes/library.php";
$pdo = connectdb(); 

// Check if book ID is provided and exists in database
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
  
    $sql= "SELECT * FROM brownburry_books WHERE id = ?";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$book_id]);
    $book = $stmt->fetch();
      
    if (!$book) 
    { 
        $errors['nobook'] = true; 
    }
    else 
    {
        $title = $book['title'];
  
        $query = "SELECT * FROM brownburry_System_userCollection WHERE user = ? AND B_title = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username, $title]);
        $row = $stmt->fetch();

        if ($row) // check if $row is not empty
        {
            $proces_id = $row['process_id'];
            echo "$username $title $proces_id";

            $remove = "DELETE FROM `brownburry_System_userCollection` WHERE user = ? AND B_title = ?";
            $stmt = $pdo->prepare($remove);
            $stmt->execute([$username, $title]);
            $gone = $stmt->fetch();

            header("Location:index.php");
            exit();
        }
        else
        {
            header("Location:index.php");
        }
    }
}
else 
{
    $errors['noid'] = true; // set $errors array if book id is not provided
}

?>