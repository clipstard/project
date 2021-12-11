<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    public $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $updated_by;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return Product
     */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    /**
     * @param mixed $name
     *
     * @return Product
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param mixed $price
     *
     * @return Product
     */
    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @param mixed $updated_by
     *
     * @return Product
     */
    public function setUpdatedBy($updated_by): self
    {
        $this->updated_by = $updated_by;

        return $this;
    }
}
