<?php


namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AdvertController extends Controller
{

    public function indexAction()
    {
        $url = $this
            ->generateUrl("oc_platform_view", ["id" => 2], UrlGeneratorInterface::ABSOLUTE_URL);
        // Controller shortcut for: $this->get("router")->generate(...);

        $content = $this
            ->get("templating")
            ->render("OCPlatformBundle:Advert:index.html.twig", ["name" => "winzou", "url" => $url, "advert_id" => 3]);

        return new Response($content);
    }

    public function viewAction($id)
    {
        return new Response("ID de l'annonce : " . $id);
    }

}