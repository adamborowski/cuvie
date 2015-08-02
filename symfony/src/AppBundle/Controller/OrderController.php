<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Order;
use MyProject\Proxies\__CG__\stdClass;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\DateTime;

class OrderController extends Controller
{
    /**
     * @Route("/", name="orders")
     */
    public function indexAction()
    {
        $repo = $this->getDoctrine()->getRepository("AppBundle\\Entity\\Order");
        $orders = $repo->findBy([], ['creationDate' => 'DESC']);

        $resourcesRepo = $this->getDoctrine()->getRepository("AppBundle\\Entity\\Resource");
        $resources = $resourcesRepo->findBy([], ['order' => 'ASC']);
        $resMap = [];
        $summary = [];
        $summary['transport'] = 0;
        $transport = 0;
        foreach ($resources as $resource) {
            $resMap[$resource->getId()] = $resource;
            $resource->setRemaining($resourcesRepo->getRemaining($resource->getId()));
            $summary[$resource->getId()] = 0;
        }
        foreach ($orders as $order) {
            foreach ($order->getDetails() as $name => $detail) {
                $summary[$name] += $detail;
            }
            if ($order->getDetail('transport') == "provided") {
                $transport += $order->getDetail('liczbaDzieci') + $order->getDetail('liczbaDoroslych');
            }
        }
        $summary['autokar'] = $transport;

        return $this->render('AppBundle:Order:index.html.twig', [
            'orders' => $orders,
            'resources' => $resources,
            'map' => $resMap,
            'summary' => $summary
        ]);
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
     * @Route("/editOrder/{id}", name="editOrder")
     * @param $id
     * @return Response
     */
    public function editOrderAction($id)
    {
        $resourcesRepo = $this->getDoctrine()->getRepository("AppBundle\\Entity\\Resource");
        $resources = $resourcesRepo->findAll();
        $orderRepo = $this->getDoctrine()->getRepository("AppBundle\\Entity\\Order");
        $order = $orderRepo->find($id);
        $resMap = [];
        foreach ($resources as $resource) {
            $resMap[$resource->getId()] = $resource;
            $resource->setRemaining($resourcesRepo->getRemaining($resource->getId()));
        }
        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));
        $json = $serializer->serialize($resMap, 'json');
        $orderJson = $serializer->serialize($order, 'json');
        return $this->render('AppBundle:Order:createOrder.html.twig', [
            'map' => $resMap,
            'json' => $json,
            'order' => $order,
            'orderJson' => $orderJson
        ]);
    }

    /**
     * @Route("/submitOrder", name="submitOrder")
     * @Method("POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function submitOrderAction(Request $request)
    {
        $content = json_decode($request->getContent());
        if (isset($content->id)) {
            $order = $this->getDoctrine()->getRepository("AppBundle\\Entity\\Order")->find($content->id);
            $order->setDetails([]);
        } else {
            $order = new Order();
        }
        $order->setFirstName($content->firstName);
        $order->setLastName($content->lastName);
        $order->setCreationDate(new \DateTime());
        $order->setEmail($content->email);
        $order->setTotalPrice($content->totalPrice);
        $order->setDetail("transport", $content->transport);
        //todo zabezpieczyc rezerowania wiecej niz mozna (wspolbieznosc, bledy w UI)
        foreach (get_object_vars($content->details) as $name => $detail) {
            $order->setDetail($name, $detail);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($order);
        $em->flush();
        return new Response('OK', Response::HTTP_OK);
    }

    /**
     * @Route("/removeOrder/{id}", name="removeOrder")
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeOrderAction($id)
    {
        $order = $this->getDoctrine()->getRepository("AppBundle\\Entity\\Order")->find($id);
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($order);
        $em->flush();
        return $this->redirect($this->generateUrl('orders'));
    }
}
