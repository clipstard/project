<?php
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdminRepository")
 */
#[ApiResource(
    normalizationContext:  ['groups' => ['get', 'put', 'post']],
)]
class Assignment
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    #[Groups(["get", "post", "put"])]
    protected int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["get", "post", "put"])]
    protected string $task;

}
