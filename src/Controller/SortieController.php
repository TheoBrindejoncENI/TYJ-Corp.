<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sortie")
 */
class SortieController extends Controller
{
    /**
     * @Route("/", name="sortie_index", methods={"GET"})
     */
    public function index(SortieRepository $sortieRepository): Response
    {
        return $this->render('sortie/index.html.twig', [
            'sorties' => $sortieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sortie_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sortie = new Sortie();
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sortie->setOrganisateur($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sortie);
            $entityManager->flush();

            return $this->redirectToRoute('sortie_index');
        }

        return $this->render('sortie/new.html.twig', [
            'sortie' => $sortie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sortie_show", methods={"GET"})
     */
    public function show(Sortie $sortie): Response
    {
        return $this->render('sortie/show.html.twig', [
            'sortie' => $sortie,
        ]);
    }

    /**
     * @Route("/{id}/join", name="sortie_join", methods={"GET"})
     * @param Sortie $sortie
     * @return Response
     */
    public function join(Sortie $sortie): Response
    {
        if ($this->getUser()) {
            $sortie->addInscrit($this->getUser());
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->render('sortie/show.html.twig', [
            'sortie' => $sortie,
        ]);
    }

    /**
     * @Route("/{id}/leave", name="sortie_leave", methods={"GET"})
     * @param Sortie $sortie
     * @return Response
     */
    public function leave(Sortie $sortie): Response
    {
        if ($this->getUser()) {
            $sortie->removeInscrit($this->getUser());
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->render('sortie/show.html.twig', [
            'sortie' => $sortie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sortie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sortie $sortie): Response
    {
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sortie_index');
        }

        return $this->render('sortie/edit.html.twig', [
            'sortie' => $sortie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sortie_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sortie $sortie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sortie->getId(), $request->request->get('_token'))) {
            $sortie->setEtat(new Etat());
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute('sortie_index');
    }
}
