<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Withdraw') }}
        </h2>
        <p>You current balance is: Rp. {{ number_format(auth()->user()->balance) }}</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('withdraw.store') }}" method="post">
                    	@csrf
                    	<div>
			                <x-label for="balance" :value="__('Withdraw Balance')" />

			                <x-input min="0" id="balance" class="mt-1 w-full" type="number" name="balance" :value="old('balance')" required autofocus />

			                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
					        </ul>

					        @if (session()->has("message"))
						        <span class="mt-3 text-sm text-red-600">
						        	{{ session('message') }}	
						        </span>
					        @endif
			            </div>

		                <div class="flex items-center justify-end mt-4">

			                <x-button class="ml-3">
			                    {{ __('Withdraw') }}
			                </x-button>
			            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col">
	  	<div class="my-2 overflow-x-auto sm:mx-6 lg:mx-8">
		    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
		      <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
		        <table class="min-w-full divide-y divide-gray-200">
		          <thead class="bg-gray-50">
		            <tr>

		              	<x-table-th>
		            		Created	
		              	</x-table-th>
		              	<x-table-th>
		              		Amount
		              	</x-table-th>
		              	<x-table-th>
		              		Admin Fee
		              	</x-table-th>
		              	<x-table-th>
		              		Status
		              	</x-table-th>
		            </tr>
		          </thead>
		          <tbody class="bg-white divide-y divide-gray-200">
		            	
		            	@forelse ($transactions as $transaction)
		            		<tr>

				            	<td class="px-6 py-4 whitespace-nowrap text-gray-700">
					                {{ $transaction->created_at->diffForHumans() }}
					            </td>
				              	<td class="px-6 py-4 whitespace-nowrap text-gray-700">
				                	Rp. {{ number_format($transaction->balance) }}	
				              	</td>
				              	<td class="px-6 py-4 whitespace-nowrap text-gray-700">
				              		Rp. {{ number_format($transaction->fee_admin) }}
				              	</td>
					            <td class="px-6 py-4 whitespace-nowrap mx-auto ">
					                
					                <div>
					                	@if ($transaction->status == "PAID")
						                	<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
							                  {{ \Str::upper($transaction->status) }}
							                </span>
					                	@else
					                		<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
							                  {{ \Str::upper($transaction->status) }}
							                </span>
					                		
					                	@endif
				                	</div>
				              	</td>
				            </tr>
		            	@empty
		            		<tr >
		            			<td class="text-center text-gray-700 text-w-bold" colspan="5">No data available</td>
		            		</tr>
		            	@endforelse

		          </tbody>
		        </table>
		      </div>
		    </div>
		</div>
	</div>
</x-app-layout>
