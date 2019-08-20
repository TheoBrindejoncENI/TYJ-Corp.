<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

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
        ]);
    }
}
