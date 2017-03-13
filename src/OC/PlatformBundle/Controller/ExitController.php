<?php


namespace OC\PlatformBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ExitController extends Controller
{
    public function indexAction()
    {
        $content = $this
            ->get("templating")
            ->render("OCPlatformBundle:Exit:index.html.twig", ["name" => "winzou"]);

        return new Response($content);
    }
}