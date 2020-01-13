<?php

// Conduction/CommonGroundBundle/Service/PropertyService.php

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

class PropertyService
{
    private $em;

    public function __construct(EntityManagerInterface $em, ParameterBagInterface $params, CacheInterface $cache)
    {
        $this->em = $em;
        $this->params = $params;
        $this->cash = $cache;
    }

    public function getProperty($property)
    {
        $item = $this->cash->getItem('property_'.md5($property));
        if ($item->isHit()) {
            return $item->get();
        }

        $client = new Client([
            // You can set any number of default request options.
            'timeout'  => 4000.0,
        ]);

        $response = $client->request('GET', $property);

        $value = json_decode($response->getBody(), true);

        // We dont want to much relational information
        if (array_key_exists('_links', $value)) {
            unset($value['_links']);
        }
        if (array_key_exists('_embedded', $value)) {
            unset($value['_embedded']);
        }

        // Lets also strip empty values for easy reading

        // We dont want to much relational information
        if (array_key_exists('_links', $value)) {
            unset($value['_links']);
        }
        if (array_key_exists('_embedded', $value)) {
            unset($value['_embedded']);
        }

        // Lets also strip empty values for easy reading
        $value = array_filter($value, function ($test) {
            return !is_null($test) && $test !== '';
        });

        $item->set($value);
        $item->expiresAt(new \DateTime('tomorrow'));
        $this->cash->save($item);

        return $item->get();
    }

    public function validateProces(Proces $proces)
    {
    }
}
