<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Str;
use App\Services\TripayService;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class TopupController extends Controller
{



	/**
	 * The admin fees to topup
	 * 
	 * @var number
	 */
	private $admin_fees = 1000; /** Rp. 1.000 */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = auth()->user()
        			->transactions()
        			->where('type','topup')
        			->latest()
        			->get();

        return view('topup.index', compact('transactions'));
    }


    /**
     * Show the list payment method
     * 
     * @return \Illuminate\Http\Response
     */
    public function choose_method(Request $request, TripayService $tripay)
    {

        $request->validate([
        	'balance' => 'required|numeric'
        ]);

        $methods = $tripay->getPaymentChannels();
        if(!$methods['success']){
        	return redirect()->back()->with('message', 'Error when get payment methods');
        }

        $balance = $request->get('balance');

        return view('topup.choose-method', compact('methods','balance'));
    }


    /**
     * Store new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TripayService $tripay)
    {
        $request->validate([
        	'balance' => 'required',
        	'method' => 'required'
        ]);


		$balance = (int) preg_replace('~\D~', '', e($request->get('balance')));


		// check is rate limiter no overflow
		if (RateLimiter::tooManyAttempts($this->limiterKey(), $perMinute = 5)) {
		    $seconds = RateLimiter::availableIn($this->limiterKey());

		    return redirect()->back()->with('message', "Terlalu cepat, harap tunggu " .$seconds . ' detik lagi!');
		}


		$merchant_ref = 'VO-'.Str::random(5);
		$method = $request->input('method', 'BRIVA');

		$response = $tripay->create(
			auth()->user(),
			$balance,
			$this->admin_fees,
			$method,
			$merchant_ref
		);

		$res = $response->object();

		if(!$res->success){

			return redirect()->back()->with('message', $res->message);
		}


		$super = $this;

		DB::transaction(function() use (&$super, $balance, $method, $res){

			$transaction = Transaction::create([
							'user_id' => auth()->id(),
							'type' => 'topup',
							'balance' => $balance,
							'fee_admin' => $super->admin_fees,
							'status' => $res->data->status,
							'data' => [
								'reference' => $res->data->reference,
								'merchant_ref' => $res->data->merchant_ref,
								'checkout_url' => $res->data->checkout_url
							],
							'total_amount' => $res->data->amount
						]);
			$transaction->logs()->create([
				'previous_balance' => auth()->user()->balance,
				'current_balance' => auth()->user()->balance,
				'status' => $res->data->status
			]);
		});

		return redirect()->to('/topup')->with('success', 'Berhasil dibuat. Silahkan selesaikan pembayaran');

    }



    /**
     * The limiter key for security
     * 
     * @return string
     */
    private function limiterKey(){
    	return 'transaction:' . request()->ip() . '@' . auth()->id();
    }
}
