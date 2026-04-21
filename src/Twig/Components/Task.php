<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use App\Entity\Task as TaskEntity;

#[AsLiveComponent]
final class Task
{
    use DefaultActionTrait;

    public TaskEntity $task;

    // if prop _isChecked change avec data-model 
    //          getTask(){
    //              
    //           }
}
