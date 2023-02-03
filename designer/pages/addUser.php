<?php

    include "connecte.php";
    //echo "<div class='p-3 mb-2 bg-info text-white container mt-3 fw-bold text-center' > Welcome en page addUser </div>";


    session_start();

    // liman3 lmostakhdimin 

    if(isset($_SESSION['user'])){

        if($_SESSION['user']->ROLE=== "ADMIN"){

            // $utilisateur="Welcome ".$_SESSION['user']->IDEN;

        }else{
            header("location:http://localhost/designer/pages/index.php");
            die();
        }


    }else{
        header("location:http://localhost/designer/pages/index.php");
    }



    if($database){
       // echo "connecte a la BD";
    }else{
        echo "non";
    }

    //validation de form

    if(isset($_POST['addUser'])){

        //pour Verifier que L'utilisateur  n'a pas dans la BD

        $checkidentifiant = $database->prepare("SELECT * FROM utilisateurs WHERE EMAIL=:email");
        $email = $_POST['email'];
        $checkidentifiant->bindParam("email", $email);
        $checkidentifiant->execute();

        if($checkidentifiant->rowCount()>0){

            echo '<div style="width:50% ;" class=" alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Error!</strong> ce compte est déja existe
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';

          header("Refresh:1");
          // sino 
        }else{


            $addUser=$database->prepare("INSERT INTO utilisateurs (IDEN,EMAIL,TELE,Password,ACTIVATED,ROLE) VALUE (:iden,:email,:tele,:password,:activated,:role)");

            $addUser->bindParam("iden",$_POST['iden']);
            $addUser->bindParam("email",$_POST['email']);
            $addUser->bindParam("tele",$_POST['tele']);
            $paswShifr= sha1($_POST['pass']);
            $addUser->bindParam("password",$paswShifr);
            $addUser->bindParam("activated",$_POST['activated']);
            $addUser->bindParam("role",$_POST['role']);
        
            if($addUser->execute()){

                echo '<script>alert("UUSER est Ajouter")</script>';
                header("location:addUser.php");
                
             
            }else{
                echo "<div> EROOOOR! </div>" ;
        
            }
                

      }
       
          
    }
    //logout
    if(isset($_GET['Logout'])){
        session_unset();
        session_destroy();
        header("location:http://localhost/designer/pages/index.php",true);
    }
  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>addUser</title>
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
          <a class="nav-link hover" aria-current="page" href="http://localhost/designer/pages/admin/index.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link hover" href="http://localhost/designer/pages/utilisateurs.php">Utilisateurs</a>
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
      <img style="float:left" src="../images/logo.png" alt="" width="" height="120">
      </a>
      <a class="navbar-brand" href="#">
Université Cadi Ayyad <br>
Faculté des Sciences Semlalia Marrakech <br>
Département d’Informatique

      </a>
      <a class="navbar-brand" href="#">
      <img style="float:right" src="../images/logosem.png" alt="" width="" height="120">
      </a>
  </div>
</nav>
<br><section class=" container" >
<h2  class="p-2 mb-2 text-center bg-primary text-white mt-5 " >Espaces utilisateurs</h2>
          <div style="line-height:10rem"></div>
        <div>
        <a  class="btn btn-primary " href="http://localhost/designer/pages/utilisateurs.php">Comptes en attente d'activation</a>
        <a  class="btn btn-primary " href="http://localhost/designer/pages/addUser.php">Ajouter un Utiliateur Ou Magasinier</a>
        <a  class="btn  "  href="http://localhost/designer/pages/admin/Search.php" >        <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" >
        <button class="btn btn-outline-success" type="submit" name="searchBtn">Search</button>
      </form></a>        


    </div>

    </section>




    <main  class="container mt-5 shadow p-3 mb-5 bg-body rounded border" >

    <form action="addUser.php" method="POST">

        <div class="form-group  mt-3">
            <label class="fw-bold" for="">Identifiant</label><input class="form-control" placeholder="Identifiant" type="text" name="iden" id="iden" required >
        </div>
        
        <div class="form-group  mt-3">
            <label class="fw-bold" for="">Email</label><input class="form-control" placeholder="email" type="email" name="email" id="email" required >
        </div>
        
        <div class="form-group  mt-3">
            <label class="fw-bold" for="">Téléphone</label><input class="form-control" placeholder="telephone"  type="text" name="tele" id="tele" required >
        </div>
        
        <div class="form-group mt-3">
            <label class="fw-bold" for="">mot de passe</label><input placeholder="mot de passe" class="form-control" type="password" name="pass" id="pass" required >
        </div>

        <select name="activated" class="form-select mt-3" required id="">
            <option selected value="1">Activer</option>
            <option value="0"> Annuler l'activation </option>

        </select>

        <select name="role" class="form-select mt-3" required id="">
            <option selected value="USER">Utilisateur</option>
            <option value="magasinier">Magasinier </option>

        </select>

        <div class="form-group mt-3">
            <button class="btn btn-primary p-2 w-100" type="submit" name="addUser" >Ajouter ce compte </button>
        </div>

        <!-- <div class="form-group mt-3">
            <label for="">ROLE</label><input class="form-control" type="text" name="iden" id="iden" required >
        </div> -->

        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
</body>
</html>