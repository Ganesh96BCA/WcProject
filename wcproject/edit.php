<?php
    session_start();
    $title = "Edit";
    include 'header.php';
    include 'menu.php';
    $id=htmlentities($_GET['id']);
    require_once("conn.php");
    $req="SELECT * FROM users WHERE id=?";
    $ps=$pdo->prepare($req);
    $params=array($id);
    $ps->execute($params);
    $user=$ps->fetch();
?>

<div class="container">
<h1>Edit a user</h1>
<form  method="POST" action="update.php"  enctype="multipart/form-data">
    <div class="container">
    <div class="row">
    <div class="col-md-4">
            <label for="id" class="form-label">Id</label>
            <input type="text" class="form-control " id="id" name="id" value="<?= $user['id'] ?>"  readonly>
    </div>
    <div class="col-md-4">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control " id="name" name="name" value="<?= $user['name'] ?>"  required>
    </div>
    <div class="col-md-4">
            <label for="photo" class="form-label">Photo</label>
            <input type="file" class="form-control " id="photo" name="photo" required>
    </div>
       
        </div>
        <div class="row">
        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control " id="email" name="email" value="Enter Your Email..." required>
        </div>
        <div class="col-md-6">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control " id="password" name="password" placeholder="Your password..." required>
        </div>
        </div>
        <div class="row my-3">
        <div class="d-grid gap-2 d-md-block"><button class="btn btn-outline-primary" type="submit">Modify</button></div>   
        </div>
    </div>
</form>
</div>
<?php
    include 'footer.php';
?>