
<?php 


include "../connecte.php";

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

    <title>Mesage | Reservation</title>
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

      
      <li class="nav-item">
          <a class="nav-link hover" href="http://localhost/designer/pages/admin/mat.php">Materiels</a>
        </li>
        </ul>
      <ul class="nav navbar-nav navbar-right">
      <form method="GET"> <button name="Logout"  style="border:none;background:transparent ;color:white">Déconnexion </button></form>

    </ul>
    </div>
  </div>
</nav>  

<!-- <nav class="navbar navbar-dark navbar-expand-lg bg-dark">
  <div class="container-fluid">
  <a class="navbar-brand" href="#">  </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link hover" aria-current="page" href="http://localhost/designer/pages/magasinier/index.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link hover" href="http://localhost/designer/pages/magasinier/materiel.php">Materiels</a>
        </li>
        <li class="nav-item">
          <a class="nav-link hover" href="http://localhost/designer/pages/magasinier/addNum.php"> Inventaires</a>
        </li>  
        <li class="nav-item">
          <a class="nav-link hover" href="http://localhost/designer/pages/tecket.php"> tickets</a>
        </li>

      </ul>
      <ul class="nav navbar-nav navbar-right">
      <form method="GET"> <button name="Logout"  style="border:none;background:transparent ;color:white">Déconnexion </button></form>

    </ul>
    </div>
  </div>
</nav> -->
<nav class="navbar navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img style="float:left" src="../../images/logo.png" alt="" width="" height="120">
      </a>
      <a class="navbar-brand" href="#">
Université Cadi Ayyad <br>
Faculté des Sciences Semlalia Marrakech <br>
Département d’Informatique

      </a>
      <a class="navbar-brand" href="#">
      <img style="float:right" src="../../images/logosem.png" alt="" width="" height="120">
      </a>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
</body>
</html>
<?php

    include '../connecte.php';

   

    if(isset( $_SESSION['ResId'])){

        $user = $database->prepare('SELECT * FROM reservation WHERE idR= :id');
        $user->bindParam("id",$_SESSION['ResId'] );
        $user->execute();
        $user = $user->fetchObject();

        echo ' <h3 class="text-center mt-5" > Ecrit Un message </h3>

        <form method="POST" class="container  mt-5 shadow p-3 mb-5 bg-body rounded" >
        
    
             <div class="form-floating ">
             <div class="p-2 fw-bold"> Message</div>
                <textarea class="form-control" placeholder="Votre message" name="messageadmin" value="'.$user->ETAT.'" id="floatingTextarea" required></textarea>
                <label for="floatingTextarea"></label>
            </div>
    <br>
            <button class="btn btn-primary p-2 w-100" type="submit" name="message_Reservation" value="'.$user->idR .'">Envoyer Message</button>

         
        </form>';

    }else{
        header("location:http://localhost/designer/pages/admin/index.php");
    }

    if(isset($_POST['message_Reservation'])){

        $updateR=$database->prepare("UPDATE reservation SET ETAT=:etat WHERE idR=:id");

        $updateR->bindParam("etat",$_POST['messageadmin']);
        $updateR->bindParam("id",$_SESSION['ResId']);
        
        if($updateR->execute()){
            echo "<script>alert(' message a Envoyer Avec Success')</script>";
            // header("Refresh:0 ;url=http://localhost/designer/pages/admin/index.php");

          

        }else{
            echo "<script>alert('error')</script>";
        }

    }


?>

