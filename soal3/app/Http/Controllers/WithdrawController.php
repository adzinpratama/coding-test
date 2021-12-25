<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;

class WithdrawController extends Controller
{

	private $admin_fees = 1200;
    
    public function index(){
        $transactions = auth()->user()
        			->transactions()
        			->where('type','withdraw')
        			->latest()
        			->get();

    	return view('withdraw.index', compact('transactions'));
    }

    public function store(Request $request, TransactionService $trasactionService){

    	$request->validate([
    		'balance' => 'required|numeric'
    	]);

    	if(auth()->user()->balance < $request->get('balance') || 
    		$request->get('balance') < 0){
    		return redirect()->back()->with('message', "Sorry, the balance not enough");
    	}


    	$withdraw = $trasactionService->withdraw(auth()->user(), $request->get('balance'), $this->admin_fees);

    	return redirect()->route('withdraw.index')->with('success', 'Berhasil withdraw');
    }
}
