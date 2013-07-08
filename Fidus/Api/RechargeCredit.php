<?php

namespace Fidus\Api;


class RechargeCredit implements IRequest {

	const TYPE = 'recharge-credit';

	/**
	 * @var
	 */
	private $customerId;

	/**
	 * @var
	 */
	private $rechargeCredit;

	/**
	 * @var
	 */
	private $totalCredit;

	/**
	 * @var \DateTime
	 */
	private $date;


	/**
	 * @param $customerId
	 * @param $rechargeCredit
	 * @param $totalCredit
	 * @param \DateTime $date
	 */
	public function __construct($customerId, $rechargeCredit, $totalCredit, \DateTime $date = NULL)
	{

		$this->customerId = $customerId;
		$this->rechargeCredit = $rechargeCredit;
		$this->totalCredit = $totalCredit;
		$this->date = $date ? $date : new \DateTime();
	}

	/**
	 * @return array
	 */
	public function getData()
	{
		$data = array();

		$data['customerId'] = $this->customerId;
		$data['rechargeCredit'] = $this->rechargeCredit;
		$data['totalCredit'] = $this->totalCredit;
		$data['date'] = $this->date->format('Y-m-d H:i:s');

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
