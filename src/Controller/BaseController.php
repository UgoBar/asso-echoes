<?php

namespace App\Controller;

use App\Entity\Number;
use App\Entity\Podcast;
use App\Entity\Session;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class BaseController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) { }

    public function em(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    public function save($entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush($entity);
    }

    public function getRepo($className): \Doctrine\ORM\EntityRepository
    {
        return $this->em()->getRepository($className);
    }

    #[Route('/admin/api/delete', name: 'delete_entity')]
    public function deleteEntity(Request $request): JsonResponse
    {
        // Check that request has entityId and entityName
        if(!$request->request->all()['entityId'] || !$request->request->all()['entityName']) {
            return new JsonResponse(['actionResponse' => 'unauthorized'], 400);
        }

        $entityName = $request->request->all()['entityName'];
        $entityId   = $request->request->all()['entityId'];

        // Check that class exists
        $className = 'App\\Entity\\'.$entityName;
        if (!class_exists($className)) {
            return new JsonResponse(['actionResponse' => 'unauthorized'], 400);
        }

        // Check that entity exists
        /** @var Podcast $entity */
        $entity = $this->getRepo($className)->find($entityId);
        if (!$entity) {
            return new JsonResponse(['actionResponse' => 'unauthorized'], 400);
        }
        $successDeleteMsg = $this->getDeleteSuccessMsg($entity);

        // Delete
        $this->em()->remove($entity);
        $this->em()->flush();

        return new JsonResponse(['actionResponse' => 'success', 'successDeleteMsg' => $successDeleteMsg], 200);

    }

    public function getDeleteSuccessMsg($entity): string
    {
        return match ($entity) {
            Podcast::class => 'Le podcast ' . $entity . ' a été supprimé avec succès',
            Number::class  => 'Le chiffre clé ' . $entity . ' a été supprimé avec succès',
            Session::class => 'L\'atelier ' . $entity . ' a été supprimé avec succès',
            default        => 'Suppression réalisée avec succès',
        };
    }
}
