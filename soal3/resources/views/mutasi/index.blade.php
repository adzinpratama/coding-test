<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mutasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex flex-col">
                        <div class="my-2 overflow-x-auto sm:mx-6 lg:mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <x-table-th>Describe</x-table-th>
                                                <x-table-th>
                                                    type
                                                </x-table-th>
                                                <x-table-th>
                                                    Nominal
                                                </x-table-th>
                                                <x-table-th>
                                                    Fee
                                                </x-table-th>
                                                <x-table-th>
                                                    Last Balance
                                                </x-table-th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">

                                            @forelse ($mutations as $mutation)
                                                <tr>
                                                    <td class="px-4 py-2 whitespace-nowrap text-gray-600">
                                                        {{ $mutation->type == 'topup' ? Str::ucfirst($mutation->type) . ' Ref: ' . $mutation->data['reference'] : Str::ucfirst($mutation->type) . ' To Self' }}
                                                    </td>

                                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                                        {{ $mutation->type }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                                        Rp. {{ number_format($mutation->balance) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                                        Rp. {{ number_format($mutation->fee_admin) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                                        Rp. {{ number_format($mutation->total_amount) }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-center text-gray-700 text-w-bold" colspan="5">No
                                                        data available</td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
