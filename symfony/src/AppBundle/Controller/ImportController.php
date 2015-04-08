<?php

namespace AppBundle\Controller;

use Lsw\ApiCallerBundle\Call\HttpGetHtml;
use Lsw\ApiCallerBundle\Call\HttpGetJson;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ImportController extends Controller
{
    private $start, $end;

    /**
     * @Route("/import", name="import")
     */
    public function indexAction()
    {
        $this->start = $this->container->getParameter("acq_start");
        $this->end = $this->container->getParameter("acq_end");
        $dir = $this->fetchDir();
        $validFiles = $this->getValidFiles($dir);
        $this->importValidFiles($validFiles);
        return $this->render('AppBundle:Import:index.html.twig', [
            'dbg' => $validFiles,
            'start' => $this->start,
            'end' => $this->end,
        ]);

    }

    /**
     * @return String[]
     */
    private function fetchDir()
    {
        $nbp_index_url = $this->container->getParameter('nbp_index');
        $output = $this->get('api_caller')->call(new HttpGetHtml($nbp_index_url, null));
        return preg_split('/\r\n|\r|\n/', $output);
    }

    /**
     * @param $dir String[]
     */
    private function getValidFiles($dir)
    {
        $start = intval($this->start);
        $end = intval($this->end);
        $reg = '/a\d{3,3}z(\d{6,6})/';
        $validFiles = [];
        foreach ($dir as $entry) {
            preg_match($reg, $entry, $matches);
            if (count($matches) == 2) {
                $entryDate = $matches[1] + 0;//we have date of entry as a number
                if ($entryDate >= $start && $entry <= $end) {
                    $validFiles[] = $entry;
                }
            }
        }
        return $validFiles;
    }

    private function importValidFiles($validFiles)
    {
        $base = $this->container->getParameter("nbp_base");
        foreach ($validFiles as $file) {
            $url = "$base$file.xml";
            $sql = $this->importFile($url);
        }
    }

    private function importFile($url)
    {

    }

}
