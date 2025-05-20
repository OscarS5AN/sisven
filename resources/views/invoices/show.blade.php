<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invoice Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Invoice Information</h3>
                            <div class="mt-2">
                                <p><strong>Number:</strong> {{ $invoice->number }}</p>
                                <p><strong>Date:</strong> {{ $invoice->date->format('d/m/Y') }}</p>
                                <p><strong>Payment Mode:</strong> {{ $invoice->payMode->name }}</p>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
                            <div class="mt-2">
                                <p><strong>Name:</strong> {{ $invoice->customer->first_name }} {{ $invoice->customer->last_name }}</p>
                                <p><strong>Document:</strong> {{ $invoice->customer->document_number }}</p>
                                <p><strong>Email:</strong> {{ $invoice->customer->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-lg font-medium text-gray-900 mb-4">Items</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($invoice->details as $detail)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $detail->product->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $detail->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($detail->price, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($detail->quantity * $detail->price, 2) }}</td>
                                </tr>
                                @endforeach
                                <tr class="bg-gray-50">
                                    <td colspan="3" class="px-6 py-4 text-right font-bold">Total:</td>
                                    <td class="px-6 py-4 font-bold">${{ number_format($invoice->details->sum(function($detail) { return $detail->quantity * $detail->price; }), 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('invoices.index') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Invoices
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>