<?php session_start(); ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">

    <a class="navbar-brand" href="index.php">MyWebsite</a>

    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">

        <?php if (!isset($_SESSION['user'])): ?>       
        <?php else: ?>
            <!-- Show only when logged in -->
            <li class="nav-item">
              <a class="nav-link" href="UserPage.php">My Account</a>
            </li>

            <li class="nav-item">
              <a class="nav-link text-danger" href="logout.php">Logout</a>
            </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>
