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

class PersonController extends ControllerBase
{
    /**
     * @Route("/persons", name="persons")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Person:index.html.twig', []);
    }
}
