<?php
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdminRepository")
 */
#[ApiResource(
    normalizationContext:  ['groups' => ['get', 'put', 'post']],
)]
class Admin extends User
{
    public function __construct()
    {
        parent::__construct();
    }
}
