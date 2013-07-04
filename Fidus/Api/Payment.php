<?php
namespace Fidus\Api;


class Payment implements IRequest {

	const TYPE = 'payment';

	/**
	 * @var string
	 */
	private $customerId;


	/**
	 * @var float
	 */
	private $totalPrice;


	/**
	 * @var float
	 */
	private $remainingCredit;


	/**
	 * @var \DateTime
	 */
	private $date;

	/**
	 * @var array
	 */
	private $items = array();


	/**
	 * @param string $customerId
	 * @param $totalPrice
	 * @param $remainingCredit
	 * @param \DateTime $date
	 */
	public function __construct($customerId, $totalPrice, $remainingCredit, \DateTime $date = NULL)
	{
		$this->customerId = $customerId;
		$this->totalPrice = $totalPrice;
		$this->remainingCredit = $remainingCredit;
		$this->date = $date ? $date : new \DateTime();
	}


	/**
	 * @param string $name
	 * @param int|float $price
	 * @param int $count
	 *
	 * @return $this
	 */
	public function addItem($name, $price, $count = 1)
	{
		$this->items[] = array(
			'name' => $name,
			'price' => $price,
			'count' => $count,
		);

		return $this;
	}


	/**
	 * @return array
	 */
	public function getItems()
	{
		return $this->items;
	}


	/**
	 * @return array
	 */
	public function getData()
	{
		$data = array();

		$data['customerId'] = $this->customerId;
		$data['totalPrice'] = $this->totalPrice;
		$data['remainingCredit'] = $this->remainingCredit;
		$data['date'] = $this->date->format('Y-m-d H:i:s');

		$data['items'] = $this->getItems();

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
