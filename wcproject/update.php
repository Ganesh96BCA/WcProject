<?php

$id =  htmlentities($_POST['id']);  
$name =  htmlentities($_POST['name']);  
$email =  htmlentities($_POST['email']);
$password = htmlentities($_POST['password']);
$photo=htmlentities($_FILES['photo']['name']);//get the name of the uploaded file
$fichierTemp=$_FILES['photo']['tmp_name'];//get the temporary filename of the file in which the uploaded file was stored on the server.
move_uploaded_file($fichierTemp,'./images/'.$photo);//move the uploaded file to the folder 'images' of your project 
$role = 1; // 1 for a simple user and 0 for a admin
$password = md5($password);//encrypt the password
require_once("conn.php");
$req="UPDATE users set name=?,email=?,pwd=?,photo=? where id=? ";
$ps=$pdo->prepare($req);
$params=array($name,$email,$password,$photo,$id);
$ps->execute($params);
header("location:listusers.php")

?>