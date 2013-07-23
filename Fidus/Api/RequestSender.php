<?php

namespace Fidus\Api;


class RequestSender {


	/**
	 * @var string
	 */
	private $url = 'http://vernizakaznik.sk/api';

	/**
	 * @var string
	 */
	private $publicKey;

	/**
	 * @var string
	 */
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
	 * @param null $token
	 *
	 * @return mixed
	 */
	public function sendRequest(IRequest $request, $token = NULL)
	{
		$data = $request->getData();
		$type = $request->getType();

		return $this->sendCurl($type, $data, $token);
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
	 * @param null $token
	 *
	 * @return string
	 */
	public function getSignedUrl($type, $encodedData, $token = NULL)
	{
		if($token !== NULL) {
			$token = $this->encrypt($token);
		}

		$sign = $this->encrypt($encodedData);
		return $this->url . '/' . $type . '?sign=' . $sign . '&pk=' . $this->publicKey . '&token=' . $token;
	}


	/**
	 * @param array $encodedData
	 *
	 * @return array
	 */
	private function encrypt($encodedData)
	{
		$sign = sha1( $encodedData . $this->secretKey);
		return $sign;
	}


	/**
	 * @param $type
	 * @param array $data
	 * @param null $token
	 *
	 * @return mixed
	 */
	private function sendCurl($type, array $data, $token)
	{
		$encodedData = json_encode($data);

		$signedUrl = $this->getSignedUrl($type, $encodedData, $token);

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
