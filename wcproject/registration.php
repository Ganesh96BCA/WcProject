<?php
    session_start();
    $title = "Registration";
    include 'header.php';
    include 'menu.php';
?>
<div class="container">
<h1>Registration</h1>
<form  method="POST" action="handle_registration.php"  enctype="multipart/form-data">
    <div class="container">
    <div class="row my-3">
        <div class="col-md-6">  
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control " id="name" name="name" placeholder="Enter Your Name..." required>
        </div>
        <div class="col-md-6">
            <label for="photo" class="form-label">Photo</label>
            <input type="file" class="form-control " id="photo" name="photo" required>
        </div>
       
        </div>
        <div class="row">
        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control " id="email" name="email" placeholder="Enter Your Email..." required>
        </div>
        <div class="col-md-6">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control " id="password" name="password" placeholder="Your Password..." required>
        </div>
        </div>
        <div class="row my-3">
        <div class="d-grid gap-2 d-md-block"><button class="btn btn-outline-primary" type="submit">Register</button></div>   
        </div>
    </div>
</form>
</div>
<?php
    include 'footer.php';
?>