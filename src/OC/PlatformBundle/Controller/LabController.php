<?php


namespace OC\PlatformBundle\Controller;


use OC\PlatformBundle\Entity\Advert;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LabController extends Controller
{
    public function indexAction($content)
    {
        echo "testing services";
        $antispam = $this->get("oc_platform.antispam");
        echo $antispam->isSpam("..."); // outputs 1
        echo $antispam->getHundred();  // outputs 100
        echo "<br>";

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

    public function addAction(Request $request)
    {
        $advert = new Advert();

        $advert->setTitle("Default Title");

        //$form = $this->get('form.factory')->createBuilder(FormType::class, $advert)
        $form = $this->createFormBuilder($advert)
            ->add('date', DateType::class)
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('author', TextType::class, ["label" => "Your Name"])
            ->add('published', CheckboxType::class, ['required' => false]) // all fields are "required" by default
            ->add('save', SubmitType::class)
            ->getForm();

        if ($request->isMethod('POST')) {
            // On fait le lien Requête <-> Formulaire
            // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
            $form->handleRequest($request);

            // On vérifie que les valeurs entrées sont correctes
            if ($form->isValid()) {
                // On enregistre notre objet $advert dans la base de données, par exemple
                $em = $this->getDoctrine()->getManager();
                $em->persist($advert);
                $em->flush();

                $this->addFlash('notice', 'Annonce bien enregistrée.');

                // On redirige vers la page de visualisation de l'annonce nouvellement créée
                return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
            }
        }

        // À ce stade, le formulaire n'est pas valide car :
        // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau
        return $this->render('OCPlatformBundle:Advert:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}