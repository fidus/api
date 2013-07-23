<?php
namespace Fidus\Api;


class Token implements IRequest {

	const TYPE = 'token';

	/**
	 * @var string
	 */
	private $customerId;


	/**
	 * @param string $customerId
	 */
	public function __construct($customerId)
	{
		$this->customerId = $customerId;
	}


	/**
	 * @return array
	 */
	public function getData()
	{
		$data = array();

		$data['customerId'] = $this->customerId;

		return $data;
	}


	/**
	 * @return string
	 */
	public function getType()
	{
		return self::TYPE;
	}
}
