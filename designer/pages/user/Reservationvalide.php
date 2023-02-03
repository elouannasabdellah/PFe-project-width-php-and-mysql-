<?php

    include '../connecte.php';

    session_start();

    // liman3 lmostakhdimin 

    $utilisateur ="";

    if(isset($_SESSION['user'])){

        if($_SESSION['user']->ROLE=== "USER"){

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


?>














<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../../css/index_User.css">
    <link rel="stylesheet" href="assets/css/fontawsom-all.min.css">
    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    
    <title>Gestion d'utilisateurs</title> 
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
<i class="fab fa-user"></i>
    <!-- <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="logo.png" alt="">
                </span>

                <div class="text logo-text">
                    <span class="name">Utilisateur</span>
                    <span class="profession"><?php echo  $_SESSION['user']->IDEN; ?></span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">

                <ul>
                <li class="nav-link">
                        <a href="http://localhost/website/pages/user/index.php">
                            <i class='bx bx-bar-chart-alt-2 icon' ></i>
                            <span class="text nav-text">Acceuil</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="http://localhost/website/pages/user/Reservation.php">
                            <i class='bx bx-bar-chart-alt-2 icon' ></i>
                            <span class="text nav-text">Reservation</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="#">
                        <i class='bx bx-log-out icon' ></i>
                        <span class="text nav-text"> 
                            
                            <form method="GET"> <button name="Logout"  style="border:none;background:transparent;font-size:1.5rem">Logout</button></form>

                        </span>
                    </a>
                </li>

                <li class="mode">
                    <div class="sun-moon">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Dark mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
                
            </div>
        </div>

    </nav> -->

<!-- <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
      <div class="Iden" ><?php  echo " Welcome ".$_SESSION['user']->IDEN; ?></div> 

      </a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="http://localhost/website/pages/user/index.php">Acceuil</a></li>
      <!-- <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Page 1-1</a></li>
          <li><a href="#">Page 1-2</a></li>
          <li><a href="#">Page 1-3</a></li>
        </ul>
      </li> -->
      <!-- <li><a href="http://localhost/website/pages/user/Reservation.php">Reservation</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    </ul>
  </div> -->
<!-- </nav> --> 
  
<div class="text  containt container">

</div>








    <section class="hom">

        <div class="text" >

        <!-- <div class="Iden" ><?php  echo " Welcome ".$_SESSION['user']->IDEN; ?></div>  -->

        <!-- Afficher les Reservation -->

        <div class="materiles container">
            <div class="ord">
            <h2  class="p-2 mb-2 text-center bg-primary text-white mt-5 " >Les Réservations validés  </h2>
            <table class="table mt-5">
             <thead>
                    <tr class='table-dark'>
                    <th scope="col">idReservation</th>
                    <th scope="col">MATERIEL</th>
                
                    <th scope="col">DATE</th>
                    <th scope="col">ETAT</th>
                   
                    </tr>
            </thead>
            <tbody>

               <!-- Affichage des donnes  DE LA BD dans TABLeau -->

               <?php
                
                $getTicket= $database->prepare("SELECT * FROM reservation WHERE userIDu=:id AND ETAT='VALIDER'");
                $getTicket->bindParam("id",$_SESSION['user']->idu);
                
                if( $getTicket->execute()){

                    foreach($getTicket as $items){
                        echo "<tr class='table-info'>
                                
                        <th scope='row'>".$items['idR']."</th>
                        <td scope='row'>".$items['MATERIEL']."</td>
                        
                        <td scope='row'>".$items['DATE']."</td>
                        <td scope='row'>".$items['ETAT']."</td>

                         
                         </td>

                 </tr>";    
                    }

                }
               
            

       
       ?>

       </tbody>


            </div>
        </div>





        </div>
      

    </section>

    <script src="../../js/indexUser.js"></script>

</body>
</html>