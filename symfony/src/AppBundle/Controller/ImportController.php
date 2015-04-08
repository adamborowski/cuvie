<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ImportController extends Controller
{
    /**
     * @Route("/import", name="import")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Import:index.html.twig');
    }

    private function fetchDir()
    {
        $nbp_index_url = $this->container->getParameter('nbp_index');
        
    }
}
