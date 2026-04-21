<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use App\Entity\Task as TaskEntity;
use App\Enum\Status;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent]
final class TaskComponent
{
    use DefaultActionTrait;

    // function __construct()
    // {
    //     throw new \Exception('Not implemented');
    // }

    #[LiveProp(writable: true)]
    public TaskEntity $task;

    #[LiveProp(writable: true)]
    public bool $isChecked = false;

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function mount(TaskEntity $task): void
    {
        $this->task = $task;
        $this->isChecked = $task->getStatus() === Status::completed;
    }

    #[LiveAction]
    public function saveChecked(): void
    {
        $this->task->setStatus($this->isChecked ? Status::completed : Status::pending);
        $this->em->flush();

        $this->isChecked = $this->task->getStatus() === Status::completed;
    }
}
