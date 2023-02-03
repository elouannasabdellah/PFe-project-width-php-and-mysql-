<?php

    session_start();
    include 'connecte.php';
    

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

 

   

  
  
    //  Ajouter tecket 

    if(isset($_POST['save'])){

        $addtecket=$database->prepare("INSERT INTO teckets(TITLE,DATE,DESCRIPTION,MATRIEL,UTILISATEUR,REF)VALUES(:title,:date,:des,:mat,:util,:ref)");

        $addtecket->bindParam("title",$_POST['title']);
        $addtecket->bindParam("date",$_POST['date']);
        $addtecket->bindParam("des",$_POST['description']);

        $addtecket->bindParam("mat",$_POST['Materiel']);
        $addtecket->bindParam("util",$_POST['utilis']);
        $addtecket->bindParam("ref",$_POST['refer']);

        if($addtecket->execute()){
            echo "<div class=' error-Quant alert alert-info' style='width:50%;margin:auto' > Ticket est Enregistrer Avec Success </div>";
            header("Refresh:1 ;");

            
        }else{
            echo "eroor";
        }

    }

     // update ticket
      
     if(isset($_GET['update_ticket'])){
        session_start();

        $_SESSION['ticketId']=$_GET['update_ticket'];

        header("location:http://localhost/designer/pages/magasinier/updateTicket.php");
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
    <title>Magasignier | abdellah elouannas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">



</head>
<body>



    <!-- NAVBAR -->
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



    <!-- TICKETS -->

      <section class="tecket container">
      <h2  class="p-2 mb-2 text-center bg-primary text-white mt-5 " >Liste des Tickets </h2>


                    <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal" >
                        Ajouter Ticket
                        </button>
                         
                     

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ajouter Ticket</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form  method="POST" >
                            <div class="modal-body">


                                 <div class="form-group p-1">
                                    <label for="usr">Titre</label>
                                    <input type="text" class="form-control" id="usr" placeholder="Titre" name="title" required >
                                </div>
                              
                                <div class="form-group p-1">
                                    <label for="date">Date</label>
                                    <input type="date"  value="<?php   echo date('Y-m-d');?>" class="form-control" id="date" name="date" required >
                                </div>
                              
                        
                                <div class="form-group p-1" >

                                <label style="font-size:19px;color :red ;" for="cars">Choisir un Materiel</label>
                                <select class="form-select" required name="Materiel" id="Materiel">

                                <?php
                                    $getMateriel=$database->prepare("SELECT * FROM materiel");
                                  
                                    $getMateriel->execute();
                                    // jalb tous les materiels
                                    foreach($getMateriel as $mat ){

                                      echo'<option > '.$mat["MATERIEL"].'</option>';
                                    }

                                ?>
                                  
                                </select>

                                <label class="p-1" style="font-size:19px;color :red ;" for="cars">Choisir un Utilisateur!</label>
                                <select class="form-select" required name="utilis" id="utilis">

                                <?php
                                    $getutilis=$database->prepare("SELECT * FROM utilisateurs WHERE ROLE='USER'");
                                  
                                    $getutilis->execute();
                                    // jalb lmostakhdmin min la table utilisateurs
                                    foreach($getutilis as $util ){

                                      echo'<option > '.$util["IDEN"].'</option>';
                                    }

                                ?>

                                </select>
                               
                                </div>
                                <!-- </br>  -->
                                <div class="form-group p-1">
                                    <label for="usr">References</label>
                                    <input type="text" class="form-control" id="Refe" placeholder="Reference" name="refer" required >
                                </div>                       
                                    <div class="form-group p-1">
                                    <label for="usr">Commentaires</label>
                                    <textarea  class="form-control" required name="description" id="floatingTextarea" placeholder="creer un commentaire" ></textarea>
                                    <!-- <label for="floatingTextarea">descript</label> -->
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary" name="save" >Ajouter</button>
                            </div>
                            </form>
                            </div>
                        </div>
                        </div>


                          <!--                 table -->

            <table class="table mt-5">
                <thead class="table-dark">
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
                <tbody>

                       <!-- Affichage des donnes  DE LA BD dans TABLeau -->

                <?php
                
                    
                $todolist=$database->prepare("SELECT * FROM teckets");
             

                if($todolist->execute()){

                    foreach($todolist as $items){
                        $idT=$items['IDT'];
                        echo "<tr class='table-info'>
                        
                            <th scope='row'>".$items['IDT']."</th>
                            <td scope='row'>".$items['TITLE']."</td>
                            <td scope='row'>".$items['DATE']."</td>

                            <td scope='row'>".$items['DESCRIPTION']."</td>
                            <td scope='row'>".$items['MATRIEL']."</td>
                            <td scope='row'>".$items['UTILISATEUR']."</td>

                            <td scope='row'>".$items['REF']."</td>
                          


                            <td scope='row' >
                            <form>
                            <button class= 'btn btn-primary' name='update_ticket' value='".$idT."' > <a class='text-light' style='text-decoration:none'  >Modifier </a> </button>
                            <button class='btn btn-danger' > <a class='text-light' style='text-decoration:none'  href='/designer/pages/magasinier/delete.php?deleteIdT=".$idT."' >Supprimer </a> </button>
                            </form>
                            </td>
                        
                        </tr>";   
                    }

                }

        
        ?>

        </tbody>

                </tbody>

            </table>

                </section>
                   
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</body>

</html>