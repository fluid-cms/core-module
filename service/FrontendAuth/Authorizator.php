<?php

namespace Grapesc\GrapeFluid\CoreModule\Service\FrontendAuth;


use Grapesc\GrapeFluid\CoreModule\Model\AclModel;
use Grapesc\GrapeFluid\Security\NamespacesRepository;
use Nette\DI\Container;
use Nette\Security\IAuthorizator;

/**
 * @author Jiri Novy <novy@grapesc.cz>
 */
class Authorizator implements IAuthorizator
{

	const MODE_OPTIMISTIC  = 'optimistic';
	const MODE_PESSIMISTIC = 'pessimistic';

	/** @var AclModel */
	private $aclModel;

	/** @var Container */
	private $container;

	/** @var NamespacesRepository */
	private $namespacesRepository;

	private $mode;


	/**
	 * Authorizator constructor.
	 * @param String $mode
	 * @param AclModel $aclModel
	 * @param Container $container
	 */
	public function __construct($mode, AclModel $aclModel, Container $container)
	{
		$this->mode      = $mode;
		$this->aclModel  = $aclModel;
		$this->container = $container;

		$this->checkMode();
	}


	/**
	 * Performs a role-based authorization.
	 * @param  string|null
	 * @param  string|null
	 * @param  string|null
	 * @return bool
	 */
	function isAllowed($role, $resource, $privilege)
	{
		if ($this->mode == self::MODE_OPTIMISTIC) {
			$roles = $this->aclModel->getTableSelection()
				->select('role')
				->where('namespace', $this->getNamespaceRepository()->getCurrentNamespace())
				->where('resource', $resource)
				->where('privilege', $privilege)
				->fetchPairs('role', 'role');
			return count($roles) == 0 || array_key_exists($role, $roles);
		} elseif($this->mode == self::MODE_PESSIMISTIC) {
			return (bool) $this->aclModel->getTableSelection()
				->select('id')
				->where('namespace', $this->getNamespaceRepository()->getCurrentNamespace())
				->where('role', $role)
				->where('resource', $resource)
				->where('privilege', $privilege)
				->count();
		}
	}


	/**
	 * @return NamespacesRepository|object
	 */
	private function getNamespaceRepository()
	{
		if (!$this->namespacesRepository) {
			$this->namespacesRepository = $this->container->getByType(NamespacesRepository::class);
		}

		return $this->namespacesRepository;
	}


	/**
	 * @throws \Exception
	 */
	protected function checkMode()
	{
		if (!in_array($this->mode, [self::MODE_PESSIMISTIC, self::MODE_OPTIMISTIC])) {
			throw new \Exception("Authorizator mode '$this->mode' is not allowed");
		}
	}

}