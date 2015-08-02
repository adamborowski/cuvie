<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class OrderController extends Controller
{
    /**
     * @Route("/orders", name="orders")
     */
    public function indexAction()
    {
        $repo = $this->getDoctrine()->getRepository("AppBundle\\Entity\\Order");
        $orders = $repo->findBy([], ['date' => 'ASC']);
        return $this->render('AppBundle:Order:index.html.twig', ['resources' => $orders]);
    }

    /**
     * @Route("/createOrder", name="createOrder")
     */
    public function createOrderAction()
    {
        $repo = $this->getDoctrine()->getRepository("AppBundle\\Entity\\Resource");
        $resources = $repo->findAll();
        $resMap = [];
        foreach ($resources as $resource) {
            $resMap[$resource->getId()] = $resource;
        }
        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));
        $json = $serializer->serialize($resMap, 'json');
        return $this->render('AppBundle:Order:createOrder.html.twig', ['map' => $resMap, 'json' => $json]);
    }

}
