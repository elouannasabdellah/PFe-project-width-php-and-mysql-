<?php

    if(isset($_GET['contry']) && !empty($_GET['contry']) ){

        include '../connecte.php';
        $id = $_GET['contry'];

        $getnum = $database->prepare('SELECT * FROM numinvent WHERE MATERIEL=:id');
        $getnum->bindParam("id",$id);

        $getnum->execute();

        if($getnum->rowCount()>0){

            foreach($getnum as $item){
                echo '<option value="'.$item['NUMERO'].'"  >'.$item["NUMERO"].'</option>';     //value="'.$item['idn'].'"  annulinah
            }

        }else{
            echo "<option>numero d'inventaire n'est pas disponible </option>";
        }

    }else{
        echo "<h1>Erreur</h1>";

    }

?>