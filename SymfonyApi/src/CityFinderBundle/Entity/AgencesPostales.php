<?php

namespace CityFinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgencesPostales
 *
 * @ORM\Table(name="agences_postales")
 * @ORM\Entity
 */
class AgencesPostales
{
    /**
     * @var string
     *
     * @ORM\Column(name="identifiant_du_site", type="string", length=6, nullable=true)
     */
    private $identifiantDuSite;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle_site", type="string", length=38, nullable=true)
     */
    private $libelleSite;

    /**
     * @var string
     *
     * @ORM\Column(name="caracteristique_site", type="string", length=29, nullable=true)
     */
    private $caracteristiqueSite;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=38, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="complement_adresse", type="string", length=38, nullable=true)
     */
    private $complementAdresse;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu_dit", type="string", length=37, nullable=true)
     */
    private $lieuDit;

    /**
     * @var integer
     *
     * @ORM\Column(name="code_postal", type="integer", nullable=true)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="localite", type="string", length=32, nullable=true)
     */
    private $localite;

    /**
     * @var string
     *
     * @ORM\Column(name="code_INSEE", type="string", length=5, nullable=true)
     */
    private $codeInsee;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=6, nullable=true)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="decimal", precision=8, scale=6, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="decimal", precision=8, scale=6, nullable=true)
     */
    private $longitude;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



}

