<?php
namespace AppBundle\Twig;


class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('highlight', array($this, 'highlightFilter')),
        );
    }

    public function highlightFilter($text, $str)
    {
        if($str==""){
            return $text;
        }
        $text = preg_replace("/($str)/i", "<span class=a-highlight>$1</span>", $text);
        return $text;
    }

    public function getName()
    {
        return 'app_extension';
    }
}