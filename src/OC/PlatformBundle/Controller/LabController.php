<?php


namespace OC\PlatformBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LabController extends Controller
{
    public function indexAction($content)
    {
        return $this->render("OCPlatformBundle:Lab:index.html.twig", ["content" => $content]);
    }

    public function viewSlugAction($slug, $year, $_format)
    {
        $url = $this
            ->generateUrl("oc_platform_view", ["id" => 2], UrlGeneratorInterface::ABSOLUTE_URL);
        // Controller shortcut for: $this->get("router")->generate(...);

        return $this
            ->render("OCPlatformBundle:Lab:view.html.twig", [
                "name" => "winzou",
                "url" => $url, "advert_id" => 3,
                "slug" => $slug,
                "year" => $year,
                "format" => $_format,
            ]);
        // Controller shortcut for: $this->get("templating")->render(...);

        // WARNING! $this->render() returns an HTTP response, $this->get("templating")->render() and
        // $this->renderView() does not (both do the same thing).
    }

    public function errorAction() // demo to explain the render() method of the templating service
    {
        $response = new Response();
        $response->setContent("404 custom error message"); // twig template would be managed here
        $response->setStatusCode(Response::HTTP_NOT_FOUND);

        return $response;
    }

    public function goHomeAction()
    {
        //$url = $this->generateUrl("oc_platform_home");
        //return $this->redirect($url);
        // bette solution when you know the route name:
        return $this->redirectToRoute("oc_platform_home");
    }

    public function encodeAction($param)
    {
        //return new JsonResponse(["param" => $param]);
        return $this->json(["param" => $param]); // better solution as it does not need to import JsonResponse
    }

    public function setSessionVarAction($var, $val, Request $request)
    {
        $session = $request->getSession();
        $session->set($var, $val);

        return new Response("<body>Check the profiler session section to see your var.</body>");
    }

    public function setFlashBagAction($value)
    {
        $this->addFlash("info", "This is a message from the flashbag! (and a value: $value)");
        $this->addFlash("info", "Refresh this page to empty the flashbag");

        return $this->redirectToRoute("oc_platform_home_lab");
    }
}