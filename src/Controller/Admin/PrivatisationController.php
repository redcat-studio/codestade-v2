<?php

namespace App\Controller\Admin;

use App\Entity\Privatisation;
use App\Form\PrivatisationType;
use App\Repository\AdherentRepository;
use App\Repository\PrivatisationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/privatisation")
 */
class PrivatisationController extends AbstractController
{
    /**
     * @Route("/", name="admin_privatisation", methods={"GET"})
     */
    public function index(PrivatisationRepository $privatisationRepository): Response
    {
        return $this->render('admin/privatisation/index.html.twig', [
            'privatisations' => $privatisationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/noprivate", name="admin_privatisation_me", methods={"GET"})
     */
    public function nosprivate(PrivatisationRepository $privatisationRepository): Response
    {   
       
        return $this->render('admin/privatisation/index.html.twig', [
            'privatisations' => $privatisationRepository->findBy(["user_id" => $this->getUser()->getId()]),
        ]);
    }
    /**
     * @Route("/new", name="admin_privatisation_new", methods={"GET","POST"})
     */
    public function new(Request $request,AdherentRepository $adherentRepository): Response
    {
        $privatisation = new Privatisation();
        $form = $this->createForm(PrivatisationType::class, $privatisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $privatisation->setAdherent($adherentRepository->findOneBy(["username" =>$this->getUser()->getUsername()]));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($privatisation);
            $entityManager->flush();

            return $this->redirectToRoute('admin_privatisation');
        }

        return $this->render('admin/privatisation/new.html.twig', [
            'privatisation' => $privatisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_privatisation_show", methods={"GET"})
     */
    public function show(Privatisation $privatisation): Response
    {
        return $this->render('admin/privatisation/show.html.twig', [
            'privatisation' => $privatisation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_privatisation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Privatisation $privatisation): Response
    {
        $form = $this->createForm(PrivatisationType::class, $privatisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_privatisation');
        }

        return $this->render('admin/privatisation/edit.html.twig', [
            'privatisation' => $privatisation,
            'form' => $form->createView(), 
        ]);
    }

    /**
     * @Route("/{id}", name="privatisation_delete", methods={"POST"})
     */
    public function delete(Request $request, Privatisation $privatisation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$privatisation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($privatisation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_privatisation');
    }
}
