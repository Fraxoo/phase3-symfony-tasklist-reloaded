<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use App\Entity\Task as TaskEntity;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent]
final class TaskComponent
{
    use DefaultActionTrait;

    

    #[LiveProp(writable:true)]
    public TaskEntity $task;
    // public TaskEntity $task;
    
    #[LiveProp(writable:true)]
    public bool $isChecked = false;

    public function getTask() {
        $this->task->setTitle($this->isChecked ?"c'est vrai" : "c'est faux");

        return $this->task;

    }
}
