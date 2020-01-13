<?php

// Conduction/CommonGroundBundle/Service/RequestTypeService.php

/*
 * This file is part of the Conduction Common Ground Bundle
 *
 * (c) Conduction <info@conduction.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Entity\Proces;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Symfony\Component\Cache\Adapter\AdapterInterface as CacheInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class RequestTypeService
{
    private $em;

    public function __construct(EntityManagerInterface $em, ParameterBagInterface $params, CacheInterface $cache)
    {
        $this->em = $em;
        $this->params = $params;
        $this->cash = $cache;
    }

    public function getRequestType($requestType)
    {
        $item = $this->cash->getItem('requestType_'.md5($requestType));
        if ($item->isHit()) {
            return $item->get();
        }

        $client = new Client([
            // You can set any number of default request options.
            'timeout'  => 4000.0,
        ]);

        $response = $client->request('GET', $requestType);

        $value = json_decode($response->getBody(), true);

        $item->set($value);
        $item->expiresAt(new \DateTime('tomorrow'));
        $this->cash->save($item);

        return $item->get();
    }

    public function validateProces(Proces $proces)
    {
    }
}
