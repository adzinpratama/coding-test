<?php 

return [

	/**
	 * The merchant code for tripay
	 * 
	 * @var number|mixed
	 */
	'merchant_code' => env('TRIPAY_MERCHANT_CODE'),


	/**
	 * The tripay key
	 * 
	 * @var string
	 */
	'key' => env('TRIPAY_API_KEY'),


	/**
	 * The tripay private key
	 * 
	 * @var string
	 */
	'private_key' => env('TRIPAY_PRIVATE_KEY'),
];