<?php

class utilisateursManager{

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
     * @var utilisateurs
     */
    private utilisateurs $_utilisateur;

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
     * @return utilisateurs
     */
    public function get_utilisateur(): utilisateurs {
    return $this->_utilisateur;
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
     * @param utilisateurs $_utilisateur
     * @return self
     */
    public function set_utilisateur(utilisateurs $_utilisateur): self {
    $this->_utilisateur = $_utilisateur;
    return $this;
    }

    /**
     * 
     * @param int $_getLastInsertId
     * @return self
     */
    public function set_getLastInsertId(int $_getLastInsertId): self {
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


    /**
     * 
     * @return array
     */
    public function getList(): array {
        $listUtilisateur = [];

        // Prépare une requête de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT id, '
                . 'nom,'
                . 'prenom, '
                . 'email, '
                . 'mdp, '
                . 'sid'
                . 'FROM utilisateurs';

        $req = $this->bdd->prepare($sql);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs.
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            //On créé des objets avec les données issues de la table
            $utilisateurs = new utilisateurs();
            $utilisateurs->hydrate($donnees);
            $listUtilisateur[] = $utilisateurs;
        }

        //print_r2($listUtilisateur);
        return $listUtilisateur;
    }

/**
     * 
     * @param utilisateurs $utilisateurs
     * @return self
     */
    public function updateByEmail(utilisateurs $utilisateurs): self {
        $sql = "UPDATE utilisateurs SET sid = :sid WHERE email = :email";
        $req = $this->bdd->prepare($sql);
        //Sécurisation les variables
        $req->bindValue(':email', $utilisateurs->getEmail(), PDO::PARAM_STR);
        $req->bindValue(':sid', $utilisateurs->getSid(), PDO::PARAM_STR);
        //Exécuter la requête
        $req->execute();
        if ($req->errorCode() == 00000) {
            $this->_result = true;
        } else {
            $this->_result = false;
        }
        return $this;
    }


// public function getByEmail(int $email): utilisateurs{
//     $sql='SELECT * FROM utilisateurs WHERE email = :email';
//     $req= $this->bdd->prepare($sql);

//     $req->bindValue(':email',$email,PDO::PARAM_STR);
//     $req->execute();

//     $donnees=$req->fetch(PDO::FETCH_ASSOC);

//     $utilisateurs=new utilisateurs();
//     $utilisateurs->hydrate($donnees);
//     return($utilisateurs);
// }
/**
     * 
     * @param string $email
     * @return utilisateurs
     */
    public function getByEmail(string $email): utilisateurs {
        // Prépare une requête de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT * FROM utilisateurs WHERE email = :email';
        $req = $this->bdd->prepare($sql);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs.
        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        
        $donnees = !$donnees ? [] : $donnees;
        
        $utilisateurs = new utilisateurs();
        $utilisateurs->hydrate($donnees);
        //print_r2($utilisateurs);
        return $utilisateurs;
    }
        /**
     * @param string $sid
     * @return utilisateurs 
     */ 
    public function getBySid(string $sid): utilisateurs {
        // Prépare une requête de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT nom,prenom,sid FROM utilisateurs WHERE sid = :sid';
        $req = $this->bdd->prepare($sql);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs.
        $req->bindValue(':sid', $sid, PDO::PARAM_STR);
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        
        $donnees = !$donnees ? [] : $donnees;
        
        $utilisateurs = new utilisateurs();
        $utilisateurs->hydrate($donnees);
        //print_r2($utilisateurs);
        return $utilisateurs;
    }


    /**
     * 
     * @param utilisateurs $utilisateurs
     * @return $this
     */


    public function add(utilisateurs $utilisateurs) {
        $sql = "INSERT INTO utilisateurs "
                . "(nom, prenom, email, mdp, sid) "
                . "VALUES (:nom, :prenom, :email, :mdp, :sid)";
        $req = $this->bdd->prepare($sql);
        //Sécurisation les variables
        $req->bindValue(':nom', $utilisateurs->getNom(), PDO::PARAM_STR);
        $req->bindValue(':prenom', $utilisateurs->getPrenom(), PDO::PARAM_STR);
        $req->bindValue(':email', $utilisateurs->getEmail(), PDO::PARAM_STR);
        $req->bindValue(':mdp', $utilisateurs->getMdp(), PDO::PARAM_STR);
        $req->bindValue(':sid', $utilisateurs->getSid(), PDO::PARAM_STR);
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
    // public function add(utilisateurs $utilisateurs) {
    //     $sql = "INSERT INTO utilisateurs "
    //             . "(nom, prenom, email, mdp, sid) "
    //             . "VALUES (:nom, :prenom, :email, :mdp, :sid)";
    //     $req = $this->bdd->prepare($sql);
    //     //Sécurisation les variables
    //     $req->bindValue(':nom', $utilisateurs->getNom(), PDO::PARAM_STR);
    //     $req->bindValue(':prenom', $utilisateurs->getPrenom(), PDO::PARAM_STR);
    //     $req->bindValue(':email', $utilisateurs->getEmail(), PDO::PARAM_STR);
    //     $req->bindValue(':mdp', $utilisateurs->getMdp(), PDO::PARAM_STR);
    //     $req->bindValue(':sid', $utilisateurs->getSid(), PDO::PARAM_STR);
    //     //Exécuter la requête
    //     $req->execute();
    //     if ($req->errorCode() == 00000) {
    //         $this->_result = true;
    //         $this->_getLastInsertId = $this->bdd->lastInsertId();
    //     } else {
    //         $this->_result = false;
    //     }
    //     return $this;
    // }
}