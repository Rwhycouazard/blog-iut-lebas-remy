<?php 
require './configue/init.conf.php';

    

$loader = new \Twig\Loader\FilesystemLoader('Template/');
$twig = new \Twig\Environment($loader, ['debug'=>true]);   
    include 'includes/header.php';
    include 'includes/menu.php'; ?>


    <?php 

        if(!empty($_POST['bouton'])){
            //print_r2($_POST);
            $articles = new articles();
            $articles->hydrate($_POST);
            $articles->setDate(date('Y-m-d'));
            //print_r2($articles);
            //print_r2($_FILES);

            $articlesManager =  new articlesManager ($bdd);
            if(!$_POST['id']==''){
                $listeArticles = $articlesManager->update($articles);
                //print_r2($listeArticles);
            }else{
                $listeArticles = $articlesManager->add($articles);
                //print_r2($listeArticles);
            }     
            

            if($articlesManager->get_result()==true){
                if($_FILES['image']['error'] == 0){
                    $nomImage = $articlesManager->get_getLastInsertId();
                    move_uploaded_file($_FILES['image']['tmp_name'],__DIR__."/img/".$nomImage.".jpg");
                }
            }

            $messageNotification = $articlesManager->get_result() == true ? "votre article a été ajouté" : "votre article n'a pas été ajouter";
            $resultNotification = $articlesManager->get_result() == true ? "success" : "danger";

            $_SESSION['notification']['result'] = $resultNotification;
            $_SESSION['notification']['message'] = $messageNotification ;

            header("location: index.php");
            exit();
        }
        if(isset($_GET['id'])){
            
            $articlesManagModifier=new articlesManager($bdd);
            $listeModif = $articlesManagModifier->get($_GET['id']);
            // print_r2($listeModif);
         }else{
            $articlesVide=new articles();
            $articlesVide->hydrate($_POST);
            $listeModif = $articlesVide;
         }

        ?>
        <?php        echo $twig->render('articles.html.twig',
         [
            'get'=>$_GET,
            'listeModif'=>$listeModif
         ]);
         

        include 'includes/footer.php'?>