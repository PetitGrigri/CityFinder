<?php

namespace CityFinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Musees
 *
 * @ORM\Table(name="musees")
 * @ORM\Entity
 */
class Musees
{
    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=26, nullable=true)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="departement", type="string", length=24, nullable=true)
     */
    private $departement;

    /**
     * @var string
     *
     * @ORM\Column(name="annexe", type="string", length=46, nullable=true)
     */
    private $annexe;

    /**
     * @var string
     *
     * @ORM\Column(name="musee", type="string", length=94, nullable=true)
     */
    private $musee;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=93, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="cp", type="string", length=5, nullable=true)
     */
    private $cp;

    /**
     * @var string
     *
     * @ORM\Column(name="localite", type="string", length=36, nullable=true)
     */
    private $localite;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=9, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=9, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="site_internet", type="string", length=137, nullable=true)
     */
    private $siteInternet;

    /**
     * @var string
     *
     * @ORM\Column(name="fermeture_annuelle", type="string", length=248, nullable=true)
     */
    private $fermetureAnnuelle;

    /**
     * @var string
     *
     * @ORM\Column(name="periode_ouverture", type="string", length=255, nullable=true)
     */
    private $periodeOuverture;

    /**
     * @var string
     *
     * @ORM\Column(name="nocturnes", type="string", length=75, nullable=true)
     */
    private $nocturnes;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


}

