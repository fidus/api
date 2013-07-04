<?php
namespace Fidus\Api;


interface IRequest {

	/**
	 * @return array
	 */
	public function getData();


	/**
	 * @return string
	 */
	public function getType();

}
