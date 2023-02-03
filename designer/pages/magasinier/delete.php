
<?php 

    include "../connecte.php";
   

      if(isset($_GET['deleteIdT'])){

        $idT = $_GET['deleteIdT'];

        $delete = $database->prepare("DELETE FROM teckets WHERE IDT=:idT");-
        $delete->bindParam("idT",$idT);

        if($delete->execute()){
           echo "<script>location.replace('http://localhost/designer/pages/tecket.php')</script>";
            
           
        }else{
            echo "no supprimer";
        }

        
    }



?>