<?php 
try 
{
$strConnection='mysql:host=localhost;dbname=dbwebcentric';
$pdo=new PDO($strConnection,'root','root');

}catch (PDOException $e)
{
$msg='ERROR PDO ON '. $e->getMessage();
die($msg);
}
?>