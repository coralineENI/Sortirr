<?php
namespace App\Entity;

use DateTime;

class Filtres {


    /**
     * @var string|null ;
     */
    private $site ;

    /**
     * @var string|null
     */
    private $nom ;

    /**
     * @var datetime|null
     */
    private $debut;

    /**
     * @var datetime|null
     */
    private $fin;

    /**
     * @var boolean
     */
    private $organisateur ;

    /**
     * @var boolean
     */
    private $inscrit;

    /**
     * @var boolean
     */
    private $pasInscrit ;

    /**
     * @var boolean
     */
    private $sortiePassee;

    /**
     * @return string|null
     */
    public function getSite(): ?string
    {
        return $this->site;
    }

    /**
     * @param string|null $site
     */
    public function setSite(?string $site): void
    {
        $this->site = $site;
    }



    /**
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string|null $nom
     */
    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return DateTime|null
     */
    public function getDebut(): ?DateTime
    {
        return $this->debut;
    }

    /**
     * @param DateTime|null $debut
     */
    public function setDebut(?DateTime $debut): void
    {
        $this->debut = $debut;
    }

    /**
     * @return DateTime|null
     */
    public function getFin(): ?DateTime
    {
        return $this->fin;
    }

    /**
     * @param DateTime|null $fin
     */
    public function setFin(?DateTime $fin): void
    {
        $this->fin = $fin;
    }

    /**
     * @return mixed
     */
    public function getOrganisateur()
    {
        return $this->organisateur;
    }

    /**
     * @param mixed $organisateur
     */
    public function setOrganisateur($organisateur): void
    {
        $this->organisateur = $organisateur;
    }

    /**
     * @return mixed
     */
    public function getInscrit()
    {
        return $this->inscrit;
    }

    /**
     * @param mixed $inscrit
     */
    public function setInscrit($inscrit): void
    {
        $this->inscrit = $inscrit;
    }

    /**
     * @return mixed
     */
    public function getPasInscrit()
    {
        return $this->pasInscrit;
    }

    /**
     * @param mixed $pasInscrit
     */
    public function setPasInscrit($pasInscrit): void
    {
        $this->pasInscrit = $pasInscrit;
    }

    /**
     * @return mixed
     */
    public function getSortiePassee()
    {
        return $this->sortiePassee;
    }

    /**
     * @param mixed $sortiePassee
     */
    public function setSortiePassee($sortiePassee): void
    {
        $this->sortiePassee = $sortiePassee;
    }


}