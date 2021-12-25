<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
    	
        <div class="min-h-screen bg-gray-100">

            @include('layouts.navigation')

            @if (session()->has('success'))
    	
				<div class="alert-success bg-green-100 opacity-75 text-center py-4 lg:px-4">
					<div class="p-2 bg-green-600 items-center text-green-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
					    <span class="flex rounded-full bg-green-500 uppercase px-2 py-1 text-xs font-bold mr-3">Success</span>
					    
					    <span class="font-semibold mr-2 text-left flex-auto">
					    	{{ session("success") }}
					    </span>
					    
					</div>
				</div>

				@push('js')
					<script>
						(function(){
							setTimeout(() => {
								document.querySelector('.alert-success').remove();
							}, 15000)
						})();
					</script>
				@endpush
		    @endif


            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>


        @stack('js')
    </body>
</html>
