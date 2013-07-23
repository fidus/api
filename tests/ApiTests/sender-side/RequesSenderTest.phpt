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
		$date = new \DateTime('2013-02-15');

		// get Token
		$token = new \Fidus\Api\Token($customerId);
		$response = $this->sender->sendRequest($token);
		$response = json_decode($response, TRUE);

		$payment = new \Fidus\Api\Payment($customerId, $totalPrice, $response['token'], $date);

		$itemName = 'Presso';
		$itemPrice = 1.30;

		$payment->addItem($itemName, $itemPrice);

		$signedUrl = $this->sender->getSignedUrl($payment->getType(), json_encode($payment->getData()), $payment->getToken());

		$expectedUrl = 'http://fidus.com/api/payment?sign=20a88556ef4c47a5e3b01025bed69f503f5d0f4d&pk=testPublicKey&token=1e6c8b769546e3e73dd2ef770e6427a77b7f4fae';
		$this->assertEquals($expectedUrl, $signedUrl);
	}


	function testRecharge()
	{
		$customerId = 'asdf1234';
		$recharge = 4.00;
		$date = new \DateTime();

		// get Token
		$token = new \Fidus\Api\Token($customerId);
		$response = $this->sender->sendRequest($token);
		$response = json_decode($response, TRUE);

		$rechargeCredit = new \Fidus\Api\RechargeCredit($customerId, $recharge, $date);

		$response = $this->sender->sendRequest($rechargeCredit, $response['token']);

		$this->assertEquals('{"success":true}', $response);

	}


	function testPayment()
	{
		$customerId = 'asdf1234';
		$totalPrice = 1.50;
		$date = new \DateTime();

		// get Token
		$token = new \Fidus\Api\Token($customerId);
		$response = $this->sender->sendRequest($token);
		$response = json_decode($response, TRUE);

		$payment = new \Fidus\Api\Payment($customerId, $totalPrice, $date);

		$itemName = 'Presso';
		$itemPrice = 1.30;

		$payment->addItem($itemName, $itemPrice);

		$response = $this->sender->sendRequest($payment, $response['token']);

		$this->assertEquals('{"success":true}', $response);
	}


	public function testToken()
	{
		$customerId = 'asdf1234';

		$token = new \Fidus\Api\Token($customerId);

		$response = $this->sender->sendRequest($token);

		$this->assertEquals('{"success":true,"token":"833ed2f6cb6ed25b10f7e2096584e3fc743d110d"}', $response);
	}

}
