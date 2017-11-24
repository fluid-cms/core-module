<?php

namespace Grapesc\GrapeFluid\CoreModule\Service;

/**
 * @author Jiri Novy <novy@grapesc.cz>
 */
class BreadCrumbService
{

	/** @var array of links [title, link] */
	public $links = [];

	/** @var bool */
	private $visible = true;


	/**
	 * @param string $title
	 * @param string|null $link
	 */
	public function addLink($title, $link = NULL)
	{
		$this->links[md5($title . serialize($link))] = array(
			'title' => $title,
			'link'  => $link,
		);
	}

	/**
	 * @param string $title
	 * @param string|null $link
	 */
	public function removeLink($title, $link = null)
	{
		unset($this->links[md5($title . serialize($link))]);
	}


	/**
	 * remove all links
	 */
	public function clearLinks()
	{
		$this->links = [];
	}


	/**
	 * @return array of links [title, link]
	 */
	public function getLinks()
	{
		return $this->links;
	}


	public function hide()
	{
		$this->visible = false;
	}


	public function visible()
	{
		$this->visible = true;
	}


	/**
	 * @return bool
	 */
	public function isVisible()
	{
		return $this->visible;
	}

}
