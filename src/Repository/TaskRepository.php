<?php

namespace App\Repository;

use App\Entity\Folder;
use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Enum\Status;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @return Task[]
     */
    public function getAllTaskWithFilters(?Folder $folder = null, ?Status $status = null, ?int $priorityId = null): array
    {
        $qb = $this->createQueryBuilder('t')
            ->select('t', 'p')
            ->leftJoin('t.priority', 'p');

        if (null !== $folder) {
            $qb->andWhere('t.folder = :folder')
                ->setParameter('folder', $folder);
        }

        if (null !== $status) {
            $qb->andWhere('t.status = :status')
                ->setParameter('status', $status);
        }

        if (null !== $priorityId) {
            $qb->andWhere('p.id = :priority')
                ->setParameter('priority', $priorityId);
        }

        $qb->orderBy('t.isPinned', 'DESC')
            ->addOrderBy(
                "CASE
                WHEN t.status = :pending THEN 1
                WHEN t.status = :completed THEN 2
                WHEN t.status = :archived THEN 3
                ELSE 4
             END",
                'ASC'
            )
            ->setParameter('pending', Status::pending)
            ->setParameter('completed', Status::completed)
            ->setParameter('archived', Status::archived);

        return $qb->getQuery()->getResult();
    }

 
    public function getAllTaskWithPriority()
    {
        $qb = $this->createQueryBuilder('t')
            ->select('t', 'p')
            ->leftJoin('t.priority', 'p')
            ->orderBy('t.isPinned', 'DESC')
            ->addOrderBy(
                "CASE
        WHEN t.status = :pending THEN 1
        WHEN t.status = :completed THEN 2
        WHEN t.status = :archived THEN 3
        ELSE 4
     END",
                'ASC'
            )
            ->setParameter('pending', Status::pending)
            ->setParameter('completed', Status::completed)
            ->setParameter('archived', Status::archived);

        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Task[] Returns an array of Task objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Task
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
