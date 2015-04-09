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
        $start = \DateTime::createFromFormat('ymd', $this->container->getParameter("acq_start"));
        $end = \DateTime::createFromFormat('ymd', $this->container->getParameter("acq_end"));
        return $this->render('AppBundle:Default:index.html.twig', ['currencies' => $currencies, 'start' => $start, 'end' => $end]);
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
        $query = $em->createQuery("select max(e.value) as max_value, min(e.value) as min_value, avg(e.value) as avg_value from AppBundle\Entity\Entry e where e.currency=:currency");
        $query->setParameter("currency", $currency);
        $attrs = $query->getSingleResult();
        return $this->render('AppBundle:Default:preview.html.twig', ['currency' => $currency, 'attrs' => $attrs]);
    }

    /**
     * @Route("/search", name="search")
     * @param $str
     */
    public function searchAction()
    {
        $str = trim($this->getRequest()->get('str'));
        /**
         * @var $em EntityManager
         */

        if ($str == "") {
            $currencies = [];
        } else {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery("select max(e.value) as max_value, min(e.value) as min_value, avg(e.value) as avg_value, max(c.id) as id, max(c.label) as label from AppBundle\Entity\Entry e JOIN e.currency c
 where lower(c.id) like lower(:str) or lower(c.label) like lower(:str)
 group BY e.currency order by label asc");
            $query->setParameter("str", '%' . trim($str) . '%');
            $currencies = $query->getResult();
        }

        return $this->render('AppBundle:Default:index.html.twig', ['currencies' => $currencies, 'subject' => $str]);
    }
}
