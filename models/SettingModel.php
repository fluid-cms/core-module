<?php

namespace Grapesc\GrapeFluid\CoreModule\Model;

use Grapesc\GrapeFluid\Configuration\Crypt\ICrypt;
use Grapesc\GrapeFluid\Model\BaseModel;
use Grapesc\GrapeFluid\Model\CachedModel;
use Monolog\Logger;
use Nette\Caching\IStorage;
use Nette\Database\Context;

class SettingModel extends BaseModel
{

	use CachedModel;

	const
		VALUE_OK      = 1,
		VALUE_EMPTY   = 2,
		VALUE_DEFAULT = 3;

	/** @var ICrypt|null */
	private $crypt;


	/**
	 * SettingModel constructor.
	 * @param Context $context
	 * @param Logger $logger
	 * @param IStorage $storage
	 * @param ICrypt|null $crypt
	 */
	public function __construct(Context $context, Logger $logger, IStorage $storage, ICrypt $crypt = null)
	{
		parent::__construct($context, $logger, $storage);
		$this->crypt = $crypt;
	}


	public function startup()
	{
		$this->assocBy = 'variable';
	}


	/**
	 * @param $var
	 * @return mixed
	 */
	public function getVal($var)
	{
		return $this->getItem($var)['value'];
	}


	/**
	 * @param string $variable
	 * @return int SettingModel::VALUE_EMPTY|SettingModel::VALUE_DEFAULT|SettingModel::VALUE_OK
	 */
	public function isEmptyOrDefaultValue($variable)
	{
		$row          = $this->getItemBy($variable, 'variable');
		$defaultValue = $row['secured'] ? $this->crypt->encrypt($row['default_value']) : $row['default_value'];

		if (!$row || !$row['value']) {
			return self::VALUE_EMPTY;
		} elseif ($row['value'] == $defaultValue) {
			return self::VALUE_DEFAULT;
		} else {
			return self::VALUE_OK;
		}
	}

}