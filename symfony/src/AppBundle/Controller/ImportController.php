<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Currency;
use AppBundle\Entity\Entry;
use Lsw\ApiCallerBundle\Call\HttpGetHtml;
use Lsw\ApiCallerBundle\Call\HttpGetJson;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DomCrawler\Crawler;

class ImportController extends Controller
{
    private $start, $end, $em, $currencies = [];

    /**
     * @Route("/import", name="import")
     */
    public function indexAction()
    {
        $this->start = $this->container->getParameter("acq_start");
        $this->end = $this->container->getParameter("acq_end");
        //
        $this->em = $this->getDoctrine()->getManager();
        $this->em->createQuery('DELETE FROM AppBundle\Entity\Entry m')->execute();
        $this->em->createQuery('DELETE FROM AppBundle\Entity\Currency c')->execute();
        $this->em->clear();
        //
        $dir = $this->fetchDir();
        $validFiles = $this->getValidFiles($dir);
        $this->importValidFiles($validFiles);
        $this->em->flush();//flush any operations to db
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
     * @return String[]
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
                if ($entryDate >= $start && $entryDate <= $end) {
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
        $response = $this->get('api_caller')->call(new HttpGetHtml($url, null));
        $crawler = new Crawler();
        $crawler->addXmlContent($response);
        $date = new \DateTime($crawler->filter('data_publikacji')->text());
        foreach ($crawler->filter('pozycja') as $dom) {
            $currency = $this->ensureCurrency($dom);
            $this->addRecord($dom, $date, $currency);
        };
    }

    private function ensureCurrency(\DOMElement $dom)
    {
        $id = $dom->getElementsByTagName('kod_waluty')->item(0)->nodeValue;
        if (!array_key_exists($id, $this->currencies)) {
            $instance = new Currency();
            $instance->setId($id);
            $instance->setLabel($dom->getElementsByTagName('nazwa_waluty')->item(0)->nodeValue);
            $this->em->persist($instance);
            $this->currencies[$id] = $instance;
        }
        return $this->currencies[$id];
    }

    private function addRecord(\DOMElement $dom, \DateTime $date, Currency $currency)
    {
        $id = $dom->getElementsByTagName('kod_waluty')->item(0)->nodeValue;
        $instance = new Entry();
        $instance->setCurrency($currency);
        $instance->setDate($date);
        $txtValue = $dom->getElementsByTagName('kurs_sredni')->item(0)->nodeValue;
        $instance->setValue(str_replace(',', '.', $txtValue));
        $this->em->persist($instance);
        return $instance;
    }

}
