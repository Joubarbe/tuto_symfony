<?php


namespace OC\PlatformBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LabController extends Controller
{
    public function viewSlugAction($slug, $year, $_format)
    {
        $url = $this
            ->generateUrl("oc_platform_view", ["id" => 2], UrlGeneratorInterface::ABSOLUTE_URL);
        // Controller shortcut for: $this->get("router")->generate(...);

        $content = $this
            ->get("templating")
            ->render("OCPlatformBundle:Lab:index.html.twig", [
                "name" => "winzou",
                "url" => $url, "advert_id" => 3,
                "slug" => $slug,
                "year" => $year,
                "format" => $_format,
            ]);

        return new Response($content);
    }
}