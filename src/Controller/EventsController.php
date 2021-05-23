<?php

namespace App\Controller;

use App\Entity\Events;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\EventsRepository;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class EventsController
{
    private $EventsController;

    public function __construct(EventsRepository $eventsRepository)
    {
        $this->eventsRepository = $eventsRepository;
    }

    /**
     * @Route("/events",  methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        
        $data = json_decode($request->getContent(), true);
        //print_r($data);exit;
        $name = $data['name'];
        $description = $data['description'];
        $datetime = new \DateTime($data['datetime']);
        //$datetime = ;
        $place = $data['place'];
        //print_r($data);exit;
        $imageurl = $data['imageurl'];

        if (empty($name) || empty($description) || empty($place) || empty($imageurl)) {
            throw new Exception('Expecting mandatory parameters!');
        }

        $this->eventsRepository->saveEvents($name, $description, $datetime, $place, $imageurl);

        return new JsonResponse(['status' => 'Event created successfully!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/events/{id}", name="get_one_event", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $events = $this->eventsRepository->findOneBy(['id' => $id]);

        if(!empty($events)){
            $data = [
                'id' => $events->getId(),
                'name' => $events->getName(),
                'description' => $events->getDescription(),
                'datetime' => $events->getDateTime(),
                'place' => $events->getplace(),
                'imageurl' => $events->getImageUrl(),
            ];
            return new JsonResponse($data, Response::HTTP_OK);
        }else{
            return new JsonResponse(['status' => 'No record exist'], Response::HTTP_OK);
        }

    }

    /**
     * @Route("/events", name="get_all_events", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
    
        if(isset($_GET['dateFrom']) || isset($_GET['dateTo'])){
            if(isset($_GET['dateFrom']) && isset($_GET['dateTo'])){
                $dateFrom = $_GET['dateFrom'];
                $dateTo = $_GET['dateTo'];
            }else if(isset($_GET['dateFrom'])){
                $dateFrom = $_GET['dateFrom'];
                $dateTo = "";
            }else if(isset($_GET['dateTo'])){
                $dateFrom = "";
                $dateTo = $_GET['dateTo'];
            }
            $events = $this->eventsRepository->findAllByDateRange($dateFrom, $dateTo );
            
        }else{
            $events = $this->eventsRepository->findAll();
        }

        $data = [];

        foreach ($events as $event) {
            $data[] =  [
                'id' => $event->getId(),
                'name' => $event->getName(),
                'description' => $event->getDescription(),
                'datetime' => $event->getDateTime(),
                'place' => $event->getplace(),
                'imageurl' => $event->getImageUrl(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/events/{id}", name="update_events", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $event = $this->eventsRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $event->setName($data['name']);
        empty($data['description']) ? true : $event->setDescription($data['description']);
        empty($data['datetime']) ? true : $event->setDateTime($data['datetime']);
        empty($data['place']) ? true : $event->setPlace($data['place']);
        empty($data['imageurl']) ? true : $event->setImageUrl($data['imageurl']);

        if(!empty($event)){
            $updatedEvent = $this->eventsRepository->updateEvents($event);
            return new JsonResponse(['status' => 'Records updated sucessfully!'], Response::HTTP_OK);

        }else{
            return new JsonResponse(['status' => 'No record exist'], Response::HTTP_OK);
        }

    }

    /**
     * @Route("/events/{id}", name="delete_events", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $events = $this->eventsRepository->findOneBy(['id' => $id]);

        if(!empty($events)){
            $this->eventsRepository->removeEvent($events);

            return new JsonResponse(['status' => 'Event deleted successfully!'], Response::HTTP_OK);
        }else{
            return new JsonResponse(['status' => 'No record exist'], Response::HTTP_OK);

        }
    }

   
}
