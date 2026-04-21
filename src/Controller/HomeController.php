<?php

namespace App\Controller;

use App\Entity\Priority;
use App\Enum\Status;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TaskRepository;
use App\Repository\FolderRepository;
use App\Repository\PriorityRepository;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\HttpFoundation\Request;


final class HomeController extends AbstractController
{
    #[Route('/home/{id}', name: 'app_home', defaults: ['id' => null], methods: ['GET'])]
    public function index(Request $request, ?int $id, FolderRepository $folderRepository, TaskRepository $taskRepository, PriorityRepository $priorityRepository): Response
    {
        $folders = $folderRepository->getAllFolderWithTaskCount();

        $folder = null;
        if ($id !== null) {
            $folder = $folderRepository->find($id);
        }


        $selectedStatusName = $request->query->getString('status');
        $selectedStatus = null;
        if ('' !== $selectedStatusName) {
            foreach (Status::cases() as $case) {
                if ($case->name === $selectedStatusName) {
                    $selectedStatus = $case;
                    break;
                }
            }
        }

        $priorityParam = $request->query->get('priority');
        $selectedPriorityId = (is_string($priorityParam) && ctype_digit($priorityParam)) ? (int) $priorityParam : null;

        $tasks = $taskRepository->getAllTaskWithFilters($folder, $selectedStatus, $selectedPriorityId);

        $statusCases = Status::cases();
        $priorities = $priorityRepository->findAll();

        return $this->render('home/index.html.twig', [
            'tasks' => $tasks,
            'folders' => $folders,
            'statusCases' => $statusCases,
            'priorities' => $priorities,
            'selectedStatusName' => $selectedStatusName,
            'selectedPriorityId' => $selectedPriorityId,
            'currentFolderId' => $folder?->getId(),
        ]);
    }
}
