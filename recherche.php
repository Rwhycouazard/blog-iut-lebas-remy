<?php 
    require './configue/init.conf.php'; 
    include 'includes/header.php';
    include 'includes/menu.php';

    $loader = new \Twig\Loader\FilesystemLoader('Template/');
    $twig = new \Twig\Environment($loader, ['debug'=>true]);

    // gère la rechèche après le clic du bouton
    if (!empty($_GET['search'])){
        $articlesManager = new articlesManager($bdd);
        $listeArticles = $articlesManager->getListArticlesFromRecherche($_GET['search']);
    }else{
        $listeArticles = [];
    }

    echo $twig->render('recherche.html.twig',
    [
        'session' => $_SESSION,
        'listeArticles'=> $listeArticles,

    ]);
// retire les notifs lier a session
    unset($_SESSION['notification']);

// footer 
include 'includes/footer.php';
?>
        
