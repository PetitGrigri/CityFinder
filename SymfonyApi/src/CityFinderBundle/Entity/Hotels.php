<?php

namespace CityFinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hotels
 *
 * @ORM\Table(name="hotels")
 * @ORM\Entity
 */
class Hotels
{
    /**
     * @var string
     *
     * @ORM\Column(name="date_classement", type="string", length=10, nullable=true)
     */
    private $dateClassement;

    /**
     * @var string
     *
     * @ORM\Column(name="date_publication", type="string", length=10, nullable=true)
     */
    private $datePublication;

    /**
     * @var string
     *
     * @ORM\Column(name="typologie_etablissement", type="string", length=5, nullable=true)
     */
    private $typologieEtablissement;

    /**
     * @var string
     *
     * @ORM\Column(name="classement", type="string", length=9, nullable=true)
     */
    private $classement;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=1, nullable=true)
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="mention", type="string", length=1, nullable=true)
     */
    private $mention;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_commercial", type="string", length=65, nullable=true)
     */
    private $nomCommercial;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=88, nullable=true)
     */
    private $adresse;

    /**
     * @var integer
     *
     * @ORM\Column(name="code_postal", type="integer", nullable=true)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="localite", type="string", length=38, nullable=true)
     */
    private $localite;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=21, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=51, nullable=true)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="site_internet", type="string", length=176, nullable=true)
     */
    private $siteInternet;

    /**
     * @var string
     *
     * @ORM\Column(name="type_sejour", type="string", length=11, nullable=true)
     */
    private $typeSejour;

    /**
     * @var string
     *
     * @ORM\Column(name="capacite_accueil", type="string", length=4, nullable=true)
     */
    private $capaciteAccueil;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_chambre", type="string", length=4, nullable=true)
     */
    private $nombreChambre;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @return string
     */
    public function getDateClassement()
    {
        return $this->dateClassement;
    }

    /**
     * @param string $dateClassement
     * @return Hotels
     */
    public function setDateClassement($dateClassement)
    {
        $this->dateClassement = $dateClassement;
        return $this;
    }

    /**
     * @return string
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * @param string $datePublication
     * @return Hotels
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;
        return $this;
    }

    /**
     * @return string
     */
    public function getTypologieEtablissement()
    {
        return $this->typologieEtablissement;
    }

    /**
     * @param string $typologieEtablissement
     * @return Hotels
     */
    public function setTypologieEtablissement($typologieEtablissement)
    {
        $this->typologieEtablissement = $typologieEtablissement;
        return $this;
    }

    /**
     * @return string
     */
    public function getClassement()
    {
        return $this->classement;
    }

    /**
     * @param string $classement
     * @return Hotels
     */
    public function setClassement($classement)
    {
        $this->classement = $classement;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param string $categorie
     * @return Hotels
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
        return $this;
    }

    /**
     * @return string
     */
    public function getMention()
    {
        return $this->mention;
    }

    /**
     * @param string $mention
     * @return Hotels
     */
    public function setMention($mention)
    {
        $this->mention = $mention;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomCommercial()
    {
        return $this->nomCommercial;
    }

    /**
     * @param string $nomCommercial
     * @return Hotels
     */
    public function setNomCommercial($nomCommercial)
    {
        $this->nomCommercial = $nomCommercial;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     * @return Hotels
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * @param int $codePostal
     * @return Hotels
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocalite()
    {
        return $this->localite;
    }

    /**
     * @param string $localite
     * @return Hotels
     */
    public function setLocalite($localite)
    {
        $this->localite = $localite;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     * @return Hotels
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     * @return Hotels
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
        return $this;
    }

    /**
     * @return string
     */
    public function getSiteInternet()
    {
        return $this->siteInternet;
    }

    /**
     * @param string $siteInternet
     * @return Hotels
     */
    public function setSiteInternet($siteInternet)
    {
        $this->siteInternet = $siteInternet;
        return $this;
    }

    /**
     * @return string
     */
    public function getTypeSejour()
    {
        return $this->typeSejour;
    }

    /**
     * @param string $typeSejour
     * @return Hotels
     */
    public function setTypeSejour($typeSejour)
    {
        $this->typeSejour = $typeSejour;
        return $this;
    }

    /**
     * @return string
     */
    public function getCapaciteAccueil()
    {
        return $this->capaciteAccueil;
    }

    /**
     * @param string $capaciteAccueil
     * @return Hotels
     */
    public function setCapaciteAccueil($capaciteAccueil)
    {
        $this->capaciteAccueil = $capaciteAccueil;
        return $this;
    }

    /**
     * @return string
     */
    public function getNombreChambre()
    {
        return $this->nombreChambre;
    }

    /**
     * @param string $nombreChambre
     * @return Hotels
     */
    public function setNombreChambre($nombreChambre)
    {
        $this->nombreChambre = $nombreChambre;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Hotels
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }



}

