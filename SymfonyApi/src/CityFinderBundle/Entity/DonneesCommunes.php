<?php

namespace CityFinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DonneesCommunes
 *
 * @ORM\Table(name="donnees_communes")
 * @ORM\Entity
 */
class DonneesCommunes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="reg", type="integer", nullable=true)
     */
    private $reg;

    /**
     * @var integer
     *
     * @ORM\Column(name="dep", type="integer", nullable=true)
     */
    private $dep;

    /**
     * @var integer
     *
     * @ORM\Column(name="com", type="integer", nullable=true)
     */
    private $com;

    /**
     * @var string
     *
     * @ORM\Column(name="article", type="string", length=3, nullable=true)
     */
    private $article;

    /**
     * @var string
     *
     * @ORM\Column(name="com_nom", type="string", length=45, nullable=true)
     */
    private $comNom;

    /**
     * @var string
     *
     * @ORM\Column(name="long", type="decimal", precision=9, scale=7, nullable=true)
     */
    private $long;

    /**
     * @var string
     *
     * @ORM\Column(name="lat", type="decimal", precision=9, scale=7, nullable=true)
     */
    private $lat;

    /**
     * @var integer
     *
     * @ORM\Column(name="pop_1980", type="integer", nullable=true)
     */
    private $pop1980;

    /**
     * @var integer
     *
     * @ORM\Column(name="pop_1990", type="integer", nullable=true)
     */
    private $pop1990;

    /**
     * @var integer
     *
     * @ORM\Column(name="pop_2000", type="integer", nullable=true)
     */
    private $pop2000;

    /**
     * @var integer
     *
     * @ORM\Column(name="pop_2010", type="integer", nullable=true)
     */
    private $pop2010;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


}

