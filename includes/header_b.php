
<?php if(!isset($_SESSION['username'])): ?>
    
<h2>Hello, Guest!</h2>

<?php endif ?>

<?php if(isset($_SESSION['username'])): ?>

    
    <h2>Hello, <?php echo htmlentities($_SESSION['username']) ?>!</h2> 
    
<?php endif ?>

</header>