<?php 
require './configue/init.conf.php';
$loader = new \Twig\Loader\FilesystemLoader('Template/');
$twig = new \Twig\Environment($loader, ['debug'=>true]);
include 'includes/header.php';
include 'includes/menu.php';

    $cpourtest=$_GET['id']; // recuperation de l'id
    if(!empty($_POST['boutoncom'])){
        //recuperation des donner du form 
        $commentaire = new commentaire();
        //print_r2("fait");
        $commentaire->hydrate($_POST);
        //print_r2("fait");
        $commentaireManager = new CommentaireManager($bdd);
        //print_r2("fait");
        $commentaireManager->addcommentaire($commentaire);
        header("Location: index.php");
    }
        
    $commentaireEnBDD = new commentaireManager($bdd);
    $listedescommentaire=$commentaireEnBDD->getList();
    //print_r2($listedescommentaire);    
    $articlesManager = new articlesManager($bdd);
    $listeArticles=$articlesManager->getList();

    echo $twig->render('commentaire.html.twig',
    [
        'session' => $_SESSION,
        'listeArticles'=> $listeArticles,
        'listedescommentaire'=> $listedescommentaire,
        'cpourtest'=> $cpourtest,
        'get'=>$_GET,
    ]);

    unset($_SESSION['notification']);

// footer 
include 'includes/footer.php';
?>    