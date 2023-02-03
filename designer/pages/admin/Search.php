<?php
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


 
 include '../connecte.php';
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
    <title>Search User</title>
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
      <img style="float:right" src="../../images/logosem.png" alt="" width="" height="120">
      </a>
  </div>
</nav> 
<br>

      <section class=" container" >
      <h2  class="p-2 mb-2 text-center bg-primary text-white mt-5 " >Espaces utilisateurs</h2>
          <div style="line-height:10rem"></div>
        <div>
        <a  class="btn btn-primary " href="http://localhost/designer/pages/utilisateurs.php">Comptes en attente d'activation</a>
        <a  class="btn btn-primary " href="http://localhost/designer/pages/addUser.php">Ajouter un Utiliateur Ou Magasinier</a>
        <a  class="btn  "  >        <form class="d-flex">
        <input class="form-control me-2" type="text" name="search" placeholder="Rechercher" aria-label="Search" >
        <button class="btn btn-outline-success" type="submit" name="searchBtn">Recherche</button>
      </form></a>

    
    <!-- <div  class="container mt-5">
        <form>
            <input class="form-control" type="text" name="search" placeholder="search..." >
            <button class="btn btn-warning mt-3 w-100" type="submit" name="searchBtn">Search</button>
        </form>
    </div> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
</body>

</html>




<?php








 if(isset($_GET['searchBtn'])){
     
     $searchR=$database->prepare(" SELECT * FROM utilisateurs WHERE IDEN LIKE :name OR EMAIL LIKE :email ");
     $searchValue= "%" . $_GET['search'] . "%";
     $searchR->bindParam("name",$searchValue);
     $searchR->bindParam("email",$searchValue);
     $searchR->execute();

    echo '<table class=" table container mt-3" >';
    echo "<tr class='table-dark'>";
    echo "<th > Nom de l'identifiant </th>";
    echo "<th> Email </th>";
       foreach($searchR as $result ){

        echo "<tr class='table-info'>";
        echo "<td> ".$result['IDEN']." </td>";
        echo "<td> ".$result['EMAIL']." </td>";
        echo "</tr>";
     }

     echo '</table>';

 }


?>