<?php 


    // echo "admin";

   include "../connecte.php";

    session_start();

    // liman3 lmostakhdimin 

    if(isset($_SESSION['user'])){

        if($_SESSION['user']->ROLE=== "ADMIN"){

             $utilisateur="Welcome ".$_SESSION['user']->IDEN;

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

    // VALIDER RESERVATION

    if(isset($_GET['valider'])){

        $getNameMR= $database->prepare(" SELECT MATERIEL FROM reservation WHERE idR=:id"); // hada Materiel 
        $getNameMR->bindParam("id",$_GET['valider']);
    
        $getNameMR->execute();
        $getNameMR=$getNameMR->fetchObject();
         $Materile= $getNameMR->MATERIEL;
         
        
    
         $getQuantM=$database->prepare("SELECT QUANTITE FROM materiel WHERE MATERIEL=:matR ");// hada jbdna la Qantite dyal lmateriel
         $getQuantM->bindParam("matR",$Materile);
    
         $getQuantM->execute();
         $getQuantM=$getQuantM->fetchObject();
          $QuantM=  $getQuantM->QUANTITE;
    
          
        
    
         $getQuntR=$database->prepare("SELECT QUANTITE FROM reservation WHERE idR=:id ");  // Quantite Qui est Reserve par utilisateur
         $getQuntR->bindParam("id",$_GET['valider']);
         $getQuntR->execute();
         $getQuntR=$getQuntR->fetchObject();
    
         $QuantR=  $getQuntR->QUANTITE;
    
        
    
          $QuantRest =  $QuantM- $QuantR;
        
    
        if($QuantR <= $QuantM ) {
    
            $updatR=$database->prepare("UPDATE reservation SET  ETAT='VALIDER' WHERE idR=:id");
            $updatR->bindParam("id",$_GET['valider']);
    
            if($updatR->execute()){
    
                echo "<script>alert('Reservation est Valider')</script>";
                header("Refresh:0; url=index.php");
    
                 //update La Quantite de materiel apres la Reservation
    
                $updateMapR= $database->prepare(" UPDATE materiel SET QUANTITE=:Qant WHERE MATERIEL= :matR ");
    
                $updateMapR->bindParam("Qant",$QuantRest);
                $updateMapR->bindParam("matR",$Materile);
    
                $updateMapR->execute();
    
    
            }else{
    
                echo "<script>alert('error')</script>";
            }
    
        }else{
            echo  "<div class='error-Quant alert alert-danger d-flex align-items-center ' role='alert' >
            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16' role='img' aria-label='Warning:'>
            <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
          </svg>
                  <div>
                      La Quantité n'est pas disponible 
                  </div>
    
            </div>";
           
            header("Refresh:1; url=index.php");
        }

    }

     // Message 

     if(isset($_GET['messageadmin'])){
       
        $_SESSION['ResId']=$_GET['messageadmin'];
        header("location:message.php");
    }else{
      // header("location:http://localhost/designer/pages/index.php",true);

    }

?>










<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../../css/index_User.css">
    
    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css.map">


    <title>Gestion d'utilisateurs</title> 

    <style>
               .navbar{
        font-size:16px;
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
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
      <img style="float:right;background-size:contain;padding-bottom:5px;width: 95px;" src="../../images/abde_remove.png" alt="" width="100" height="160">
      </a>
  </div>
</nav>


        <section class="container ">
        <h2  class="p-2 mb-2 text-center bg-primary text-white mt-5 " >Liste des Réservations </h2>


       

    <table class="table mt-5">
    <thead>
        <tr class='table-dark'>
        <th scope="col">idReservation</th>
        <th scope="col">Materiel</th>
        <th scope="col">Numero d'inventaire</th>
        <th scope="col">Utilisateur</th>
        <th scope="col">Date</th>
        <th scope="col">Operation</th>
   
        </tr>
    </thead>
    <tbody>

        <!-- Afficher les Reservation -->

    <?php
    
        
    $todolist=$database->prepare("SELECT * FROM reservation WHERE ETAT='' OR ETAT!='VALIDER'");
    // $userid=$_SESSION['user']->idu;
    // $todolist->bindParam("id",$userid);

    if($todolist->execute()){

        foreach($todolist as $items){
   //         $idT=$items['idT'];
            echo "<tr class='table-info'>
           
                   <th scope='row'>".$items['idR']."</th>
                   <td scope='row'>".$items['MATERIEL']."</td>
                   <td scope='row'>".$items['NUMINV']."</td>
                   <td scope='row'>".$items['UTILISATEUR']."</td>
                    <td scope='row'>".$items['DATE']."</td>

                    <td scope='row' >
                    <form >
                     <button class= 'btn btn-outline-primary' name='valider' value=' ".$items['idR']."' type='submit' > Valider</button>
                     <button class='btn btn-outline-warning' name='messageadmin' value=' ".$items['idR']."' type='submit' >
                     Message
                     </button>
                   

                    </form>
                     </td>

                   
                   
            </tr>";   
        }

    }


?>

</tbody>
</table>



        </section>


        <div class="materiles">
            <div class="ord">

            </div>
        </div>





        </div>
      

    </section>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
    <script src="../../js/indexUser.js"></script>
    <script src="../assets/js/bootstrap.min.js.map" ></script>
    <script src="../assets/js/bootstrap.min.js" ></script>

</body>
</html>