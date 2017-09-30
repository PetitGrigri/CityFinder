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


}

