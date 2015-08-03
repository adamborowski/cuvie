<?php
namespace AppBundle\Twig;


use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('highlight', array($this, 'highlightFilter')),
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
            new \Twig_SimpleFilter('serialize', array($this, 'serializeFilter'), array('is_safe' => array('html'))),
        );
    }

    public function highlightFilter($text, $str)
    {
        if ($str == "") {
            return $text;
        }
        $text = preg_replace("/($str)/i", "<span class=a-highlight>$1</span>", $text);
        return $text;
    }

    public function priceFilter($text)
    {
        return "$text PLN";
    }

    public function serializeFilter($entity)
    {
        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));
        return $serializer->serialize($entity, 'json');
    }

    public function getName()
    {
        return 'app_extension';
    }
}