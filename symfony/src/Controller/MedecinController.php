<?php

use App\Entity\Medecin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/api/medecins')]
class MedecinController extends AbstractController
{
    #[Route('/{num_rpps}/upload', name: 'medecin_upload', methods: ['POST'])]
    public function uploadImage(Request $request, Medecin $medecin, EntityManagerInterface $entityManager): JsonResponse
    {
        $file = $request->files->get('image');

        if (!$file) {
            return $this->json(['error' => 'No file uploaded'], Response::HTTP_BAD_REQUEST);
        }

        $uploadsDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/images';
        $newFilename = uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($uploadsDirectory, $newFilename);
            $medecin->setImage($newFilename);
            $entityManager->flush();
        } catch (FileException $e) {
            return $this->json(['error' => 'File upload failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['message' => 'Image uploaded successfully', 'image' => $newFilename]);
    }
}

