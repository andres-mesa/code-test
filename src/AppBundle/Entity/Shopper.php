<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Shopper
 *
 * @ORM\Table(name="shopper")
 * @ORM\Entity
 */
class Shopper
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idShopper", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idshopper;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @param int $idshopper
     */
    public function setIdshopper($idshopper) {
        $this->idshopper = $idshopper;
    }

    /**
     * @return int
     */
    public function getIdshopper() {
        return $this->idshopper;
    }

    /**
     * @return string
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }


}

