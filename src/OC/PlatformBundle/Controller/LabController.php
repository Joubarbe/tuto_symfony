<?php


namespace OC\PlatformBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LabController extends Controller
{
    public function viewSlugAction($slug, $year, $_format)
    {
        return new Response("slug/year/format = " . $slug . $year . $_format);
    }
}