<?php
/****************************************
// ENSURES THE USER HAS ACTUALLY LOGGED IN
// IF NOT REDIRECT TO THE LOGIN PAGE HERE
 ******************************************/
session_start(); //start session
  //check session for whatever user info was stored
if(!isset($_SESSION['username'])){
    //no user info, redirect
  header("Location:login.php");
  exit();
}
$Cusername = $_SESSION['username'] ?? null;

include "includes/library.php";
 
$pdo = connectdb(); 

// if post submitted 


  // delete user account 
  $sql= "DELETE FROM brownburry_Book_System WHERE username=?";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$Cusername]);
    $row = $stmt->fetch();

    // destroy the session
    session_destroy();
    header("Location:login.php");
    exit();
   

?>
