<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\AdherentRepository;
use App\Repository\TypeCompanyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(AdherentRepository $adherentRepository, TypeCompanyRepository $typeCompanyRepository, EventRepository $eventRepository): Response
    {
        $restaurants = $adherentRepository->findBy(["typeCompany" => $typeCompanyRepository->findOneBy(["name" => 'Restaurant'])]);
        $shops = $adherentRepository->findBy(["typeCompany" => $typeCompanyRepository->findOneBy(["name" => 'Commerce'])]);
        $companies = $adherentRepository->findBy(["typeCompany" => $typeCompanyRepository->findOneBy(["name" => 'Entreprise'])]);
        $allEvents = $eventRepository->findBy([], ['id' => 'desc']);

        $events = [];
        $i = 0;
        foreach ($allEvents as $event) {
            if ($i < 4) {
                $events[] = $event;
            }
            $i++;
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'restaurants' => $restaurants,
            'shops' => $shops,
            'companies' => $companies,
            'events' => $events,
        ]);
    }

    /**
     * @Route("/raccourci", name="raccourci")
     */
    public function raccourci(): Response
    {
        return $this->render('home/raccourci.html.twig');
    }
}
