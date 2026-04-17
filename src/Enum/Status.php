<?php



namespace App\Enum;

enum Status: string
{
    case pending = "En cours";
    case completed = "terminée";
    case archived = "Archivé";
}
