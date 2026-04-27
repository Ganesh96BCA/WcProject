<?php
    session_start();//for messages
    $title = "Welcome";
    include 'header.php';
    include 'menu.php';
    include 'Carousel.php';
?>


<div class="container">

 <!-- if a message was sent by another page Display it-->
<?php
    if(isset($_SESSION['message'])) {
       
 ?>       
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <?=$_SESSION['message']?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    
 <!-- remove the received a message -->       
    <?php  
        unset($_SESSION['message']);
       
    }
    ?>
        
    </div>
<?php
    include 'footer.php';
?>