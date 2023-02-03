<?php 



    include "connecte.php";

    // on utilise les session:

    session_start();

    if(isset($_GET['editUser'])){

        $getUser=$database->prepare("SELECT * FROM utilisateurs WHERE idu=:id");
        $getUser->bindParam("id",$_GET['editUser']);
        $getUser->execute();

        foreach($getUser as $user){

            echo '<div  class="container shadow p-3 mb-5 bg-body rounded mt-5" >
            <form method="POST" > 
            
            Identifiant : <input class="form-control" type="text" name="iden" value="'.$user['IDEN'].'" required >
            Email:  <input class="form-control" type="text" name="email" value="'.$user['EMAIL'].'" required >';
           
            
            echo ' Role: <select class="form-select" name="rol" >';


            echo '
            <option  value="USER">USER</option>
            <option  value="magasinier">MAGASIGNIER</option>

        </select>
        <br>

            <button class="btn btn-warning mt-1" type="submit" name="update" value=" '.$user['idu'].' " > actualiser</button> 
            
            <a class="btn btn-success mt-1" href="utilisateurs.php" > Page utilisateurs</a>' ;

            
            echo '<select class="form-select" name="activated" >';

            if($user['ACTIVATED']==="1"){
                echo '<option value=" '.$user['ACTIVATED'].' " > compte activé </option>';
            }else{
                echo '<option value=" '.$user['ACTIVATED'].' " > compte pas activé
                </option>';

            }
            echo '
            <option  value="0"> annuler lactivation</option>
            <option  value="1"> activer  </option>

        </select>
        
        </form>
        </div>';

        }

        if(isset($_POST['update'])){
            $updateUser=$database->prepare("UPDATE utilisateurs set IDEN=:iden, EMAIL=:email,ROLE=:role, ACTIVATED=:activated WHERE idu=:id ");
            
            $updateUser->bindParam("id",$_GET['editUser']);
            $updateUser->bindParam("iden",$_POST['iden']);
            $updateUser->bindParam("email",$_POST['email']);
            $updateUser->bindParam("role",$_POST['rol']);
            $updateUser->bindParam("activated",$_POST['activated']);
            if($updateUser->execute()){
              echo "<script>alert('update avec success')</script>";
              echo "<script>location.replace('utilisateurs.php')</script>";
            }else{
                $updateUser->errorInfo();
            }
            
            
        }

       
    }else{
        // pas de editUser 
      //  header('location:http://localhost/website/pages/index.php',true);
    }
    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>
    
</body>
</html>