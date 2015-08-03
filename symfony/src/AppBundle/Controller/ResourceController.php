<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Resource;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class ResourceController extends Controller
{
    /**
     * @Route("/resources", name="resources")
     */
    public function indexAction()
    {
        $repo = $this->getDoctrine()->getRepository("AppBundle\\Entity\\Resource");
        $resources = $repo->findBy([], ['order' => 'ASC']);
        foreach ($resources as $resource) {
            $resource->setRemaining($repo->getRemaining($resource->getId()));
        }
        return $this->render('AppBundle:Resource:index.html.twig', ['resources' => $resources]);
    }

    /**
     * @Route("/resources/{id}", name="resource")
     */
    public function resourceAction($id)
    {
        $repo = $this->getDoctrine()->getRepository("AppBundle\\Entity\\Resource");
        $resource = $repo->find($id);
        return $this->render('AppBundle:Resource:view.html.twig', ['resource' => $resource]);
    }

    /**
     * @Route("/createResource", name="createResource")
     */
    public function createResourceAction()
    {
        return $this->render('AppBundle:Resource:view.html.twig', []);
    }

    /**
     * @Route("/updateResource", name="updateResource")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function updateResourceAction(Request $request)
    {
        $content = json_decode($request->getContent());
        $repo = $this->getDoctrine()->getRepository("AppBundle\\Entity\\Resource");
        /* @var $resource \AppBundle\Entity\Resource */
        if ($request->get("mode") == "create") {
            $resource = new Resource();
            $resource->setId($content->id);
        } else {
            $resource = $repo->find($content->id);
            if ($resource == null) {
                throw new NotFoundHttpException("Resource not found");
            }
        }
        //
        $resource->setLabel($content->label);
        if (isset($content->longLabel)) $resource->setLongLabel($content->longLabel);
        $resource->setDesc($content->desc);
        if (isset($content->unitPrice)) $resource->setUnitPrice(intval($content->unitPrice));
        if (isset($content->available)) $resource->setAvailable($content->available);
        //
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($resource);
        $em->flush();
        return new Response('OK', Response::HTTP_OK);
    }

    /**
     * @Route("/resources/{id}/remove", name="removeResource")
     * @param $id
     * @return Response
     */
    public function removeResourceAction($id)
    {
        $repo = $this->getDoctrine()->getRepository("AppBundle\\Entity\\Resource");
        /* @var $resource \AppBundle\Entity\Resource */
        $resource = $repo->find($id);
        if ($resource == null) {
            throw new NotFoundHttpException("Resource not found");
        }
        //
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($resource);
        $em->flush();
        return $this->redirect($this->generateUrl('resources'));
    }

}
