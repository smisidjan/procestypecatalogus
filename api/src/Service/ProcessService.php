<?php
// Conduction/CommonGroundBundle/Service/ProcessService.php

/*
 * This file is part of the Conduction Common Ground Bundle
 *
 * (c) Conduction <info@conduction.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Process;
use App\Service\PropertyService;
use App\Service\RequestTypeService;

class ProcessService
{
	private $em;
	private $propertyService;
	private $requestTypeService;
	
	public function __construct(EntityManagerInterface $em, PropertyService $propertyService, RequestTypeService $requestTypeService)
	{
		$this->em = $em;
		$this->propertyService = $propertyService;
		$this->requestTypeService = $requestTypeService;
	}
	
	public function extendProcess(Process $process)
	{
		$processesProcessed = [(string) $process->getId()];
		$extendedProces= $process->getExtends();
		$properties = [];
		
		/*
		// Let loop this for as long as we can extend requests
		while($extendedProces){
			// But kill it the moment we spot an invinate loop
			if(in_array((string) $extendedProces->getId(), $processesProcessed)){
				throw new \Exception('Proces '.$extendedProces->getName().'(id:'.(string) $extendedProces->getId().') has been referenced more then once in this extention, posible loop detected');
			}
			
			// lets add the id to the check array, so that we can prefend loops
			$processesProcessed[(string) $extendedProces->getId()] = true;
			
			// Then we need to do the actual extending
			foreach ($extendedProces->getStages() as $stage){
				
				
				if(in_array($stage->getProperty(), $properties)){
					throw new \Exception('There property titled '.$stage->getProperty().'is used more then once this extention');
				}
				
				
				$properties[$stage->getProperty()] = true;
				$proces->addProperty($property);
			}
			
			$proces = $extendedProces->getExtends();
		}
		*/
		$process = $this->getProcessProperties($process);
		
		return $process;
	}
	
	public function getProcessProperties(Process $process)
	{
		
		// Then we need to do the actual extending
		foreach ($process->getStages() as $stage){			
			$property = $this->propertyService->getProperty($stage->getProperty());
			$stage->setValidation($property);
		}
		
		return $process;
	}
	
	public function validateProcess(Process $process)
	{
	
	}
	
}
