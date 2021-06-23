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

class EventController extends AbstractController
{
    /**
     * @Route("/evenements", name="events_to_come", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findBy(["status" => "1"]);
        $dateindex = new DateTime();
        $data = [];
        foreach ($events as $event) {
            if ((strtotime($event->getDate()->format('Y-m-d H:i:s'))) - (strtotime($dateindex->format('Y-m-d H:i:s'))) > 0) {
                $data[] = $event;
            }
        }

        return $this->render('event/events.html.twig', [
            'events' => $data,
        ]);
    }

    /**
     * @Route("/evenement/passes", name="events_happened", methods={"GET"})
     */
    public function happened(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findBy(["status" => "1"]);
        $dateindex = new DateTime();
        $donnes = [];
        foreach ($events as $event) {
            if ((strtotime($event->getDate()->format('Y-m-d H:i:s'))) - (strtotime($dateindex->format('Y-m-d H:i:s'))) < 0) {
                $donnes [] = $event;
            }

        }
        return $this->render('event/index.html.twig', [
            'events' => $donnes,
        ]);
    }

    /**
     * @Route("evenements/tous", name="events_index", methods={"GET"})
     */
    public function events(): Response
    {
        return $this->render('event/events.html.twig');
    }


    /**
     * @Route("evenement/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }


}
