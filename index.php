<?php 
require './configue/init.conf.php';

$loader = new \Twig\Loader\FilesystemLoader('Template/');
$twig = new \Twig\Environment($loader, ['debug'=>true]);


include 'includes/header.php';
        //Responsive navbar
        include 'includes/menu.php';

                
                    $page = !empty($_GET['page']) ? $_GET['page'] : 1;

                    $articlesManager = new articlesManager($bdd);
                    $nbArticlesTotalAPublie = $articlesManager->countArticles();

                    $nbPages = ceil($nbArticlesTotalAPublie / nb_articles_par_page);

                    $indexDepart = ($page - 1) * nb_articles_par_page;

                    $listeArticles = $articlesManager->getListArticlesAAfficher($indexDepart, nb_articles_par_page);

                    //print_r2($listeArticles);
                    //var_dump($bdd);
                    echo $twig->render('index.html.twig',
                    [
                        'session' => $_SESSION,
                        'listeArticles'=> $listeArticles,
                        'isConnected'=>$isConnected,
                        'nbPages'=>$nbPages
                    ]);

                    unset($_SESSION['notification']);
                
        // footer 
        include 'includes/footer.php';