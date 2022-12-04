<?php

class commentaire {

    /**
     * 
     * @var int
     */
    public ?int $comid;

    /**
     * 
     * @var string
     */
    public string $pseudo;

    /**
     * 
     * @var string
     */
    public string $commentaire;

    /**
     * 
     * @var string
     */
    public string $email;
    
    /**
     * 
     * @var int
     */
    public ?int $art_id;

    /**
     * 
     * @return int|null
     */
    public function getComId(): ?int {
        return $this->comid;
    }

    /**
     * 
     * @return string
     */
    public function getPseudo(): string {
        return $this->pseudo;
    }

    /**
     * 
     * @return string
     */
    public function getCommentaire(): string {
        return $this->commentaire;
    }

    /**
     * 
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * 
     * @return int|null
     */
    public function getArt_Id(): ?int {
        return $this->art_id;
    }

    /**
     * 
     * @param int|null $comid
     * @return self
     */
    public function setComId(?int $comid): self {
        $this->comid = $comid;
        return $this;
    }

    /**
     * 
     * @param string $pseudo
     * @return self
     */
    public function setPseudo(string $pseudo): self {
        $this->pseudo = $pseudo;
        return $this;
    }

    /**
     * 
     * @param string $commentaire
     * @return self
     */
    public function setCommentaire(string $commentaire): self {
        $this->commentaire = $commentaire;
        return $this;
    }

    /**
     * 
     * @param string $email
     * @return self
     */
    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }


    /**
     * 
     * @param int|null $art_id
     * @return self
     */
    public function setArt_Id(?int $art_id): self {
        $this->art_id = $art_id;
        return $this;
    }

    /**
     * 
     * @param array $donnees
     * @return self
     */
    public function hydrate(array $donnees): self {

        if (!empty($donnees['comid'])) {
            $this->setComId($donnees['comid']);
        } else {
            $this->setComId(null);
        }
        if (!empty($donnees['pseudo'])) {
            $this->setPseudo($donnees['pseudo']);
        } else {
            $this->setPseudo(null);
        }
        if (!empty($donnees['email'])) {
            $this->setEmail($donnees['email']);
        } else {
            $this->setEmail('');
        }
        if (!empty($donnees['commentaire'])) {
            $this->setCommentaire($donnees['commentaire']);
        } else {
            $this->setCommentaire('');
        }
        if (!empty($donnees['art_id'])) {
            $this->setArt_Id($donnees['art_id']);
        } else {
            $this->setArt_Id(null);
        }
        return $this;
    }

}