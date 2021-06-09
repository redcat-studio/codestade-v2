<?php

namespace App\Controller;

use DateTime;
use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/evenement")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="events_future", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findBy(["status" => "1"]);
        $dateindex=  new DateTime();
        $donnes = [];
        foreach ($events as $event){
            if((strtotime($event->getDate()->format('Y-m-d H:i:s'))) - (strtotime($dateindex->format('Y-m-d H:i:s'))) > 0){
                $donnes []= $event;
            }
           
        }
        return $this->render('event/index.html.twig', [
            'events' =>$donnes,
        ]);
    }
    /**
     * @Route("/evenement/happened", name="events_happened", methods={"GET"})
     */
    public function happened(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findBy(["status" => "1"]);
        $dateindex=  new DateTime();
        $donnes =[];
        foreach ($events as $event){
            if((strtotime($event->getDate()->format('Y-m-d H:i:s'))) - (strtotime($dateindex->format('Y-m-d H:i:s'))) < 0){
                $donnes []= $event;
            }
           
        }
        return $this->render('event/index.html.twig', [
            'events' => $donnes,
        ]);
    }
    
    /**
     * @Route("/", name="events_index", methods={"GET"})
     */
    public function events(): Response
    {
        return $this->render('event/events.html.twig');
    }

    
   
    /**
     * @Route("/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

   
}
