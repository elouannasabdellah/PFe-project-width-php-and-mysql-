
<?php

    session_start();

if(isset($_SESSION['user'])){

    if($_SESSION['user']->ROLE==="magasinier"){

      // echo "welcome Magasignier ". $_SESSION['user']->IDEN;

    }else{
        header("location:http://localhost/designer/pages/index.php");
        die();
    }


}else{
    header("location:http://localhost/designer/pages/index.php");
}

    include "../connecte.php";

    if(isset($_POST['sav_mat'])){

        $addMat= $database->prepare("INSERT INTO materiel(MATERIEL,QUANTITE,DES,DATE) VALUES(:mat,:Quan,:des,:date) ");

        $addMat->bindParam("mat",$_POST['Materiel']);
        $addMat->bindParam("Quan",$_POST['Quantite']);
        $addMat->bindParam("des",$_POST['des']);
        $addMat->bindParam("date",$_POST['date']);

        if($addMat->execute()){

           echo  '<div class=" success alert alert-primary text-center w-75 mx-auto" role="alert">
                Le Materiel est Ajouter avec Sucsess!
         </div>';
         header("Refresh:0; url=Materiel.php");
        


        }else{
            echo '<script>alert("errror")</script>';
        }
        
    }
 

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
    <title>ADD MATERIEL</title>

    <style>
          .adddNum{
            margin-top: 100px;
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
      <form method="GET"> <button name="Logout"  style="border:none;background:transparent ;color:white">D??connexion </button></form>

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
Universit?? Cadi Ayyad <br>
Facult?? des Sciences Semlalia Marrakech <br>
D??partement d???Informatique

      </a>
      <a class="navbar-brand" href="#">
      <img style="float:right" src="/website/images/logosem.png" alt="" width="" height="120">
      </a>
  </div>
</nav>
    <section class=" container " >
 
 
    <h2  class="p-2 mb-2 text-center bg-primary text-white mt-5 " >Ajout  des Materiels </h2>

    <a href="http://localhost/designer/pages/magasinier/Materiel.php"> <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal" name="sav_mat" >
                        Materiels
                        </button></a>
    <a href="http://localhost/designer/pages/magasinier/addmat.php"> <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal" name="sav_mat" >
                        Ajouter des materiels 
                        </button></a>
     <form method="POST" class=" container" >
        <div class="form-group m-3">
           <strong><label for="">Nom de Materiel</label></strong>
            <input class="form-control" type="text" name="Materiel"  placeholder="Nom du Materiel " required >
        </div>

        <div class="form-group m-3">
           <strong><label for="">Quantit??</label></strong>
            <input class="form-control"  type="number" name="Quantite"  placeholder="Quantit??" required >
        </div>

        <div class="form-group m-3">
        <strong><label for="">Description</label></strong>
          
                <textarea class="form-control" name="des" placeholder="" id="floatingTextarea" required ></textarea>
               
            </div>  
        </div>
       
        <div class="form-group m-3">
           <strong><label for="">Date</label></strong>
            <input class="form-control" type="date" name="date" value="<?php   echo date('Y-m-d');?>"   placeholder="date" required >
        </div>

        <button class="btn btn-primary p-2 w-100" type="submit" name="sav_mat" >Ajouter</button>
       
        </form>
        <br>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>


</body>
</html>