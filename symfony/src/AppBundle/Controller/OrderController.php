<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
            $resource->setRemaining($repo->getRemaining($resource->getId()));
        }
        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));
        $json = $serializer->serialize($resMap, 'json');
        return $this->render('AppBundle:Order:createOrder.html.twig', ['map' => $resMap, 'json' => $json]);
    }

    /**
     * @Route("/submitOrder", name="submitOrder")
     * @Method("POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function submitOrderAction(Request $request)
    {
        
        return new Response('OK', Response::HTTP_OK);
    }
}
