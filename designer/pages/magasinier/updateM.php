<?php

session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Update Materiel</title>
</head>
<body>
    
<nav class="navbar navbar-dark navbar-expand-lg bg-dark">
  <div class="container-fluid">
  <a class="navbar-brand" href="#">  <?php echo  $_SESSION['user']->IDEN; ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link hover" aria-current="page" href="http://localhost/website/pages/magasinier/index.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link hover" href="http://localhost/website/pages/magasinier/materiel.php">Materiels</a>
        </li>
        <li class="nav-item">
          <a class="nav-link hover" href="http://localhost/website/pages/magasinier/addNum.php"> Inventaires</a>
        </li>  
        <li class="nav-item">
          <a class="nav-link hover" href="http://localhost/website/pages/tecket.php"> tickets</a>
        </li>

      </ul>
      <ul class="nav navbar-nav navbar-right">
      <form method="GET"> <button name="Logout"  style="border:none;background:transparent ;color:white">Déconnexion </button></form>

    </ul>
    </div>
  </div>
</nav> 
<nav class="navbar navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img style="float:left" src="/website/images/logo.png" alt="" width="" height="120">
      </a>
      <a class="navbar-brand" href="#">
Université Cadi Ayyad <br>
Faculté des Sciences Semlalia Marrakech <br>
Département d’Informatique

      </a>
      <a class="navbar-brand" href="#">
      <img style="float:right" src="/website/images/logosem.png" alt="" width="" height="120">
      </a>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
</body>
</html>
<?php


   
    include "../connecte.php";

   

    if(isset($_SESSION['user'])){

        if($_SESSION['user']->ROLE==="magasinier"){

          // echo "welcome Magasignier ". $_SESSION['user']->IDEN;

        }else{
            header("location:http://localhost/website/pages/index.php");
            die();
        }


    }else{
        header("location:http://localhost/website/pages/index.php");
    }



   if(isset($_SESSION['MatId'])){

        $user = $database->prepare('SELECT * FROM materiel WHERE idM= :id');
        $user->bindParam("id",$_SESSION['MatId']);
        $user->execute();
        $user = $user->fetchObject();

    echo '    <div class="container"> <h2  class="p-2 mb-2 text-center bg-primary text-white mt-5 " >Modifier le Materiel </h2></div>


    <form method="POST" class="container  mt-5  shadow p-3 mb-5 bg-body rounded" >
    
        <div class="p-2 fw-bold">Nom Materiel </div>
        <input class="form-control" type="text" name="Materiel" value="'.$user->MATERIEL.'" placeholder="nome Materiel" required >

        <div class="p-2 fw-bold">Quantite </div>
        <input class="form-control" type="number" name="Quantite" value="'.$user->QUANTITE.'" placeholder="Quantite" required >

        <div class="p-2 fw-bold">Description </div>
        <input class="form-control" type="text" name="Des" value="'.$user->DES.'" placeholder="description" required >

        <div class="p-2 fw-bold">  Date</div>
        <input class="form-control" type="date" name="date" value="'.$user->DATE.'" placeholder="date"  required >

        <button class="btn btn-primary p-2 w-100" type="submit" name="update" value="'.$user->idM .'">Enregistrer</button>
     
    </form>';

    if(isset($_POST['update'])){
        $updateM= $database->prepare("UPDATE materiel SET MATERIEL=:mat, QUANTITE=:Quan, DES=:des,	DATE=:date WHERE idM=:id");

        $updateM->bindParam("mat",$_POST['Materiel']);
        $updateM->bindParam("Quan",$_POST['Quantite']);
        $updateM->bindParam("des",$_POST['Des']);
        $updateM->bindParam("date",$_POST['date']);
        $updateM->bindParam("id",$_SESSION['MatId']);
        
        if($updateM->execute()){
            echo "<script>alert('update avec success')</script>";
            header("Refresh:0; url=Materiel.php");
        }else{
            echo "<script>alert('error')</script>";   
        }

    }

   }else{
       header("location:http://localhost/website/pages/index.php");
   }

?>