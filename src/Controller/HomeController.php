<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TaskRepository;
use App\Repository\FolderRepository;


final class HomeController extends AbstractController
{
    #[Route('/home/{id}', name: 'app_home', defaults: ['id' => null])]
    public function index(?int $id, FolderRepository $folderRepository, TaskRepository $taskRepository): Response
    {
        $folders = $folderRepository->findAll();


        $tasks = [];

        if ($id) {
            $folder = $folderRepository->find($id);

            if ($folder) {
                $tasks = $taskRepository->findBy(
                    ['folder' => $folder],
                    ['priority' => 'DESC']
                );
            }
        }

        if (!$id) {
            $tasks = $taskRepository->getAllTaskWithPriority();
        }

        return $this->render('home/index.html.twig', [
            'tasks' => $tasks,
            'folders' => $folders
        ]);
    }
}
