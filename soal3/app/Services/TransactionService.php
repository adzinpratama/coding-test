<?php 

namespace App\Services;

use DB;
use App\Models\Transaction;
use App\Models\TransactionLog;
use App\Models\User;

class TransactionService {


	private function _pay(Transaction $transaction, $status){
		DB::transaction(function() use ($transaction, $status){

			$transaction->update([
				'status' => $status
			]);

			$user = $transaction->user;

			$transaction->user()->update([
				'balance' => (int) $user->balance + (int) $transaction->balance 
			]);

			$transaction->logs()->create([
				'previous_balance' => $user->balance,
				'current_balance' => (int) $user->balance + (int) $transaction->balance,
				'status' => $status
			]);

		});	
		return true;
	}

	public function setPaid(Transaction $transaction){
		return $this->_pay($transaction, 'PAID');
	}

	public function setExpired(Transaction $transaction){
		return $this->_pay($transaction, 'EXPIRED');
	}

	public function setFailed(Transaction $transaction){
		return $this->_pay($transaction, 'FAILED');
	}



	public function withDraw(User $user, $balance, $admin_fees){

		DB::transaction(function() use($user, $balance, $admin_fees){
			$transaction = Transaction::create([
				'user_id' => $user->id,
				'type' => 'withdraw',
				'balance' => $balance,
				'fee_admin' => $admin_fees,
				'status' => "PAID",
				'data' => [],
				'total_amount' => $balance
			]);

			$user = $transaction->user;

			$transaction->user()->update([
				'balance' => (int) $user->balance - (int) $balance,
			]);

			$transaction->logs()->create([
				'previous_balance' => $user->balance,
				'current_balance' => (int) $user->balance - (int) $balance,
				'status' => "PAID"
			]);

		});
		return true;
	}
}