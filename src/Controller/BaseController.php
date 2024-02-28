<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) { }

    public function verifyConnection()
    {

    }

    public function em(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    public function flush($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush($entity);
    }
}
