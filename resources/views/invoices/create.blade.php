<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('invoices.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="number" class="block text-gray-700 text-sm font-bold mb-2">Invoice Number:</label>
                                <input type="number" name="number" id="number" 
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       required>
                            </div>
                            <div class="mb-4">
                                <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date:</label>
                                <input type="date" name="date" id="date" 
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       required>
                            </div>
                            <div class="mb-4">
                                <label for="customer_id" class="block text-gray-700 text-sm font-bold mb-2">Customer:</label>
                                <select name="customer_id" id="customer_id"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        required>
                                    <option value="">Select a customer</option>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="pay_mode_id" class="block text-gray-700 text-sm font-bold mb-2">Payment Mode:</label>
                                <select name="pay_mode_id" id="pay_mode_id"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        required>
                                    <option value="">Select a payment mode</option>
                                    @foreach($pay_modes as $pay_mode)
                                    <option value="{{ $pay_mode->id }}">{{ $pay_mode->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Invoice Items</h3>
                            <div id="items-container">
                                <div class="item-row grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Product</label>
                                        <select name="items[0][product_id]" 
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline product-select"
                                                required>
                                            <option value="">Select a product</option>
                                            @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Quantity</label>
                                        <input type="number" name="items[0][quantity]" min="1" value="1"
                                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline quantity-input"
                                               required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Price</label>
                                        <input type="number" name="items[0][price]" min="0" step="0.01"
                                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline price-input"
                                               required>
                                    </div>
                                    <div class="flex items-end">
                                        <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded remove-item">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-item" 
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-2">
                                Add Item
                            </button>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Create Invoice
                            </button>
                            <a href="{{ route('invoices.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add new item row
            document.getElementById('add-item').addEventListener('click', function() {
                const container = document.getElementById('items-container');
                const itemCount = container.querySelectorAll('.item-row').length;
                const newRow = container.querySelector('.item-row').cloneNode(true);
                
                // Update the name attributes with the new index
                newRow.querySelectorAll('select, input').forEach(el => {
                    const name = el.getAttribute('name').replace('[0]', `[${itemCount}]`);
                    el.setAttribute('name', name);
                    el.value = '';
                });
                
                container.appendChild(newRow);
            });

            // Remove item row
            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-item')) {
                    const itemRow = e.target.closest('.item-row');
                    if (document.querySelectorAll('.item-row').length > 1) {
                        itemRow.remove();
                    } else {
                        itemRow.querySelectorAll('select, input').forEach(el => {
                            el.value = '';
                        });
                    }
                }
            });

            // Update price when product is selected
            document.addEventListener('change', function(e) {
                if (e.target && e.target.classList.contains('product-select')) {
                    const selectedOption = e.target.options[e.target.selectedIndex];
                    const price = selectedOption.getAttribute('data-price');
                    const priceInput = e.target.closest('.item-row').querySelector('.price-input');
                    if (price && priceInput) {
                        priceInput.value = price;
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>