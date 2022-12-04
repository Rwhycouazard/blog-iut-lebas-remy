<?php 
require './configue/init.conf.php';
$loader = new \Twig\Loader\FilesystemLoader('Template/');
$twig = new \Twig\Environment($loader, ['debug'=>true]);
include 'includes/header.php';
    
if(!empty($_POST['bouton'])){
    //echo 'le formulaire est posté';
    //print_r2($_POST);
    //print_r2($_FILES);
    //Création de l'utilisateur
    
    $utilisateursFormulaire = new utilisateurs();
    $utilisateursFormulaire->hydrate($_POST);
    // print_r2($utilisateursFormulaire);
    
    $utilisateursManager = new utilisateursManager($bdd);
    $utilisateursEnBdd = $utilisateursManager->getByEmail($utilisateursFormulaire->getEmail());
    //print_r2($utilisateursEnBdd);
    
    $isConnect = password_verify($utilisateursFormulaire->getMdp(), $utilisateursEnBdd->getMdp());
    //print_r2($isConnect);
    //dump($isConnect);
    
    if ($isConnect == true) {
        $sid = md5($utilisateursEnBdd->getEmail() . time());
        //echo $sid;
        //Création du cookie
        setcookie('sid', $sid, time() + 86400);
        //Mise en bdd du sid
        $utilisateursEnBdd->setSid($sid);
        //dump($utilisateursEnBdd);
        $utilisateursManager->updateByEmail($utilisateursEnBdd);
        //dump($utilisateurManager->get_result());
    }

    if ($isConnect == true) {
        $_SESSION['notification']['result'] = 'success';
        $_SESSION['notification']['message'] = 'Vous êtes connecté !';
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['notification']['result'] = 'danger';
            $_SESSION['notification']['message'] = 'Vérifiez votre login / mot de passe !';
            header("Location: connexion.php");
            exit();
        }
}

    echo $twig->render('connexion.htlm.twig',
    [
        'session' => $_SESSION,

    ]);

    unset($_SESSION['notification']);

// footer 
include 'includes/footer.php';
?>
    