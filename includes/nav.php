<main>
<script defer src="./scripts/nav.js"></script>
  <nav>
  <div id="mySidebar" class="sidebar">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="index.php">Home</a>
    <a href="search.php">Find books</a>
    <?php if (isset($_SESSION['username'])): ?>
      <a href="editaccount.php">My Account</a>
      <a href="logout.php">Log out</a>
      <a href="addbook.php">Add a new book</a>
    <?php else: ?>
      <a href="login.php">Log in</a>
      <a href="register.php"> Create Account</a>
    <?php endif; ?>
    </div>
  </nav>

<div id="main">
  <button class="openbtn" onclick="openNav()">&#9776; Open sidebar</button>
</div>
