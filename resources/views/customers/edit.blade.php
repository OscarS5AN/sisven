<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Customer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="document_number" class="block text-gray-700 text-sm font-bold mb-2">Document Number:</label>
                                <input type="text" name="document_number" id="document_number" value="{{ $customer->document_number }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       required maxlength="15">
                            </div>
                            <div class="mb-4">
                                <label for="first_name" class="block text-gray-700 text-sm font-bold mb-2">First Name:</label>
                                <input type="text" name="first_name" id="first_name" value="{{ $customer->first_name }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       required maxlength="50">
                            </div>
                            <div class="mb-4">
                                <label for="last_name" class="block text-gray-700 text-sm font-bold mb-2">Last Name:</label>
                                <input type="text" name="last_name" id="last_name" value="{{ $customer->last_name }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       required maxlength="50">
                            </div>
                            <div class="mb-4">
                                <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address:</label>
                                <input type="text" name="address" id="address" value="{{ $customer->address }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       maxlength="50">
                            </div>
                            <div class="mb-4">
                                <label for="birthday" class="block text-gray-700 text-sm font-bold mb-2">Birthday:</label>
                                <input type="date" name="birthday" id="birthday" value="{{ $customer->birthday }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div class="mb-4">
                                <label for="phone_number" class="block text-gray-700 text-sm font-bold mb-2">Phone Number:</label>
                                <input type="text" name="phone_number" id="phone_number" value="{{ $customer->phone_number }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       maxlength="10">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                                <input type="email" name="email" id="email" value="{{ $customer->email }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       maxlength="100">
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update Customer
                            </button>
                            <a href="{{ route('customers.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>