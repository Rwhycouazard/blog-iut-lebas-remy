<?php

class CommentaireManager {
    
    /**
    * 
    * @var PDO
    */
    private PDO $bdd;
    
    /**
    * 
    * @var bool|null
    */
    private ?bool $_result;

    /**
    * 
    * @var Commentaire
    */
    private Commentaire $_commentaire;

    /**
    * 
    * @var int
    */
    private int $_getLastInsertId;
    
    /**
    * 
    * @return PDO
    */
    public function getBdd(): PDO {
        return $this->bdd;
    }
    
    /**
    * 
    * @return bool|null
    */
    public function get_result(): ?bool {
        return $this->_result;
    }

    /**
    * 
    * @return commentaire
    */
    public function get_commentaire(): commentaire {
        return $this->_commentaire;
    }   

    /**
    * 
    * @return int
    */
    public function get_getLastInsertId(): int {
        return $this->_getLastInsertId;
    }

    /**
    * 
    * @param PDO $bdd
    * @return self
    */
    public function setBdd(PDO $bdd): self {
        $this->bdd = $bdd;
        return $this;
    }

    /**
    * 
    * @param bool|null $_result
    * @return self
    */
    public function set_result(?bool $_result): self {
        $this->_result = $_result;
        return $this;
    }

    /**
    * 
    * @param commentaire $_commentaire
    * @return self
    */
    public function set_commentaire(commentaire $_commentaire): self {
        $this->_commentaire = $_commentaire;
        return $this;
    }

    /**
    * 
    * @param int $_getLastInsertId
    * @return self
    */
    public function upda(int $_getLastInsertId): self {
        $this->_getLastInsertId = $_getLastInsertId;
        return $this;
    }

    /**
    * 
    * @param PDO $bdd
    */
    public function __construct(PDO $bdd) {
        $this->setBdd($bdd);
    }
    /*
    * @param int $art_id 
    * @return $commentaire
    * permet de récupérer un commentaire identifier parvart_id de la base pour affichage
    */
    public function get(int $art_id){
        $sql='SELECT lc.commentaire,lc.pseudo FROM listecom as lc inner join articles as a on a.id = lc.art_id where a.id= :art_id';
        $req= $this->bdd->prepare($sql);

        $req->bindValue(':art_id',$art_id,PDO::PARAM_INT);
        $req->execute();

        $donnees=$req->fetch(PDO::FETCH_ASSOC);

        $commentaire=new commentaire();
        $commentaire->hydrate($donnees);
        return($commentaire);
    }

    /* 
    * @return $listcom
    * permet de récupérer tout les commentaire de la base pour affichage
    */
    public function getList(): array {
        // cette requête recupère tout les commentaires de la base
        $listcom = [];
        $sql='SELECT lc.commentaire,lc.pseudo,lc.art_id FROM listecom as lc inner join articles as a on a.id = lc.art_id ';

        $req = $this->bdd->prepare($sql);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs.
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            //On créé des objets avec les données issues de la table
            $commentaire = new commentaire();
            $commentaire->hydrate($donnees);
            $listcom[] = $commentaire;
        }

        //print_r2($listArticle);
        return $listcom;
    }

    /**
     * 
     * @param commentaire $commentaire
     * @return $this
     * permet d'ajouter un commentaire dans la bdd
     */
    public function addcommentaire(commentaire $commentaire) {
    $sql = "INSERT INTO listecom "
            . "(pseudo, email, commentaire, art_id) "
            . "VALUES (:pseudo, :email, :commentaire, :art_id)";
    $req = $this->bdd->prepare($sql);
    //Sécurisation les variables
    $req->bindValue(':pseudo', $commentaire->getPseudo(), PDO::PARAM_STR);
    $req->bindValue(':email', $commentaire->getEmail(), PDO::PARAM_STR);
    $req->bindValue(':commentaire', $commentaire->getCommentaire(), PDO::PARAM_STR);
    $req->bindValue(':art_id', $commentaire->getArt_Id(), PDO::PARAM_INT);
    //Exécuter la requête
    $req->execute();
    if ($req->errorCode() == 00000) {
        $this->_result = true;
        $this->_getLastInsertId = $this->bdd->lastInsertId();
    } else {
        $this->_result = false;
    }
    return $this;
    }

}