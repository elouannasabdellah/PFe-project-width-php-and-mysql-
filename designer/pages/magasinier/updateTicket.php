<?php
session_start();
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

    <title>Update Tickete</title>
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
          <a class="nav-link hover" aria-current="page" href="http://localhost/website/pages/magasinier/index.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link hover" href="http://localhost/website/pages/magasinier/materiel.php">Materiels</a>
        </li>
        <li class="nav-item">
          <a class="nav-link hover" href="http://localhost/website/pages/magasinier/addNum.php"> Inventaires</a>
        </li>  
        <li class="nav-item">
          <a class="nav-link hover" href="http://localhost/website/pages/tecket.php"> tickets</a>
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

      <div class="tecket container">
      <h2  class="p-2 mb-2 text-center bg-primary text-white mt-5 " >Modifier les Tickets </h2>
      </div>      

</body>
</html>
<?php


include "../connecte.php";








if(isset($_SESSION['ticketId'])){

    $user = $database->prepare('SELECT * FROM teckets WHERE IDT= :id');
    $user->bindParam("id",$_SESSION['ticketId']);
    $user->execute();
    $user = $user->fetchObject();

echo ' 

<form method="POST" class="container  mt-3 " >

    <div class="p-2 fw-bold">Titre </div>
    <input class="form-control" type="text" name="title" value="'.$user->TITLE.'" placeholder="Titre" required >

    <div class="p-2 fw-bold"> Description </div>
    <input class="form-control" type="text" name="des" value="'.$user->DESCRIPTION.'" placeholder="Description" required >

    <div class="p-2 fw-bold"> Materiel </div>
    <input class="form-control" type="text" name="mat" value="'.$user->MATRIEL.'" placeholder="Materiel" required >

    <div class="p-2 fw-bold">Reference </div>
    <input class="form-control" type="text" name="ref" value="'.$user->REF.'" placeholder="description" required >

    <div class="p-2 fw-bold">  Date</div>
    <input class="form-control" type="date" name="date" value="'.$user->DATE.'" placeholder="date"  required >
 
<div class="modal-footer">
    <button class="btn btn-secondary mt-3" type="submit" name="update" value="'.$user->IDT .'">Enregistrer</button>
    <button class="btn btn-primary mt-3" type="submit" name="cancel" >Annuler</button>
    </div>
 
</form>';

    //update Ticket

    if(isset($_POST["update"])){

        $updateTicket=$database->prepare(" UPDATE teckets SET TITLE=:title, DESCRIPTION=:des,MATRIEL=:mat,REF=:ref,DATE=:date WHERE IDT=:id ");

        $updateTicket->bindParam("title" ,$_POST['title']);
        $updateTicket->bindParam("des" ,$_POST['des'] );
        $updateTicket->bindParam("mat",$_POST['mat'] );
        $updateTicket->bindParam("ref",$_POST['ref'] );
        $updateTicket->bindParam("date",$_POST['date'] );
        $updateTicket->bindParam("id", $_SESSION['ticketId']);

        if($updateTicket->execute()){
            echo "<script>alert('update ticket avec success')</script>";
           // header("Refresh:0");
           header("Refresh:0; url=http://localhost/designer/pages/tecket.php");

        }else{
            echo "<script>alert('error')</script>";
        }

    }

    //cancel

    if(isset($_POST['cancel'])){
        header("location:http://localhost/designer/pages/tecket.php");
    }
  


}else{
    header("location:http://localhost/designer/pages/index.php");
}



?>