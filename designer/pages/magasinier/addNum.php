
<?php
session_start();
    include "../connecte.php";

    // add Num inventaires

    if(isset($_POST['add_Num'])){

        $getnum= $database->prepare("SELECT * FROM numinvent WHERE NUMERO=:num OR NAME=:name ");

        $getnum->bindParam("num",$_POST['num']);
        $getnum->bindParam("name",$_POST['name']);

        $getnum->execute();

        if($getnum->rowCount()>0){
            echo '<div class=" success alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
            <div>
                Le numero Name Déja Existe, Saisir un numero ou name différent!
            </div>
          </div>';
          header("Refresh:1");
        }

        else{

            // idM : la clé de materiel pour faire jointure 

            $getIdm= $database->prepare("SELECT * FROM materiel WHERE MATERIEL= :mat");
            $getIdm->bindParam("mat",$_POST['mat']);
            $getIdm->execute();
            $getIdm=$getIdm->fetchObject();
            $UserM =$getIdm->idM;

            $addNum= $database->prepare("INSERT INTO numinvent (UserM,MATERIEL,NAME,NUMERO) VALUES (:UserM,:mat,:name,:numero)");

            $addNum->bindParam("UserM",$UserM);
            $addNum->bindParam("mat",$_POST['mat']);
            $addNum->bindParam("name",$_POST['name']);
            $addNum->bindParam("numero",$_POST['num']);
    
            if($addNum->execute()){
                echo '<div class=" success alert alert-primary d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                <div>
                    Le numero est Ajouter avec success
                </div>
              </div>';
              header("Refresh:1");
        
            }else{
                echo "errrrrrrrrrrrrrrrrrrrrroor";
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

    <title>Add Num</title>

    <style>
        .adddNum{
            margin-top: 110px;
        }
        .success{
           position: absolute;
           top:15%;
           width:77%;
        }
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

<nav class="navbar navbar-dark navbar-expand-lg bg-dark">
  <div class="container-fluid">
  <a class="navbar-brand" href="#">  <?php echo  $_SESSION['user']->IDEN; ?></a>
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
<div class="container">
<h2  class="p-2 mb-2 text-center bg-primary text-white mt-5 " >Ajouter les numeros d'inventaires </h2>
</div>
    <div class="adddNum container mt-5">
    <form method="POST"> 
    <div class="form-group p-2 ">
              <label for="">Choisir un materiel</label>
                 <select class="form-select" name="mat" id="" >

                         <?php
                        $getMateriel=$database->prepare("SELECT * FROM materiel");
                                  
                         $getMateriel->execute();
                                    // jalb tous les materiels
                         foreach($getMateriel as $mat ){

                          echo'<option > '.$mat["MATERIEL"].'</option>';
                         }

                         ?>
                    </select>
          </div>

        <div class="form-group p-2">
            <label for="">Nom du Materiel</label>
            <input type="text" class="form-control" name="name"  placeholder="nom du Materiel" required >
        </div>

           
        <div class="form-group p-2">
        <label for="">Numero d'Inventaire</label>
            <input type="text" class="form-control" name="num" placeholder="numero d'inventaire" required>
        </div>
        <button class="btn btn-primary p-2 w-100" name="add_Num" type="submit" >Ajouter</button>
     </form>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>