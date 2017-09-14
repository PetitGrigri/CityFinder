<?php

namespace CityFinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CentralesNucleaires
 *
 * @ORM\Table(name="centrales_nucleaires")
 * @ORM\Entity
 */
class CentralesNucleaires
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom_reacteur", type="string", length=16, nullable=true)
     */
    private $nomReacteur;

    /**
     * @var string
     *
     * @ORM\Column(name="centrale_nucleaire", type="string", length=11, nullable=true)
     */
    private $centraleNucleaire;

    /**
     * @var string
     *
     * @ORM\Column(name="commune", type="string", length=33, nullable=true)
     */
    private $commune;

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
     * @var string
     *
     * @ORM\Column(name="departement", type="string", length=15, nullable=true)
     */
    private $departement;

    /**
     * @var integer
     *
     * @ORM\Column(name="rg", type="integer", nullable=true)
     */
    private $rg;

    /**
     * @var string
     *
     * @ORM\Column(name="palier", type="string", length=3, nullable=true)
     */
    private $palier;

    /**
     * @var string
     *
     * @ORM\Column(name="puissance_thermique", type="string", length=5, nullable=true)
     */
    private $puissanceThermique;

    /**
     * @var string
     *
     * @ORM\Column(name="puisance_brute", type="string", length=5, nullable=true)
     */
    private $puisanceBrute;

    /**
     * @var string
     *
     * @ORM\Column(name="puissance_nette", type="string", length=5, nullable=true)
     */
    private $puissanceNette;

    /**
     * @var integer
     *
     * @ORM\Column(name="debut_construction", type="integer", nullable=true)
     */
    private $debutConstruction;

    /**
     * @var integer
     *
     * @ORM\Column(name="raccordement_reseau", type="integer", nullable=true)
     */
    private $raccordementReseau;

    /**
     * @var integer
     *
     * @ORM\Column(name="mise_service", type="integer", nullable=true)
     */
    private $miseService;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


}

