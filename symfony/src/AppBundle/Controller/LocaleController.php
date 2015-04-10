<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LocaleController extends Controller
{
    /**
     * @Route("/switch_locale/{locale}", name="switch_locale")
     * @param $locale
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function switchLocaleAction($locale)
    {
        $this->getRequest()->getSession()->set("_locale", $locale);
        return $this->redirect($this->getRequest()->headers->get('referer'));
    }

}
