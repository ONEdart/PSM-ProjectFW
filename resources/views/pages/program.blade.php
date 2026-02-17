@extends('layouts.app')

@section('content')

<section class="pt-36 pb-20 bg-gradient-to-r from-emerald-700 to-green-500 text-white text-center">
    <h1 class="text-4xl md:text-5xl font-bold">Program Kerja</h1>
    <p class="mt-6 text-lg text-gray-100">
        Rangkaian kegiatan UKM PSM Polije
    </p>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        @if($programs->isEmpty())

            <div class="text-center py-24">
                <div class="text-6xl mb-6">🎼</div>
                <h2 class="text-2xl font-bold mb-4">
                    Belum Ada Program Aktif
                </h2>
                <p class="text-gray-500">
                    Program kerja akan segera diumumkan.
                </p>
            </div>

        @else

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">

            @foreach($programs as $program)
                <div class="bg-gray-50 rounded-2xl shadow hover:shadow-2xl transition transform hover:-translate-y-2 overflow-hidden">

                    <img src="{{ asset('storage/'.$program->image) }}"
                         class="w-full h-56 object-cover">

                    <div class="p-6">
                        <h3 class="font-bold text-lg text-emerald-700">
                            {{ $program->title }}
                        </h3>
                        <p class="text-gray-600 mt-3 text-sm leading-relaxed">
                            {{ $program->description }}
                        </p>
                    </div>

                </div>
            @endforeach

        </div>

        @endif

    </div>
</section>

@endsection
