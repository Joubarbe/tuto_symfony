<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        // we hardcode ads for the purpose of the exercise
        $ads = [
            ["title" => "Article N°1", "content" => "Contenu de l'article n°1"],
            ["title" => "Article N°2", "content" => "Contenu de l'article n°2"],
            ["title" => "Article N°3", "content" => "Contenu de l'article n°3"],
        ];

        return $this->render('CoreBundle:Home:index.html.twig', ["ads" => $ads]);
    }

    public function contactAction()
    {
        $this->addFlash("info", "La page de contact n’est pas encore disponible, merci de revenir plus tard.");

        return $this->redirectToRoute("core_homepage");
    }
}
