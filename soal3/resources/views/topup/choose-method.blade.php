<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Choose Payment Method') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto mx-start sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
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

                    <form action="{{ route('topup.store') }}" method="POST">
                    	@csrf
                    	<input type="hidden" name="balance" value="{{ $balance }}">


	                	@foreach ($methods['data'] as $method)

	                		@if ($method['active'])
		                    	<div class="m-2 p-2">

		                    		<div class="flex flex-col">
		                    			<label class="inline-flex items-center mt-3">
							                <input id="{{ $method['code'] }}" 
							                       name="method" 
							                       value="{{ $method['code'] }}" 
							                       type="radio" 
							                       class="form-checkbox h-5 w-5 text-gray-600"
							                       required>

							                <span class="ml-2 text-gray-700">
							                	{{ $method['name'] }}
							                </span>
							            </label>
		                    		</div>
		                    	</div>
	                			
	                		@endif

	                	@endforeach
	                    
	                    <div class="mt-3">
	                    	<x-button>
	                    		Submit
	                    	</x-button>
	                    </div>

                    </form>

                </div>
            </div>
        </div>

    </div>

</x-app-layout>
