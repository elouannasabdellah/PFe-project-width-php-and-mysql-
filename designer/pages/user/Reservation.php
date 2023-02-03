

<?php 

    session_start();
    include "../connecte.php";

if(isset($_SESSION['user'])){

    if($_SESSION['user']->ROLE=== "USER"){

        // echo "Welcome ". $_SESSION['user']->IDEN;

         $utilisateur="Welcome ".$_SESSION['user']->IDEN;

    }else{
        header("location:http://localhost/designer/pages/index.php");
        die();
    }


}else{
    header("location:http://localhost/designer/pages/index.php");
}

// Reserver un materile 

    if(isset($_POST['save'])){


        $Reserv = $database->prepare("INSERT INTO reservation(MATERIEL,NUMINV,QUANTITE,UTILISATEUR,DATE,userIDu) VALUES(:materile,:numinv,:Quan,:utilisateur,:date,:userid) ");
    
        $Reserv->bindParam("utilisateur",$_POST['user']);
        $Reserv->bindParam("materile",$_POST['materiel']);
        $Reserv->bindParam("numinv",$_POST['num']);
        $Reserv->bindParam("Quan",$_POST['Quantite']);
        $Reserv->bindParam("date",$_POST['date']);
    
         $userid=  $_SESSION['user']->idu;
        $Reserv->bindParam("userid", $userid);
    
         
        if($Reserv->execute()){
            
            echo header("location:Reservation.php");
        }
        else{
            // echo $Reserv->errorInfo();
            echo "<script>alert('EROR')</script>";
        }



    }
//deconnecxion
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
    <link rel="stylesheet" href="../css/tecket.css">
    <title></title>
    <!-- bootstrap css -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   
    <script src="jquery.js"></script>

    <script>
        $(document).ready(function(){

            $('#materiel').on('change',function(){

                var contryID = $(this).val();
                if(contryID){

                    $.get(
                        "ajax.php",
                        {contry:contryID},
                        function(data){
                            $('#NUM').html(data);
                        }   
                    );

                }else{
                    $('#NUM').html('<option>Select Materiel First</option>');
                }

            })

        });
    </script>
   
  
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
          <a class="nav-link hover" aria-current="page" href="http://localhost/designer/pages/user/index.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link hover" href="http://localhost/designer/pages/user/Reservation.php">Reservation</a>
        </li>
        <li class="nav-item">
          <a class="nav-link hover" href="http://localhost/designer/pages/user/Reservationvalide.php"> les Reservation validés</a>
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
    </br>
        <!-- <section class="home">
            <div class="text">
               <h1>VVVVVVVVVVV</h1>
            </div>
        </section> -->
        
        <section class="home container " >
            <div class="text  containt ">


                    <!-- <button class="ajouter btn btn-outline-primary" >Ajouter Ticket</button> -->

                    <!-- modale -->

                    <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                         Reserver un Materiel
                        </button>
                         
                        <!-- <a  class="btn btn-dark" href="http://localhost/website/pages/user/index.php">Retour au page User</a> -->

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Reserver Un Materiel</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form  method="POST" >
                            <div class="modal-body">
                              

                                <div class="form-group">
                                    <label for="">Utilisateur</label>
                                    <input class="form-control" type="text" name="user"  value="<?php echo  $_SESSION['user']->IDEN  ?>" >
                                </div>
                            </br>
                                <div class="form-group">
                                    <label for="">Choisir le Materiel</label>
                                    <select class="form-select" name="materiel" id="materiel"  >
                                        <!-- <option>Select A Materiel</option> -->

                                    <?php
                                    $getMateriel=$database->prepare("SELECT * FROM materiel");
                                  
                                    $getMateriel->execute();
                                    // jalb tous les materiels
                                    foreach($getMateriel as $mat ){

                                      echo'<option value="'.$mat['MATERIEL'].'" > '.$mat["MATERIEL"].'</option>';
                                    }

                                ?>
                                    </select>
                                </div> </br>
                                <div class="form-group">
                                    <label for="">Choisir le Numero d'inventaire</label>
                                    <select class="form-select" name="num" id="NUM" required >

                                    <option>choisir le materiel au début</option>

                                    <!-- <?php
                                    // $getNum=$database->prepare("SELECT * FROM numrinv");
                                    // $getNum->bindParam("matName",$_POST['materiel']);
                                  
                                    // $getNum->execute();
                                   
                                    // foreach($getNum as $num ){

                                    //   echo'<option > '.$num["NUMERO"].'</option>';
                                    // }

                                ?> -->
                                    </select>
                                </div>

                               

                                </br>
                                <div class="form-group" >
                                    <label for="">Quantité</label>
                                    <input  class="form-control" type="number"  max="1" min="1" value="1" name="Quantite" required >
                                </div>

                                <div class="form-group" >
                                    <label for="">Date</label>
                                    <input  class="form-control" type="date"  value="<?php   echo date('Y-m-d');?>" name="date" required >
                                </div>
                               

                                <!-- </br>  -->
                             

                            </div>

                          
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary" name="save" id="save" >Réserver</button>
                            </div>
                            </form>
                            </div>
                        </div>
                        </div>

            <!--                 table -->
            <h2  class="p-2 mb-2 text-center bg-primary text-white mt-5 " >Les Réservations  </h2>
            <table class="table mt-5 fw-bold">
                <thead>
                    <tr  class='table-dark'>
                    <th scope="col">idReservation</th>
                    <th scope="col">Materiel</th>
                    <th scope="col">Numero d'Inventaire</th>
                    <th scope="col">Quantité</th>
                    

                    </th>
                    <th scope="col">Date</th>
                   
               
                    </tr>
                </thead>
                <tbody>

                <!-- Affichage des donnes  DE LA BD dans TABLeau -->

                <?php
                
                    
                         $todolist=$database->prepare("SELECT * FROM reservation WHERE userIDu =:id");
                         $userid=$_SESSION['user']->idu;
                         $todolist->bindParam("id",$userid);

                         if($todolist->execute()){

                             foreach($todolist as $items){
                        //         $idT=$items['idT'];
                                 echo "<tr class='table-info'>
                                
                                        <th scope='row'>".$items['idR']."</th>
                                        <td scope='row'>".$items['MATERIEL']."</td>
                                        <td scope='row'>".$items['NUMINV']."</td>
                                        <td scope='row'>".$items['QUANTITE']."</td>
                                       
                                         <td scope='row'>".$items['DATE']."</td>


                                 </tr>";    
                             }

                         }

                
                ?>

                </tbody>
            </div>
        </section>


     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


 </body>
 </html>
