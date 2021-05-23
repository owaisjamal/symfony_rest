<?php

namespace App\Repository;

use App\Entity\Events;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;


/**
 * @method Events|null find($id, $lockMode = null, $lockVersion = null)
 * @method Events|null findOneBy(array $criteria, array $orderBy = null)
 * @method Events[]    findAll()
 * @method Events[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsRepository extends ServiceEntityRepository
{
    private $manager;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Events::class);
        $this->manager = $manager;
    }

   
    public function saveEvents($name, $description, $datetime, $place, $imageurl)
    {
        
        $newEvent = new Events();

        $newEvent
            ->setName($name)
            ->setDescription($description)
            ->setDatetime($datetime)
            ->setPlace($place)
            ->setImageUrl($imageurl);

        $this->manager->persist($newEvent);
        $this->manager->flush();
    }

    public function updateEvents(Events $events): Events
    {
        $this->manager->persist($events);
        $this->manager->flush();

        return $events;
    }

    public function removeEvent(Events $event)
    {
        $this->manager->remove($event);
        $this->manager->flush();
    }

    public function findAllByDateRange($dateFrom, $dateTo){

         $qb = $this->createQueryBuilder('p');
            if($dateFrom != ""){
                $qb->where('p.datetime >= :dateFrom')
                ->setParameter('dateFrom', $dateFrom);
            }
            if($dateTo != ""){
                $qb->andWhere('p.datetime <= :dateTo')
                ->setParameter('dateTo', $dateTo);
            }
            $qb->orderBy('p.datetime', 'ASC');

        $query = $qb->getQuery();

        return $query->execute();

    }
}
