<?php
session_start();
 include('C:\xampp\htdocs\motez\connectdbb.php');

 
 if (isset($_GET['del2'])) {

    $id_livreur = $_GET['del2'];
    $q = $bdd->prepare("DELETE FROM inscrire WHERE adremail=?;");
    $q->execute([$id_livreur]);
    $_SESSION['message'] = "compte has been deleted";
    $_SESSION['msg_type']="danger";


    header("Location: ./listecompte.php");
    exit();
}
if (isset($_GET['ajout1'])) {

    $id_livreur = $_GET['ajout1'];
    $query = $bdd->query("select adremail, phone, mtdps1, name from inscrire where adremail='$id_livreur' ");
    $livreurs1 = $query->fetchall();
    $livreurs2 = $livreurs1[0];
    $val1 = $livreurs2["adremail"];
    $val2 = $livreurs2["phone"];
    $val3 = $livreurs2["mtdps1"];
    $val4 = $livreurs2["name"];
    $q1 = $bdd->query("INSERT INTO `usercompte`(`username`,`password`,`email`) VALUES ('$val4','$val3','$val1')");
    $q2 = $bdd->prepare("DELETE FROM inscrire WHERE adremail=?;");
    $q2->execute([$id_livreur]);



    header("Location: ./listecompte.php");
    exit();
}
if (isset($_GET['ajout2'])) {

    $id_livreur = $_GET['ajout2'];
    $query0 = $bdd->query("select adremail, phone, mtdps1, name from inscrire where adremail='$id_livreur' ");
    $livreurs10 = $query0->fetchall();
    $livreurs20 = $livreurs10[0];

    $val10 = $livreurs20["adremail"];
    $val20 = $livreurs20["phone"];
    $val30 = $livreurs20["mtdps1"];
    $val40 = $livreurs20["name"];

    $q10 = $bdd->query("INSERT INTO `livreur_compte` (`nom_liv`,`prenom_liv`, `email_liv`,`phone_liv`)
     VALUES ('$val40','$val30','$val10','$val20')");



    $q20 = $bdd->prepare("DELETE FROM inscrire WHERE adremail=?;");
    $q20->execute([$id_livreur]);
    $_SESSION['message'] = "livreur ajouter ala liste des livreur";
    $_SESSION['msg_type']="success";



    header("Location: ./listecompte.php");
    exit();
}

 if(isset($_GET['del']))
 {   

     $id_liv = $_GET['del'];
     $q = $bdd -> prepare("DELETE FROM `livreur_compte` WHERE id_liv=?;");
      $q -> execute([$id_liv]); 
      $_SESSION['kk'] = "livreur has been deleted";
      $_SESSION['gg']="danger";


 header("Location: ./listelivreur.php");
  exit(); 

      
   }
   ?>

