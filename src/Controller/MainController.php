<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Participant;

class MainController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        dump($this->getUser());
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'participant' => $this->getUser(),
        ]);
    }
}
