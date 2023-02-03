
<?php

session_start();

if(isset($_SESSION['user'])){

    if($_SESSION['user']->ROLE==="ADMIN"){

      // echo "welcome Magasignier ". $_SESSION['user']->IDEN;

    }else{
        header("location:http://localhost/designer/pages/index.php");
        die();
    }


}else{
    header("location:http://localhost/designer/pages/index.php");
}


    include "../connecte.php";

    if(isset($_GET['updateMat'])){
        session_start();

        $_SESSION['MatId']=$_GET['updateMat'];
        header("location:updateM.php");
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

    <title>Document</title>

    <style>
             .navbar{
        font-size:16px;
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }   
        .navbar-light .navbar-nav .nav-link{
        color: #000;
        transition: 0.4s ease;
    
    }
.navbar-light .navbar-nav .nav-link:hover{
    color:coral;
}
    </style>

</head>
<body>
    
<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Magasignier</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup" style="margin-left:60%" >
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="http://localhost/website/pages/magasinier/index.php">Home</a>

        <a class="nav-link" href="http://localhost/website/pages/magasinier/addmat.php">Add Materiel</a>
        <a class="nav-link" href="http://localhost/website/pages/magasinier/Materiel.php">Materiel</a>
       
      </div>
    </div>
  </div>
</nav> -->
   

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

    <!-- Table -->

    <section class="container " >
    <h2  class="p-2 mb-2 text-center bg-primary text-white mt-5 " >Liste des Materiels </h2>
   
    <table class="table mt-5">
                <thead>
                    <tr class="table-dark">
                    <th scope="col">idMateriel</th>
                    <th scope="col">MATERIEL</th>
                    <th scope="col">QUANTITE</th>
                    <th scope="col">DESCRIPTION</th>
                    <th scope="col">DATE</th>
                   
               
                    </tr>
                </thead>
                <tbody>

            <!-- Affichage des donnes  Materiel-->
            <?php
                
                    
                $todolist=$database->prepare("SELECT * FROM materiel");

                if($todolist->execute()){

                    foreach($todolist as $items){
               //         $idT=$items['idT'];
                        echo "<tr class='table-info' >
                       
                               <th scope='row' >".$items['idM']."</th>
                               <td scope='row'>".$items['MATERIEL']."</td>
                               <td scope='row'>".$items['QUANTITE']."</td>
                                <td scope='row'>".$items['DES']."</td>
                                <td scope='row'>".$items['DATE']."</td>

                                

                        </tr>";    
                    }

                }

       
       ?>

       </tbody>

    </table>

    </section>





    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>