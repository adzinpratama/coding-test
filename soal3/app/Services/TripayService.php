<?php 

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;

class TripayService {

	/**
	 * TRIPAY API KEY
	 * 
	 * @var string
	 */
	private $key;


	/**
	 * TRIPAY Base URL
	 * 
	 * @var string
	 */
	private $base_url = "https://tripay.co.id/api-sandbox/";


	public function __construct(){

		$this->key = config('tripay.key');
	}


	/**
	 * Get all payment channels
	 *
	 * @return array|mixed
	 */
	public function getPaymentChannels(){
		$res = Http::withToken($this->key)->get($this->base_url . 'merchant/payment-channel');


		if($res->failed()){
			return [
				'success' => false,
				'message' => 'Gagal mengambil payment channels'
			];
		}

		return $res->json();
	}


	/**
	 * Request a invoice to Tripay payment gateway
	 * 
	 * @return \Illuminate\Http\Client\Response
	 */
	public function create(
		User $user,
		$balance,
		$admin_fees,
		$payment_method,
		$merchant_ref
	): \Illuminate\Http\Client\Response{

		$total_fees = (int) $balance + (int) $admin_fees;

		$hashed = hash_hmac('sha256', 
				config('tripay.merchant_code') . 
				$merchant_ref . 
				$total_fees, 
				config('tripay.private_key')
			);


		$payload = [
			'method'         => $payment_method,
		    'merchant_ref'   => $merchant_ref,
		    'amount'         => $total_fees,
		    'customer_name'  => $user->name,
		    'customer_email' => $user->email,
		    'order_items' => [
		    	[
		            'name'        => 'Topup Rp. ' . number_format($balance),
		            'price'       => (int) $balance,
		            'quantity'    => 1,
				],
				[
					'name' => 'Admin Fees',
					'price' => (int) $admin_fees,
					'quantity' => 1
				]
		    ],
		    'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
		    'signature'    => $hashed
		];

		$res = Http::withToken($this->key)
				->post($this->base_url . 'transaction/create', $payload);

		return $res;
	}
}