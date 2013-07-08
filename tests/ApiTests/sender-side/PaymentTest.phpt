<?php

namespace ApiTests;


class PaymentTest extends TestCase
{


	function setUp()
	{
	}


	function testCrude()
	{
		$customerId = 'asdf1234';
		$totalPrice = 4.25;
		$remainingCredit = 33.50;
		$date = new \DateTime();

		$payment = new \Fidus\Api\Payment($customerId, $totalPrice, $remainingCredit, $date);


		$expected = array(
			'customerId' => $customerId,
			'totalPrice' => $totalPrice,
			'remainingCredit' => $remainingCredit,
			'date' => $date->format('Y-m-d H:i:s'),
			'items' => array(),
		);

		$this->assertEquals($expected, $payment->getData());

		$itemName = 'Presso';
		$itemPrice = 1.30;

		$payment->addItem($itemName, $itemPrice);

		$expected = array(
			'customerId' => $customerId,
			'totalPrice' => $totalPrice,
			'remainingCredit' => $remainingCredit,
			'date' => $date->format('Y-m-d H:i:s'),
			'items' => array(
				array('name' => $itemName, 'price' => $itemPrice, 'count' => 1)
			),
		);

		$this->assertEquals($expected, $payment->getData());
	}

}
