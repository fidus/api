<?php

namespace Fidus\Api;


class RequestSender {


	private $url = 'http://vernizakaznik.sk/api';

	private $publicKey;

	private $secretKey;


	/**
	 * @param $publicKey
	 * @param $secretKey
	 */
	public function __construct($publicKey, $secretKey)
	{

		$this->publicKey = $publicKey;
		$this->secretKey = $secretKey;
	}


	/**
	 * @param IRequest $request
	 *
	 * @return mixed
	 */
	public function sendRequest(IRequest $request)
	{
		$data = $request->getData();
		$type = $request->getType();

		return $this->sendCurl($type, $data);
	}


	/**
	 * @internal
	 *
	 * @param $url
	 */
	public function setUrl($url)
	{
		$this->url = $url;
	}


	/**
	 * @internal
	 *
	 * @param $type
	 * @param $encodedData
	 *
	 * @return string
	 */
	public function getSignedUrl($type, $encodedData)
	{
		$sign = $this->generateSign($encodedData);
		return $this->url . '/' . $type . '?sign=' . $sign . '&pk=' . $this->publicKey;
	}


	/**
	 * @param array $encodedData
	 *
	 * @return array
	 */
	private function generateSign($encodedData)
	{
		$sign = sha1( $encodedData . $this->secretKey);
		return $sign;
	}


	/**
	 * @param $type
	 * @param $data
	 *
	 * @return mixed
	 */
	private function sendCurl($type, array $data)
	{

		$encodedData = json_encode($data);

		$signedUrl = $this->getSignedUrl($type, $encodedData);
		$ch = curl_init($signedUrl);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen(json_encode($data))
			)
		);

		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}
}
