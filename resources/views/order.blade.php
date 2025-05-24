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
            {{ __('Order') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 mb-6 max-h-screen">
                    <div>
                        <h2 class="text-base/7 font-semibold text-gray-900">Order Produk</h2>
                    </div>

                    <form method="POST"
                        action="{{ route('store_order', Illuminate\Support\Facades\Crypt::encrypt($registration->registration_number)) }}">
                        @csrf

                        <div class="mt-2">
                            <x-input-label for="name" :value="__('Pasien')" />
                            <h2 class="text-base/7 font-semibold text-gray-900">{{ $registration->patient->name }}
                                ({{ $registration->registration_number }})</h2>
                        </div>

                        <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <x-input-label for="product" :value="__('Produk')" />

                                <div class="grid grid-cols-1">
                                    <select id="product" name="product" autocomplete="product"
                                        class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                        required>
                                        @forelse ($product as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                ({{ $item->price }})</option>
                                        @empty
                                            <option disabled>Belum Ada Produk</option>
                                        @endforelse
                                    </select>
                                </div>

                                <x-input-error :messages="$errors->get('product')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="qty" :value="__('Jumlah')" />
                                <x-text-input id="qty" class="block mt-1 w-full" type="number" name="qty"
                                    required autofocus autocomplete="qty" />
                                <x-input-error :messages="$errors->get('qty')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-3">
                                {{ __('Order') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <div class="mt-6">
                        <div>
                            <h2 class="text-base/7 font-semibold text-gray-900 mb-2">Riwayat Order Produk</h2>
                        </div>

                        <div
                            class="relative flex flex-col w-full h-full text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                            <div class="overflow-auto max-h-[400px]">
                                <table class="w-full text-left table-auto min-w-max text-slate-800">
                                    <thead>
                                        <tr class="text-slate-500 border-b border-slate-300 bg-slate-50">
                                            <th class="p-4">
                                                <p class="text-sm leading-none font-bold">
                                                    Nama Produk
                                                </p>
                                            </th>
                                            <th class="p-4">
                                                <p class="text-sm leading-none font-bold">
                                                    Jumlah
                                                </p>
                                            </th>
                                            <th class="p-4">
                                                <p class="text-sm leading-none font-bold">
                                                    Harga
                                                </p>
                                            </th>
                                            <th class="p-4">
                                                <p class="text-sm leading-none font-bold">
                                                    Tanggal Order
                                                </p>
                                            </th>
                                            <th class="p-4">
                                                <p class="text-sm leading-none font-bold">
                                                    Aksi
                                                </p>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($registration->orders as $item)
                                            <tr class="hover:bg-slate-50">
                                                <td class="p-4">
                                                    <p class="text-sm font-bold">
                                                        {{ $item->product->name }}
                                                    </p>
                                                </td>
                                                <td class="p-4">
                                                    <p class="text-sm font-bold">
                                                        {{ $item->qty }}
                                                    </p>
                                                </td>
                                                <td class="p-4">
                                                    <p class="text-sm">
                                                        Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                                    </p>
                                                </td>
                                                <td class="p-4">
                                                    <p class="text-sm font-bold">
                                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}
                                                    </p>
                                                </td>
                                                <td class="p-4">
                                                    @if (Auth::user()->can('order'))
                                                        <form method="post"
                                                            action="{{ route('destroy_order', ['order' => Illuminate\Support\Facades\Crypt::encrypt($item->id)]) }}">
                                                            @csrf
                                                            @method('delete')

                                                            <button type="submit"
                                                                class="text-sm text-red-500 font-semibold ml-2">Hapus</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="hover:bg-slate-50">
                                                <th class="p-4" colspan="5">
                                                    <p class="text-sm text-center font-bold">
                                                        Belum Ada Data
                                                    </p>
                                                </th>
                                            </tr>
                                        @endforelse
                                        <tr class="hover:bg-slate-50">
                                            <th class="p-4" colspan="2">
                                                <p class="text-sm font-bold">
                                                    Total
                                                </p>
                                            </th>
                                            <td class="p-4">
                                                <p class="text-sm font-bold">
                                                    Rp {{ number_format($registration->totalbiaya, 0, ',', '.') }}
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
