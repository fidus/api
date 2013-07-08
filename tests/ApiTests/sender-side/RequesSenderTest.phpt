<?php

namespace ApiTests;


class RequestSenderTest extends TestCase
{
	protected $publicKey = 'testPublicKey';
	protected $secretKey = 'testSecretKey';

	protected $sendToUrl = 'http://fidus.com/api';


	/**
	 * @var \Fidus\Api\RequestSender
	 */
	protected $sender;


	function setUp()
	{
		$this->sender = new \Fidus\Api\RequestSender($this->publicKey, $this->secretKey);
		$this->sender->setUrl($this->sendToUrl);
	}


	function testUrl()
	{
		$customerId = 'asdf1234';
		$totalPrice = 4.25;
		$remainingCredit = 33.50;
		$date = new \DateTime('2013-02-15');

		$payment = new \Fidus\Api\Payment($customerId, $totalPrice, $remainingCredit, $date);

		$itemName = 'Presso';
		$itemPrice = 1.30;

		$payment->addItem($itemName, $itemPrice);

		$signedUrl = $this->sender->getSignedUrl($payment->getType(), $payment->getData());

		$expectedUrl = 'http://fidus.com/api/payment?sign=9757ee00f6331d96e070a1868a1b4ce60a17cce1&pk=testPublicKey';
		$this->assertEquals($expectedUrl, $signedUrl);
	}


	function testRecharge()
	{
		$customerId = 'asdf1234';
		$recharge = 20.00;
		$totalCredit = 35.00;
		$date = new \DateTime();

		$rechargeCredit = new \Fidus\Api\RechargeCredit($customerId, $recharge, $totalCredit, $date);

		$response = $this->sender->sendRequest($rechargeCredit);

		$this->assertEquals('{"success":true}', $response);

	}


	function testPayment()
	{
		$customerId = 'asdf1234';
		$totalPrice = 1.50;
		$remainingCredit = 33.50;
		$date = new \DateTime();

		$payment = new \Fidus\Api\Payment($customerId, $totalPrice, $remainingCredit, $date);

		$itemName = 'Presso';
		$itemPrice = 1.30;

		$payment->addItem($itemName, $itemPrice);

		$response = $this->sender->sendRequest($payment);

		$this->assertEquals('{"success":true}', $response);
	}

}
