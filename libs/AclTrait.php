<?php

namespace Grapesc\GrapeFluid\CoreModule;


use Grapesc\GrapeFluid\CoreModule\Model\AclModel;
use Grapesc\GrapeFluid\Security\NamespacesRepository;

/**
 * @author Jiri Novy <novy@grapesc.cz>
 */
trait AclFormTrait
{

	/** @var AclModel @inject */
	public $aclModel;

	/** @var NamespacesRepository @inject */
	public $namespacesRepository;

	/** @var string */
	private $privilege;

	/** @var string */
	private $privilegeFormat;

	/** @var string */
	private $resource;


	/**
	 * @param string $resource
	 * @param string $privilege
	 * @param string $format
	 */
	public function addAclInput($resource, $privilege = "read", $format = "{privilege}.{id}")
	{
		$this->resource        = $resource;
		$this->privilege       = $privilege;
		$this->privilegeFormat = $format;
		$form                  = $this->getForm();

		//todo podpora vsech namespace
		$rolesRepository = $this->namespacesRepository->getRoles();
		$roles           = $rolesRepository->getRoles('frontend');
		if ($roles && count($roles) > 0) {
			$form->addGroup('ACL - řízení přístupu');
			$container = $form->addContainer('acl')->addContainer('frontend');
			$usedRoles = $this->aclModel->getRoles('frontend', $resource, $this->getPrivilege());
			foreach ($usedRoles as $role) {
				if (!array_key_exists($role, $roles)) {
					$roles[$role] = $role;
				}
			}

			$container->addMultiSelect("roles", "Zobrazit jen pro tyto role", $roles)
				->setDefaultValue($usedRoles);
		}

	}


	/**
	 * save acl
	 */
	public function saveAcl()
	{
		$privilege = $this->getPrivilege();
		$values    = $this->getForm()->getValues(true);
		if (array_key_exists('acl', $values)) {
			foreach ($values['acl'] as $namespace => $namespaceValues) {
				$this->aclModel->updateAcl($namespace, $this->resource, $privilege, $namespaceValues['roles']);
			}
		}
	}


	/**
	 * @return mixed
	 */
	protected function getPrivilege()
	{
		$id = $this->isEditMode() ? $this->getEditId() : $this->getCreatedId();
		return str_replace(['{privilege}', '{id}', '{resource}'], [$this->privilege, $id, $this->resource], $this->privilegeFormat);
	}

}