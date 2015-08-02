<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class ResourceRepository extends EntityRepository
{
    public function getRemaining($key)
    {
        $orders = $this->getEntityManager()->getRepository("AppBundle\\Entity\\Order")->findAll();
        $val = 0;
        foreach ($orders as $order) {
            if ($order->isDetailSet($key)) {
                $val += $order->getDetail($key);
            }
        }
        $total = $this->find($key)->getAvailable();
        if ($total == null) {
            return null;
        }
        return $total - $val;
    }
}