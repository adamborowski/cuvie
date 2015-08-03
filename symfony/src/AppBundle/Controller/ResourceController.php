<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $resources = $repo->findBy([], ['order'=>'ASC']);
        foreach ($resources as $resource) {
            $resource->setRemaining($repo->getRemaining($resource->getId()));
        }
        return $this->render('AppBundle:Resource:index.html.twig', ['resources' => $resources]);
    }

}
