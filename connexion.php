<?php  

 try{
     
 $pdo= new PDO("mysql:host=localhost;dbname=ressource","root","");

 
 }
 catch(PDOException $e){
    echo "erreur:".$e->getMessage();
 }


?>