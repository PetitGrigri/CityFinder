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

    /**
     * @return int
     */
    public function getReg()
    {
        return $this->reg;
    }

    /**
     * @param int $reg
     * @return DonneesCommunes
     */
    public function setReg($reg)
    {
        $this->reg = $reg;
        return $this;
    }

    /**
     * @return int
     */
    public function getDep()
    {
        return $this->dep;
    }

    /**
     * @param int $dep
     * @return DonneesCommunes
     */
    public function setDep($dep)
    {
        $this->dep = $dep;
        return $this;
    }

    /**
     * @return int
     */
    public function getCom()
    {
        return $this->com;
    }

    /**
     * @param int $com
     * @return DonneesCommunes
     */
    public function setCom($com)
    {
        $this->com = $com;
        return $this;
    }

    /**
     * @return string
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param string $article
     * @return DonneesCommunes
     */
    public function setArticle($article)
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return string
     */
    public function getComNom()
    {
        return $this->comNom;
    }

    /**
     * @param string $comNom
     * @return DonneesCommunes
     */
    public function setComNom($comNom)
    {
        $this->comNom = $comNom;
        return $this;
    }

    /**
     * @return string
     */
    public function getLong()
    {
        return $this->long;
    }

    /**
     * @param string $long
     * @return DonneesCommunes
     */
    public function setLong($long)
    {
        $this->long = $long;
        return $this;
    }

    /**
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param string $lat
     * @return DonneesCommunes
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * @return int
     */
    public function getPop1980()
    {
        return $this->pop1980;
    }

    /**
     * @param int $pop1980
     * @return DonneesCommunes
     */
    public function setPop1980($pop1980)
    {
        $this->pop1980 = $pop1980;
        return $this;
    }

    /**
     * @return int
     */
    public function getPop1990()
    {
        return $this->pop1990;
    }

    /**
     * @param int $pop1990
     * @return DonneesCommunes
     */
    public function setPop1990($pop1990)
    {
        $this->pop1990 = $pop1990;
        return $this;
    }

    /**
     * @return int
     */
    public function getPop2000()
    {
        return $this->pop2000;
    }

    /**
     * @param int $pop2000
     * @return DonneesCommunes
     */
    public function setPop2000($pop2000)
    {
        $this->pop2000 = $pop2000;
        return $this;
    }

    /**
     * @return int
     */
    public function getPop2010()
    {
        return $this->pop2010;
    }

    /**
     * @param int $pop2010
     * @return DonneesCommunes
     */
    public function setPop2010($pop2010)
    {
        $this->pop2010 = $pop2010;
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
     * @return DonneesCommunes
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


}

