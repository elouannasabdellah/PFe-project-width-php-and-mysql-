<?php

    session_start();

    include '../connecte.php';

    // liman3 lmostakhdimin qui ne sont pas magasignier

  

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

    //valider Reservation   

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

    // //update La Quantite de materiel apres la Reservation

    // $updateMapR= $database->prepare(" UPDATE materiel SET QUANTITE=:Qant WHERE MATERIEL= :matR ");

    // $updateMapR->bindParam("Qant",$QuantRest);
    // $updateMapR->bindParam("matR",$Materile);

    // $updateMapR->execute();

    }

    // Message 

    if(isset($_GET['message'])){
        session_start();
        $_SESSION['ResId']=$_GET['message'];
        header("location:message.php");
    }else{

    }
  
    //  Ajouter tecket 

    // if(isset($_POST['save'])){

    //     $addtecket=$database->prepare("INSERT INTO teckets(TITLE,DATE,DESCRIPTION,MATRIEL,UTILISATEUR,REF)VALUES(:title,:date,:des,:mat,:util,:ref)");

    //     $addtecket->bindParam("title",$_POST['title']);
    //     $addtecket->bindParam("date",$_POST['date']);
    //     $addtecket->bindParam("des",$_POST['description']);

    //     $addtecket->bindParam("mat",$_POST['Materiel']);
    //     $addtecket->bindParam("util",$_POST['utilis']);
    //     $addtecket->bindParam("ref",$_POST['refer']);

    //     if($addtecket->execute()){
    //         echo "<div class=' error-Quant alert alert-info' style='width:50%;margin:auto' > Ticket est Enregistrer Avec Success </div>";
    //         header("Refresh:1");

            
    //     }else{
    //         echo "eroor";
    //     }

    // }

     // update ticket
      
    //  if(isset($_GET['update_ticket'])){
    //     session_start();

    //     $_SESSION['ticketId']=$_GET['update_ticket'];

    //     header("location:updateTicket.php");
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
    <title>Magasignier </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        .error-Quant{
            position:absolute;
            top:28%;
            font-size:18px;
            left:35%;
             padding:2px 3px;
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

    <section class="container  mt-5">

    <h2  class="p-2 mb-2 text-center bg-primary text-white mt-5 " >Liste des Reservations </h2>

    <table class="table mt-5 py-5">
             <thead>
                    <tr class='table-dark'>
                    <th scope="col">idReservation</th>
                    <th scope="col">Materiel</th>
                    <th scope="col">Quantite</th>
                    <th scope="col">Utilisateur</th>
                    <th scope="col">DATE</th>
                    <th scope="col">Operation</th>
                    </tr>
            </thead>
            <tbody>

               <!-- Affichage des donnes  DE LA BD dans TABLeau -->

               <?php
                
                $getTicket= $database->prepare("SELECT * FROM reservation WHERE ETAT ='' OR ETAT!='VALIDER' ");
                
                if( $getTicket->execute()){

                    foreach($getTicket as $items){
                        echo "<tr class='table-info'>
                                
                        <th scope='row'>".$items['idR']."</th>
                        <td scope='row'>".$items['MATERIEL']."</td>
                        <td scope='row'>".$items['QUANTITE']."</td>
                        <td scope='row'>".$items['UTILISATEUR']."</td>
                        <td scope='row'>".$items['DATE']."</td>

                         <td scope='row' >
                        <form >
                         <button class= 'btn btn-outline-primary' name='valider' value=' ".$items['idR']."' type='submit' > Valider</button>
                         <button class='btn btn-outline-warning' name='message' value=' ".$items['idR']."' type='submit' >
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

    <!-- TICKETS -->

      <!-- <section class="tecket container"> -->
        <!-- <h1  class="p-2 mb-2 text-center bg-primary text-white mt-5 mx-auto">Tickets</h1> -->
                  

                    <!-- <button class="ajouter btn btn-outline-primary" >Ajouter Ticket</button> -->

                    <!-- modale -->

                    <!-- Button trigger modal -->
                        <!-- <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Ajouter Tickes
                        </button> -->
                         
                     

                        <!-- Modal -->
                        <!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ajouter Ticket</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form  method="POST" >
                            <div class="modal-body">


                                 <div class="form-group p-1">
                                    <label for="usr">Title</label>
                                    <input type="text" class="form-control" id="usr" placeholder="title" name="title" required >
                                </div>
                              
                                <div class="form-group p-1">
                                    <label for="date">Date</label>
                                    <input type="date"  value="<//?php   echo date('Y-m-d');?>" class="form-control" id="date" name="date" required >
                                </div> -->
                              
                        
                                <!-- <div class="form-group p-1" >

                                <label style="font-size:19px" for="cars">Chose a Materiel:</label>
                                <select class="form-select" required name="Materiel" id="Materiel"> -->

                                <?php
                                    // $getMateriel=$database->prepare("SELECT * FROM materiel");
                                  
                                    // $getMateriel->execute();
                                    // // jalb tous les materiels
                                    // foreach($getMateriel as $mat ){

                                    //   echo'<option > '.$mat["MATERIEL"].'</option>';
                                    // }

                                ?>
                                  
                                <!-- </select>

                                <label class="p-1" style="font-size:19px" for="cars">Chose a Utilisateur!:</label>
                                <select class="form-select" required name="utilis" id="utilis"> -->

                                <?php
                                    // $getutilis=$database->prepare("SELECT * FROM utilisateurs WHERE ROLE='USER'");
                                  
                                    // $getutilis->execute();
                                    // // jalb lmostakhdmin min la table utilisateurs
                                    // foreach($getutilis as $util ){

                                    //   echo'<option > '.$util["IDEN"].'</option>';
                                    // }

                                ?>

                                <!-- </select>
                               
                                </div> -->
                                <!-- </br>  -->
                                <!-- <div class="form-group p-1">
                                    <label for="usr">References</label>
                                    <input type="text" class="form-control" id="Refe" placeholder="Reference" name="refer" required >
                                </div>

                                </br>                        
                                    <div class="form-floating">
                                    <textarea  class="form-control" required name="description" id="floatingTextarea" placeholder="Leave a comment here" ></textarea>
                                     <label for="floatingTextarea">descript</label> -->
                                    <!-- </div>  -->

                            <!-- </div> -->
                            <!-- <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="save" >Save changes</button>
                            </div>
                            </form>
                            </div>
                        </div>
                        </div> -->


                          <!--                 table -->

            <!-- <table class="table mt-3">
                <thead>
                    <tr>
                    <th scope="col">idT</th>
                    <th scope="col">Title</th>
                    <th scope="col">Date</th>
                    <th scope="col">Description</th>
                    <th scope="col">Materiel</th>
                    <th scope="col">Utilisateurs</th>
                    <th scope="col">References</th>
                    <th scope="col">Operation</th>
               
                    </tr>
                </thead>
                <tbody> -->

                       <!-- Affichage des donnes  DE LA BD dans TABLeau -->

  

        <!-- </tbody>

                </tbody>

            </table>

                </section> -->
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</body>

</html>