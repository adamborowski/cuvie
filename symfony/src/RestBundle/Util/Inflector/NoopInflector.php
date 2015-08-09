<?php
namespace RestBundle\Util\Inflector;

use FOS\RestBundle\Util\Inflector\InflectorInterface;

/**
 * Inflector class
 *
 */
class NoopInflector implements InflectorInterface
{
    public function pluralize($word)
    {
        // Don't pluralize
        return $word;
    }
}