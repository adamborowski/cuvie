<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Order;
use MyProject\Proxies\__CG__\stdClass;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\DateTime;

class OrderController extends Controller
{
    /**
     * @Route("/orders", name="orders")
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
     * @Route("/", name="createOrder")
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
        return $this->render('AppBundle:Order:createOrder.html.twig', ['map' => $resMap]);
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
        return $this->render('AppBundle:Order:createOrder.html.twig', [
            'map' => $resMap,
            'order' => $order,
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
        try {

            $content = json_decode($request->getContent());
            if (isset($content->id)) {
                $order = $this->getDoctrine()->getRepository("AppBundle\\Entity\\Order")->find($content->id);
                $order->setDetails([]);
                $edit = true;
            } else {
                $order = new Order();
                $edit = false;
            }
            $order->setFirstName($content->firstName);
            $order->setLastName($content->lastName);
            $order->setCreationDate(new \DateTime());
            $order->setEmail($content->email);
            $order->setTotalPrice($content->totalPrice);
            $order->setDetail("transport", $content->transport);
            //todo zabezpieczyc rezerowania wiecej niz mozna (wspolbieznosc, bledy w UI)
            $resourceRepo = $this->getDoctrine()->getRepository("AppBundle\\Entity\\Resource");
            foreach (get_object_vars($content->details) as $name => $detail) {
                $remaining = $resourceRepo->getRemaining($name);
                if ($remaining == null || $remaining == 0 || $remaining >= $detail) {
                    $order->setDetail($name, $detail);
                } else if ($remaining < $detail) {
                    return new Response("Not enough resource $name: $remaining remaining but $detail requested.", 412);
                }
            }
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($order);
            $em->flush();
            $this->sendMail($order, $edit);
            return new Response('OK', Response::HTTP_OK);
        } catch (\Exception $error) {
            return new Response($error->getMessage(), 412);
        }
    }

    private function sendMail(Order $order, $edit)
    {
        $resourcesRepo = $this->getDoctrine()->getRepository("AppBundle\\Entity\\Resource");
        $resources = $resourcesRepo->findAll();
        $resMap = [];
        foreach ($resources as $resource) {
            $resMap[$resource->getId()] = $resource;
        }


        $cnt = $this->container;
        $message = \Swift_Message::newInstance()
            ->setSubject($edit ? "Zmiana Twojej rezerwacji" : "Potwierdzenie rejestracji")
            ->setFrom([$cnt->getParameter("respond1") => "System Rejestracji Lokomotywy"])
            ->setTo($order->getEmail())
            ->setBcc([$cnt->getParameter("respond1"), $cnt->getParameter("respond2")])
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    'AppBundle:Order:mail.html.twig',
                    ['edit' => $edit, 'order' => $order, 'res' => $resMap]
                ),
                'text/html'
            )/*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'Emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */
        ;
        $success = $this->get('mailer')->send($message);
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

    /**
     * @Route("/mailPreview/{id}", name="mailPreview")
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mailPreviewAction($id)
    {
        $resourcesRepo = $this->getDoctrine()->getRepository("AppBundle\\Entity\\Resource");
        $resources = $resourcesRepo->findAll();
        $resMap = [];
        foreach ($resources as $resource) {
            $resMap[$resource->getId()] = $resource;
        }
        $order = $this->getDoctrine()->getRepository("AppBundle\\Entity\\Order")->find($id);
        return $this->render("AppBundle:Order:mail.html.twig", ['order' => $order, 'res' => $resMap, 'edit' => true]);
    }
}
