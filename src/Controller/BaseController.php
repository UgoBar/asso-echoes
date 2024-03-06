<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Number;
use App\Entity\Podcast;
use App\Entity\Session;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
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

    public function save($entity, bool $withRedirect = false, string $route = '', string $flashMsg = ''): true|\Symfony\Component\HttpFoundation\RedirectResponse
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush($entity);

        if ($withRedirect) {
            $this->addFlash("success", $flashMsg);
            return $this->redirectToRoute($route);
        }

        return true;
    }

    public function getRepo($className): \Doctrine\ORM\EntityRepository
    {
        return $this->em()->getRepository($className);
    }


    /**
     * Init entities
     * @throws EntityNotFoundException
     */
    public function createEntities(string $className, $entity, bool $withMedia = false): array
    {
        $isEdit = $entity !== null;
        $entityName = $this->getEntityIfItExists($className);
        if ($entityName === false) {
            throw new EntityNotFoundException();
        }

        $media = null;
        if ($withMedia === true) {
            $media = $isEdit ? $entity->getMedia() : new Media();
        }

        if ($isEdit === false) {
            $entity = new $entityName();
        }

        return [$entity, $media];
    }

    // Check that class exists
    public function getEntityIfItExists(string $entityName): bool|string
    {
        $className = 'App\\Entity\\'.$entityName;
        if (class_exists($className)) {
            return $className;
        }
        return false;
    }

    #[Route('/admin/api/delete', name: 'delete_entity')]
    public function deleteEntity(Request $request): JsonResponse
    {
        // Deserialize the json content
        $data = json_decode($request->getContent(), true);

        // Check that request has entityId and entityName
        if(!array_key_exists('entityId', $data) || !array_key_exists('entityName', $data)) {
            return new JsonResponse(['actionResponse' => 'unauthorized'], 400);
        }

        $entityId = $data['entityId'];
        $entityName = $data['entityName'];

        if ($this->getEntityIfItExists($entityName) === false) {
            return new JsonResponse(['actionResponse' => 'unauthorized'], 400);
        }

        // Check that entity exists
        /** @var Podcast $entity */
        $entity = $this->getRepo($this->getEntityIfItExists($entityName))->find($entityId);
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
