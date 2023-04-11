<?php
session_start();
//recuperationdes donnee
@$salaire= ($_POST['salaire']);
@$busnes=($_POST['busnes']);
@$loyer=( $_POST['loyer']);
@$manger=($_POST['manger']);
@$trans=($_POST['trans']);
@$autre=($_POST['autre']);
@$valider=$_POST['valider'];
@$msg="";
//controle de saisi
if(isset($valider)){
     if($salaire<0)$msg="<li>nombre invalide</li>"."<br/>";
     if($busnes) $msg.="<li>nombre invalide</li>"."<br/>";
     if($loyer) $msg.="<li>nombre invalide</li>"."<br/>";
     if($manger) $msg.="<li>nombre invalide</li>"."<br/>";
     if($autre) $msg.="<li>nombre invalide</li>"."<br/>";
     if($trans) $msg.="<li>nombre invalide</li>"."<br/>";
     if($msg){  

        //connexion du base de donnee et rattrapage des erreur
  
      try{
     
    $pdo= new PDO("mysql:host=localhost;dbname=ressource","root","");
          }
    catch(PDOException $e){
       echo "erreur:".$e->getMessage();
    }
       //manipulation des donnee
   
    $ins=$pdo->prepare("insert into gestion(date,salaire,busness,loyer,manger,transport,autres,date) values(now(),?,?,?,?,?,?)");
    $ins->execute(array($salaire,$busnes,$loyer,$manger,$trans,$autre));
    $revenu= $pdo->prepare("SELECT SUM(salaire)+SUM(busness) FROM gestion");
    $revenu->execute();
    $depense = $pdo->prepare("SELECT SUM(loyer)+SUM(manger)+SUM(transport)+SUM(autres) FROM gestion");
    
    $depense->execute();
    $r = $revenu->fetchAll(PDO::FETCH_NUM);
    $d = $depense->fetchAll(PDO::FETCH_NUM);
    //test des resultats
    $resultat=$r[0][0]-$d[0][0];
     if( $resultat>0){
        $msg="Votre revenu est superieur a votre depense avec une ecart de ".$resultat;
     }elseif( $resultat<0){
      $msg="Votre depense est superieur a votre revenu avec une ecart de ".$resultat;
     }
     elseif($resultat=0){
      $msg="Votre depense est egal a votre revenu avec une ecart de ".$resultat;
     }
   }
}


?>
<!Doctype html>
<html>
    <head>
        <metacharset="utf-8">
      
       
     
    </head>

<body>

  <FIeldset>
   
        <legend style="text-align:center"></legend>
    
<form method="POST" action="">
    <table border=1>
        <tr>
            <td>Revenu</td>
            <td>Depense</td>
        </tr>
           <tr>
            <td><input type="text"  classe="cl"name="salaire" placeholder="salaire " ></td>
            <td><input type="text"  classe="cl"name="busnes" placeholder="BUSNES"></td>
        </tr>
           <tr> 
             <td><input type="text"  classe="cl"name="loyer" placeholder="LOYER"></td>
             <td><input type="text"  classe="cl"name="manger" placeholder="MANGER"></td>
             <tr>
             <td> <input type="number" min="1" classe="cl"name="trans" placeholder="TRANSPORT"></td>
             <td> <input type="number" min="1" classe="cl"name="autre" placeholder="AUTRES"></td>
             </tr>
        </tr>
    </table>
     <input type="submit" name="valider" value="VALIDER"  placeholder="VALIDER">
        
</form>
</FIeldset>

</body>

<?php 
  if(isset($valider)){
            if(!empty($msg)) {?>
            <div id2="id2" style="background-color:green"><?= $msg?> </div>
 
<?php } } ?>

</html>






