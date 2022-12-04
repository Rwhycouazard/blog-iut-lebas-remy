<?php 

    $isConnected = FALSE;

if(isset($_COOKIE['sid'])){
    //initialisation de l'utilisateur
    $utilisateursConnect = new utilisateurs();
    $utilisateursConnect->hydrate($_COOKIE);
    $utilisateursManager = new utilisateursManager($bdd);
    //recherche du sid dans la table et récuperation du nom
    $utilisateursEnco = $utilisateursManager->getBySid($utilisateursConnect->getSid());
    //passe la variable isConnect a tu si les sid corresponde
    if($_COOKIE['sid']==$utilisateursEnco->sid){
        $isConnected = TRUE;
    }
    
}
//var_dump($utilisateursEnco)
?>
