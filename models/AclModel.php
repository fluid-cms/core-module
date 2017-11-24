<?php

namespace Grapesc\GrapeFluid\CoreModule\Model;

use Grapesc\GrapeFluid\Model\BaseModel;


class AclModel extends BaseModel
{

	/**
	 * @param $namespace
	 * @param $resource
	 * @param $privilege
	 * @param $roles
	 */
	public function updateAcl($namespace, $resource, $privilege, $roles)
	{
		$this->getConnection()->beginTransaction();
		try {
			$this->getTableSelection()
				->where('namespace', $namespace)
				->where('resource', $resource)
				->where('privilege', $privilege)
				->delete();

			foreach ($roles as $role) {
				$this->insert([
					'namespace' => $namespace,
					'resource' => $resource,
					'privilege' => $privilege,
					'role' => $role
				]);
			}

			$this->getConnection()->commit();
		} catch (\Exception $e) {
			$this->getConnection()->rollBack();
			$this->logger->error('cannot update acl roles. ' . $e->getMessage());
		}
	}


	/**
	 * @param $namespace
	 * @param $resource
	 * @param $privilege
	 * @return array
	 */
	public function getRoles($namespace, $resource, $privilege)
	{
		return $this->getTableSelection()
			->select('role')
			->where('namespace', $namespace)
			->where('resource', $resource)
			->where('privilege', $privilege)
			->fetchPairs('role', 'role');
	}

}