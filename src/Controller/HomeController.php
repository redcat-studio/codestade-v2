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
    public function index(AdherentRepository $adherentRepository,TypeCompanyRepository $typeCompanyRepository,EventRepository $eventRepository): Response
    {
        $restaurent = $adherentRepository->findBy(["typeCompany"=>$typeCompanyRepository->findOneBy(["name"=>'Restaurant'])]);
        $commerce = $adherentRepository->findBy(["typeCompany"=>$typeCompanyRepository->findOneBy(["name"=>'Commerce'])]);
        $entreprise = $adherentRepository->findBy(["typeCompany"=>$typeCompanyRepository->findOneBy(["name"=>'Entreprise'])]);
        $events = $eventRepository->findBy([],['id' => 'desc']);
        
        $donnes = [];
        $i =0;
        foreach ($events as $event){
            if($i < 4){
                $donnes []= $event;
            }
           $i++;
        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'restaurents'   =>$restaurent,
            'commerces'   =>$commerce,
            'entreprises'   =>$entreprise,
            'events' =>$donnes,
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
