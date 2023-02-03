<?php

include 'connecte.php';

if($database){

    // echo "conncter";

}else{
    echo "non connecte";
}



//  Login
if(isset($_POST['login'])){

    session_start();

    $login=$database->prepare("SELECT * FROM utilisateurs WHERE EMAIL=:email AND Password=:password");

    $login->bindParam("email",$_POST['email_login']);
    $passwordUser= sha1($_POST['password']);
    $login->bindParam("password", $passwordUser);

    $login->execute();

   if($login->rowCount()===1){    

    $user=$login->fetchObject();

    if($user->ACTIVATED === "1"){
      echo "welcome". $user->IDEN;

      $_SESSION['user']=$user;

    }else{
      echo  '
          <script>alert("!votre compte n est pas encore activé")</script>
      ';

   }


     $_SESSION['user']=$user;

    // Verification de l'user et admin

    if($user->ROLE === "USER"){
        // "<script>location.replace('user/index.php')</script>";
        header("location:user/index.php");
    }else if($user->ROLE=== "ADMIN"){
        //  header("",true);
          header("location:admin/index.php",true);
        // header("location:http://localhost/designer/pages/admin/index.php");
    }else if($user->ROLE==="magasinier"){
        header("location:magasinier/index.php",true);
    }

    }else{

        echo "<div class='alert alert-danger' > Mot de passe ou identifiant est incorrecte</div>";

    }
}

?>

<!-- // login -->

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Abdellah Elouannas | Gestion des Inventaires</title>

    <meta name="description" content="Abdellah Elouannas Etudiant en FSSM SMI web developer">
    <meta name="author" content="abdellah elouannas " >

    <meta property="og:title" content="Abdellah Elouannas - Web Developer">
    <meta property="og:description" content="Etudiant en Fssm" >
    <meta property="og:image" content="assets/images/abde_remove.png" >
    <meta property="og:image:width" content="1200" >
    <meta property="og:image:height" content="630" >
    <meta property="og:url" content="" >
    <meta property="og:type" content="website" >



    <link rel="icon" href="assets/images/abde_remove.png" >
    <link rel="shortcut icon" href="assets/images/abde_remove.png" >

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawsom-all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
</head>
<!-- style="ackground-image: url(../images/content_fssm.png);background-repeat:no-repeat;background-size:cover" -->
<body>

   <nav class="navbar navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img style="float:left" src="../images/logo.png" alt="" width="" height="120">
      </a>
      <a class="navbar-brand" href="#">
Université Cadi Ayyad <br>
Faculté des Sciences Semlalia Marrakech <br>
Département d’Informatique

      </a>
      <a class="navbar-brand" href="#">
      <img style="float:right" src="../images/logosem.png" alt="" width="" height="120">
      </a>
  </div>
</nav>
<div class="" style="background-image: url('http://mdbootstrap.com/img/Photos/Others/images/91.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;"></div>
    <form action="" method="POST">
    <div class="container-fluid ">
        <div class="container ">
            <div class="row ">
                <div class="col-sm-10 login-box">
                    <div class="row">
                        <div class="col-lg-8 col-md-7 log-det">
                            <div class="small-logo">
                                <i class=""></i>Gestion des inventaires
                            </div>
                            <div class="row">
                            <h2>Espace de connexion</h2>
                                <p class="small-info">Connexion à votre compte. </p>
                            </div>


                            <div class="text-box-cont">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="email" aria-label="email" aria-describedby="basic-addon1" name="email_login" required>
                                </div>
                                 <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" placeholder="mot de passe" aria-label="mot de passe" aria-describedby="basic-addon1" name="password" required>
                                </div>

                                <div class="input-group center mb-3">
                                    <button class="btn btn-success btn-round" name="login">Connexion</button>
                                </div>    
                            </div>
                            


                        </div>
                        <div class="col-lg-4 col-md-5 box-de">
                            <div class="ditk-inf">
                            
                                <h2 class="w-100">vous n'avez pas de compte ?!</h2>
                                <p>Créez simplement votre compte en cliquant sur le bouton d'inscription</p>
                                <a href="signup.php">
                                <button type="button" class="btn btn-outline-light">Inscription</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
</body>

<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/script.js"></script>



</html>








