<?php


namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdvertController extends Controller
{

    public function indexAction()
    {
        return new Response("index");
    }

    public function viewAction($id)
    {
        return new Response("ID de l'annonce : " . $id);
    }

}