<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantType;
use App\Repository\ParticipantRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/participant")
 */
class ParticipantController extends Controller
{
    /**
     * @Route("/", name="participant_index", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN')")
     * @param ParticipantRepository $participantRepository
     * @return Response
     */
    public function index(ParticipantRepository $participantRepository): Response
    {
        return $this->render('participant/index.html.twig', [
            'participants' => $participantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="participant_new", methods={"GET","POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $pwdEncoder
     * @return Response
     */
    public function new(Request $request, UserPasswordEncoderInterface $pwdEncoder): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('sortie_index');
        }
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pwd = $pwdEncoder->encodePassword($participant, $participant->getMotDePasse());
            $participant->setMotDePasse($pwd);
            $participant->setIsAdmin(false);
            $participant->setIsActif(true);
            $participant->setImage(file_get_contents($form['image']->getData()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participant);
            $entityManager->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('participant/new.html.twig', [
            'participant' => $participant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="participant_show", methods={"GET"})
     * @Security("is_granted('ROLE_USER')")
     * @param Participant $participant
     * @return Response
     */
    public function show(Participant $participant): Response
    {
        return $this->render('participant/show.html.twig', [
            'participant' => $participant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="participant_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_USER')")
     * @param Request $request
     * @param Participant $participant
     * @param UserPasswordEncoderInterface $pwdEncoder
     * @return Response
     */
    public function edit(Request $request, Participant $participant, UserPasswordEncoderInterface $pwdEncoder): Response
    {
        if ($this->getUser()->getId() != $participant->getId()) {
            return $this->redirectToRoute('participant_show', ["id" => $participant->getId()]);
        }
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!empty($form['motDePasse']->getData())) {
                $pwd = $pwdEncoder->encodePassword($participant, $participant->getMotDePasse());
                $participant->setMotDePasse($pwd);
            }

            if (!empty($form['image']->getData())) {
                $participant->setImage(file_get_contents($form['image']->getData()));
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('participant_show', ["id" => $participant->getId()]);
        }

        return $this->render('participant/edit.html.twig', [
            'participant' => $participant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="participant_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_USER')")
     * @param Request $request
     * @param Participant $participant
     * @return Response
     */
    public function delete(Request $request, Participant $participant): Response
    {
        if ($this->getUser()->getId() != $participant->getId()) {
            return $this->redirectToRoute('participant_show', ["id" => $participant->getId()]);
        }
        if ($this->isCsrfTokenValid('delete'.$participant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($participant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }
}
