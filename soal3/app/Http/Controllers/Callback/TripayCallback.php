<?php

namespace App\Http\Controllers\Callback;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Services\TransactionService;

class TripayCallback extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, TransactionService $transactionService)
    {	
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        
        $signature = hash_hmac('sha256', $json, config('tripay.private_key'));

        if ($signature !== (string) $callbackSignature) {
            // return '';
            return response()->error([
        		'message' => 'Invalid signature'
        	]);
        }

        if ('payment_status' !== (string) $request->server('HTTP_X_CALLBACK_EVENT')) {
            // return '/';
            return response()->error([
        		'message' => 'Invalid callback event, no action was taken'
        	]);
        }

        $data = json_decode($json);


        $merchantRef = $data->merchant_ref;

        $transaction = Transaction::where('data->merchant_ref', $merchantRef)
            ->where('status', 'UNPAID')
            ->first();

        if (! $transaction) {
            return 'transaction not found or current status is not UNPAID';
        }

        if ((int) $data->total_amount !== (int) $transaction->total_amount) {
            echo $transaction->total_amount;
            echo '\n';
            echo $data->total_amount;
            return 'Invalid amount';
        }

        switch ($data->status) {
            case 'PAID':
            	$transactionService->setPaid($transaction);
                return response()->json(['success' => true]);

            case 'EXPIRED':
            	$transactionService->setExpired($transaction);

                return response()->json(['success' => true]);

            case 'FAILED':
            	$transactionService->setFailed($transaction);
                return response()->json(['success' => true]);

            default:
                return 'Unrecognized payment status';
        }
    }
}
