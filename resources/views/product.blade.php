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
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-base/7 font-semibold text-gray-900">Master Produk</h3>

                        <a href="{{ route('create_product') }}" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Tambah
                        </a>
                    </div>

                    <div class="relative flex flex-col w-full h-full text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
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
                                                Deskripsi
                                            </p>
                                        </th>
                                        <th class="p-4">
                                            <p class="text-sm leading-none font-bold">
                                                Harga
                                            </p>
                                        </th>
                                        <th class="p-4">
                                            <p>
                                            Aksi
                                            </p>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($product as $item)
                                        <tr class="hover:bg-slate-50">
                                            <td class="p-4">
                                                <p class="text-sm font-bold">
                                                    {{ $item->name }}
                                                </p>
                                            </td>
                                            <td class="p-4">
                                                <p class="text-sm">
                                                    {{ $item->description }}
                                                </p>
                                            </td>
                                            <td class="p-4">
                                                <p class="text-sm">
                                                    {{ $item->price }}
                                                </p>
                                            </td>
                                            <td class="p-4">
                                                <a href="{{ route('create_product', Illuminate\Support\Facades\Crypt::encrypt($item->id)) }}" class="text-sm text-green-500 font-semibold ml-2">
                                                    Edit
                                                </a>

                                                <form method="post" action="{{ route('destroy_product', ['product' => Illuminate\Support\Facades\Crypt::encrypt($item->id)]) }}">
                                                    @csrf
                                                    @method('delete')

                                                    <button type="submit" class="text-sm text-red-500 font-semibold ml-2">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="hover:bg-slate-50">
                                            <th class="p-4" colspan="6">
                                                <p class="text-sm text-center font-bold">
                                                    Belum Ada Data
                                                </p>
                                            </th>
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
</x-app-layout>
