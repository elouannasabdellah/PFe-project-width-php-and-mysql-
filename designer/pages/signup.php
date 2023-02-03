<?php 
include 'connecte.php';

if($database){

    // echo "conncter";

}else{
    echo "non connecte";
}

// Inscription
$status="";

$success="";

if(isset($_POST['register'])){

   
    $checkidentifiant = $database->prepare("SELECT * FROM utilisateurs WHERE EMAIL=:email");


    $email = $_POST['email'];
    $checkidentifiant->bindParam("email", $email);
    $checkidentifiant->execute();

    if( $checkidentifiant->rowCount()>0){

        echo '<div style="width:50% ;" class=" alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Error!</strong> ce compte est déja existe
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';

  header("Refresh:1");


    }else{

        $identifiant= $_POST['uname'];
        $email = $_POST['email'];
        $tele= $_POST['tele'];
        $password= sha1($_POST['psw']);


     $addUser=  $database->prepare('INSERT INTO utilisateurs(EMAIL,IDEN,TELE,Password,ROLE) VALUE (:email,:iden,:tele,:password,"")');

     $addUser->bindParam("email", $email);
     $addUser->bindParam("iden",$identifiant);
     $addUser->bindParam("tele", $tele);
     $addUser->bindParam("password",$password);
    
     if($addUser->execute()){
        // echo حسابك بنجاح";

        $success=" votre compte est attente d'activation ";

        header("Refresh:1");

     }else{
         $error= 'il y a un erreur inconnu';
     }

     
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Gestion des inventaires</title>

    <link rel="shortcut icon" href="assets/images/fav.jpg">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawsom-all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
</head>
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
<?php if($success!= "") { ?>
        <div class="alert alert-success" >  <?php echo $success; ?> </div>
    <?php  } ?> 
 <form action="" method="POST" id="inscription_form">
    <div class="container-fluid ">
        <div class="container ">
            <div class="row ">
                <div class="col-sm-10 login-box">
                    <div class="row">
                       <div class="col-lg-4 col-md-5 box-de">
                           <div class="small-logo">
                                <i class="fas fa-stock"></i>Gestion des inventaires
                            </div>
                            <div class="ditk-inf sup-oi">
                            

                                <h2 class="w-100">Vous avez déjà un compte ?!</h2>
                                <p>Connectez-vous simplement à votre compte en cliquant sur le bouton de connexion</p>
                                <a href="index.php">
                                    <button type="button" class="btn btn-outline-light">Connexion</button>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-7 log-det">
                            <h2>Espace d'inscription</h2>
                            <p>Creer votre compte</p>
                            <div class="text-box-cont">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                        <i class="far fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Votre Nom" aria-label="Username" aria-describedby="basic-addon1" name="uname" required>
                                </div>
                                 <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="far fa-envelope"></i>
                                        </span>
                                    </div>
                                    <input id="email" type="text" class="form-control" placeholder="Email Address" aria-label="Username" aria-describedby="basic-addon1" name="email" required>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                    </div>
                                    <input  id="tele" type="text" class="form-control" placeholder="tele" aria-label="Username" aria-describedby="basic-addon1" name="tele" required>
                                </div>
                                
                                <div id="tele_error"></div>

                                 <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input id="password" type="password" class="form-control" placeholder="Password" aria-label="Username" aria-describedby="basic-addon1" name="psw" required>
                                </div>
                                <br>
                                 <div id="password_error"></div>
                                <div class="input-group center sup mb-3">
                                    <button class="btn btn-success btn-round" type="submit" name="register">Inscription</button>
                                </div>    
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
<script src="../js/script.js"></script>
<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/script.js"></script>


</html>
