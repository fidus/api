<?php

namespace ApiTests;


class RechargeCreditTest extends TestCase
{


	function setUp()
	{
	}


	function testCrude()
	{
		$customerId = 'asdf1234';
		$rechargeCredit = 20.00;
		$totalCredit = 35.50;
		$date = new \DateTime();

		$rechargeCreditRequest = new \Fidus\Api\RechargeCredit($customerId, $rechargeCredit, $totalCredit, $date);


		$expected = array(
			'customerId' => $customerId,
			'rechargeCredit' => $rechargeCredit,
			'totalCredit' => $totalCredit,
			'date' => $date->format('Y-m-d H:i:s')
		);

		$this->assertEquals($expected, $rechargeCreditRequest->getData());
	}

}
