<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("select max(e.value) as max_value, min(e.value) as min_value, avg(e.value) as avg_value, max(c.id) as id, max(c.label) as label from AppBundle\Entity\Entry e JOIN e.currency c group BY e.currency order by label asc");
        $currencies = $query->getResult();
        return $this->render('AppBundle:Default:index.html.twig', ['currencies' => $currencies]);
    }

    /**
     * @Route("/currency/{currencyCode}", name="preview")
     * @param $currencyCode
     */
    public function previewAction($currencyCode)
    {
        /**
         * @var $em EntityManager
         */
        $em = $this->getDoctrine()->getManager();
        $currency = $em->find("AppBundle\Entity\Currency", $currencyCode);
        return $this->render('AppBundle:Default:preview.html.twig', ['currency' => $currency]);
    }
}
