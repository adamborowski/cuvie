<?php

namespace RestBundle\Controller;

use AppBundle\Entity\Person;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\HttpFoundation\Request;

/**
 * @RouteResource("persons")
 */
class PersonController extends FOSRestController implements ClassResourceInterface
{
    public function optionsAction()
    {
    } // "options_users" [OPTIONS] /users

    public function cgetAction()
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        return $this->getDoctrine()->getRepository("AppBundle\\Entity\\Person")->findAll();
    }

    public function postAction(Request $request)
    {
        $person = new Person();
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        $form->submit($person);
        if($form->isValid()){
            return "OK";
        }
        return "NIE OK";
    } // "post_users"    [POST] /users

    public function cpatchAction()
    {
    } // "patch_users"   [PATCH] /users

    public function getAction(Person $person)
    {
        return $person;
    } // "get_user"      [GET] /users/{slug}

    public function editAction($slug)
    {
    } // "edit_user"     [GET] /users/{slug}/edit

    public function putAction($slug)
    {
    } // "put_user"      [PUT] /users/{slug}

    public function patchAction($slug)
    {
    } // "patch_user"    [PATCH] /users/{slug}

    public function lockAction($slug)
    {
    } // "lock_user"     [PATCH] /users/{slug}/lock

    public function banAction($slug)
    {
    } // "ban_user"      [PATCH] /users/{slug}/ban

    public function removeAction($slug)
    {
    } // "remove_user"   [GET] /users/{slug}/remove

    public function deleteAction($slug)
    {
    } // "delete_user"   [DELETE] /users/{slug}

}
