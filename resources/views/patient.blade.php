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
            {{ __('Daftar Pasien Lama') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 mb-6 max-h-screen">
                    <section class="flex flex-row items-center justify-start gap-x-1 mt-8 mb-22">
                        @forelse ($patient as $item)
                            <div class="mx-auto px-5">
                                <div class="max-w-xs cursor-pointer rounded-lg bg-white p-2 shadow duration-150 hover:scale-105 hover:shadow-md">
                                    @if ($item->gender == 'L')
                                        <img class="w-full rounded-lg object-cover object-center"
                                            src="{{ asset('./assets/images/male.png') }}"
                                            alt="product" />
                                    @else
                                        <img class="w-full rounded-lg object-cover object-center"
                                            src="{{ asset('./assets/images/female.png') }}"
                                            alt="product" />
                                    @endif

                                    <div class="flex items-center justify-between my-2">
                                        <div>
                                            <p class="mt-4 pl-1 font-bold text-gray-500">{{ $item->name }} ({{ $item->gender }})</p>
                                        <p class="pl-1 text-gray-500">{{ $item->birth_date }}</p>
                                        </div>

                                        <a href="{{ route('registration', ['patient' => Illuminate\Support\Facades\Crypt::encrypt($item->id)]) }}" class="inline-flex items-end mt-4 px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Registrasi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <span>Belum Ada Pasien</span>
                        @endforelse
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
