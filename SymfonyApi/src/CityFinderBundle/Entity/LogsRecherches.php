<?php

namespace CityFinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LogsRecherches
 *
 * @ORM\Table(name="logs_recherches")
 * @ORM\Entity
 */
class LogsRecherches
{
    /**
     * @var integer
     *
     * @ORM\Column(name="utilisateur", type="integer", nullable=false)
     */
    private $utilisateur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_recherche", type="datetime", nullable=false)
     */
    private $dateRecherche;

    /**
     * @var string
     *
     * @ORM\Column(name="recherche", type="text", length=65535, nullable=false)
     */
    private $recherche;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


}

