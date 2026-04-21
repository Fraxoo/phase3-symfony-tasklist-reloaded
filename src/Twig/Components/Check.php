<?php

namespace App\Twig\Components;

use App\Enum\Status;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;

#[AsLiveComponent]
final class Check
{
    use DefaultActionTrait;

    #[LiveProp]
    public int $taskId;

    #[LiveProp(writable: true)]
    public bool $checked = false;

    public function save(EntityManagerInterface $entityManager, TaskRepository $taskRepository) :void
    {

    }
}
