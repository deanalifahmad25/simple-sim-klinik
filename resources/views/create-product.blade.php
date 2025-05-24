<x-app-layout>
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('failed'))
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            {{ session('failed') }}
        </div>
    @endif

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Produk') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 mb-6 max-h-screen">
                    <div>
                        <h2 class="text-base/7 font-semibold text-gray-900">Data Produk</h2>
                    </div>

                    <form method="POST" action="{{ $selectedProduct ? route('update_product', Illuminate\Support\Facades\Crypt::encrypt($selectedProduct->id)) : route('store_product') }}">
                        @csrf
                        @if($selectedProduct)
                            @method('PUT')
                        @endif

                        <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <x-input-label for="name" :value="__('Nama Produk')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $selectedProduct ? $selectedProduct->name : '')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="price" :value="__('Harga')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price', $selectedProduct ? $selectedProduct->price : '')" required autofocus autocomplete="price" />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-2">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description', $selectedProduct ? $selectedProduct->description : '')" required autofocus autocomplete="description" />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-3">
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>