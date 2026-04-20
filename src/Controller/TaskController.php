<?php

namespace App\Controller;

use App\Entity\Task;
use App\Enum\Status;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/task')]
final class TaskController extends AbstractController
{
    #[Route(name: 'app_task_index', methods: ['GET'])]
    public function index(TaskRepository $taskRepository): Response
    {


        return $this->render('task/index.html.twig', [
            'tasks' => $taskRepository->findBy([
                [null],
                ['is_pinned' => 'DESC']
            ]),
        ]);
    }

    #[Route('/new', name: 'app_task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $task->setOwner($user);
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task/new.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_show', methods: ['GET'])]
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_task_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_delete', methods: ['POST'])]
    public function delete(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $task->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($task);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/toggle-pin', name: 'app_task_toggle_pin', methods: ['POST'])]
    public function togglePin(Task $task, EntityManagerInterface $entityManager): Response
    {
        $task->setIsPinned(!$task->isPinned());
        $entityManager->flush();

        return $this->json([
            'success' => true,
            'isPinned' => $task->isPinned()
        ]);
    }


    #[Route('/{id}/{status}/change-status', name: 'app_task_change_status', methods: ['PUT'])]
        public function toggleDone(Task $task, string $status, EntityManagerInterface $entityManager): Response
    {
        $resolvedStatus = null;

        try {
            // Allows passing the backed value too (e.g. "En cours")
            $resolvedStatus = Status::from($status);
        } catch (\ValueError) {
            $resolvedStatus = match ($status) {
                'pending' => Status::pending,
                'completed' => Status::completed,
                'archived' => Status::archived,
                default => null,
            };
        }

        if (null === $resolvedStatus) {
            return $this->json([
                'success' => false,
                'error' => 'invalid_status',
            ], Response::HTTP_BAD_REQUEST);
        }

        $task->setStatus($resolvedStatus);
        $entityManager->flush();

        return $this->json([
            'success' => true,
            'status' => $resolvedStatus->name,
            'label' => $resolvedStatus->value,
        ]);
    }
}
