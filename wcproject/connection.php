<?php
session_start();
    $title = "Connection";
    include 'header.php';
    include 'menu.php';
?>
<div class="container">
<h1>Login</h1>
   <!-- <p>To be done...
  <br>
  1. Get the email and the password from a <i>Form</i> (you can take it from: <a target="_blank" href="https://getbootstrap.com/docs/5.3/forms/overview/">Exemple of a Form getBootstrap website  </a>).
  <br>
  2. Fill the attributs <i>method ( POST, GET ????)</i>, <i>action (name of the script)</i> and <i>enctype</i>(see <a target="_blank" href="https://www.w3schools.com/tags/att_form_enctype.asp">enctype values)</a> 
  <br>
  3. prepare an sql request with the email and the <i>hashed</i> password.
  <br>
  4. If a  <i>row</i> result exist then sent the <i>row</i> result through <i>$_SESSION</i> array to another page named "UserPage.php".
  <br>
  5. The  "UserPage.php" contains a message "Hi"+the name of the user and in the navbar hide the "connection" and the "registrartion" option and display only "logout" option.
  <br>
  6. If the user does not belong the registred users or the password is wrong then send the message "wrong Login or password " and rediredt to the connection.php page. 

</p>-->

 <?php  
// Show error message if exists
 if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>".$_SESSION['error']."</div>";
    unset($_SESSION['error']);
}
?>

<form method="POST" action="login.php" enctype="application/x-www-form-urlencoded">

  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>

  <button type="submit" class="btn btn-primary">Login</button>

</form>


</div>
<?php
    include 'footer.php';
?>