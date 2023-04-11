<?php
session_start();

@$salaire= ($_POST['salaire']);
@$busnes=($_POST['busnes']);
@$loyer=( $_POST['loyer']);
@$manger=($_POST['manger']);
@$trans=($_POST['trans']);
@$autre=($_POST['autre']);
@$valider=$_POST['valider'];
@$msg="";
if(isset($valider)){

    include('connexion.php');
    $ins=$pdo->prepare("insert into gestion(date,salaire,busness,loyer,manger,transport,autres,date) values(now(),?,?,?,?,?,?)");
    $ins->execute(array($salaire,$busnes,$loyer,$manger,$trans,$autre));
    $revenu= $pdo->prepare("SELECT SUM(salaire)+SUM(busness) FROM gestion");
    $revenu->execute();
    $depense = $pdo->prepare("SELECT SUM(loyer)+SUM(manger)+SUM(transport)+SUM(autres) FROM gestion");
    
    $depense->execute();
    $r = $revenu->fetchAll(PDO::FETCH_NUM);
    $d = $depense->fetchAll(PDO::FETCH_NUM);
    $t=$r[0][0]+$d[0][0];
    $pr=($r[0][0]/$t)*100;
    $pd=($d[0][0]/$t)*100;
   
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



?>
<!Doctype html>
<html>
    <head>
        <metacharset="utf-8">
        <style>
            *{

                font-size:30px;
                font-family:titillium;
                background:url("back.jpg");

            }
            body{
                margin:opx;
               
            }
          section{
            display:flex;
            align-items:center;
            heignt:100hv;
            justify-content:center;
            background-size:cover;
            background: url("auto.jpg");
          }
          form{
            
            background-color:white;
            padding: 150px;
            border-radius :25px;

          }
          input{
            display:block;
            width: 120px;
            outline:none;
            margin: auto;
            box-sizing:border-box;
          }
          input[type="submit"]{
                cursor:pointer;
                background-color:green;
              }
         .c{
          margin-left:1000px;
          text-decoration:none;
          background-color:yellow;
          font-size:15px;
          
         }
         a:hover{
          color:red;
         }
          
        </style>
    </head>

<body>

  <FIeldset>
   
        <legend style="text-align:center"></legend>
    <section id="id">
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
        
<label for="id" >Repense<label>    
<progress id="id" value="<?= $pr ?>" max="100"> $pb</progress><br>
<label for="il" color="green">Depence</label> 
<progress  id="il" value="<?= $pd ?>" max="100"></progress>  
</form>
</section>
</FIeldset>

</body>

<?php 
  if(isset($valider)){
            if(!empty($msg)) {?>
            <div id2="id2" style="background-color:green"><?= $msg?> </div>
 
<?php } } ?>

</html>






