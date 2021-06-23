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
        $allRestaurants = $adherentRepository->findBy(["typeCompany" => $typeCompanyRepository->findOneBy(["name" => 'Restaurant'])]);
        $allShops = $adherentRepository->findBy(["typeCompany" => $typeCompanyRepository->findOneBy(["name" => 'Commerce'])]);
        $allCompanies = $adherentRepository->findBy(["typeCompany" => $typeCompanyRepository->findOneBy(["name" => 'Entreprise'])]);
        $allEvents = $eventRepository->findBy([], ['id' => 'desc']);

        $elementsCount = 3;

        $events = [];
        for ($i = 0 ; $i < $elementsCount ; $i++) {
            $events[] = $allEvents[$i];
        }

        $shops = [];
        for ($i = 0 ; $i < $elementsCount ; $i++) {
            $shops[] = $allShops[$i];
        }

        $restaurants = [];
        for ($i = 0 ; $i < $elementsCount ; $i++) {
            $restaurants[] = $allRestaurants[$i];
        }

        $companies = [];
        for ($i = 0 ; $i < $elementsCount ; $i++) {
            $companies[] = $allCompanies[$i];
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'restaurants' => $restaurants,
            'allRestaurants' => $allRestaurants,
            'shops' => $shops,
            'allShops' => $allShops,
            'companies' => $companies,
            'allCompanies' => $allCompanies,
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
