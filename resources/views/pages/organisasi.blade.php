@extends('layouts.app')

@section('content')

<section class="pt-36 pb-20 bg-gradient-to-r from-emerald-800 to-green-600 text-white text-center">
    <h1 class="text-4xl md:text-5xl font-bold">Struktur Organisasi</h1>
    <p class="mt-6 text-lg text-gray-100">Pengurus UKM PSM Polije</p>
</section>

<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">

        @if($members->isEmpty())

            <div class="text-center py-20">
                <div class="text-6xl mb-6">👥</div>
                <h2 class="text-2xl font-bold mb-4">
                    Struktur Organisasi Belum Tersedia
                </h2>
                <p class="text-gray-500">
                    Data pengurus sedang dalam proses pembaruan.
                </p>
            </div>

        @else

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-10">

            @foreach($members as $member)
                <div class="bg-white rounded-2xl shadow hover:shadow-xl transition p-6 text-center">

                    <img src="{{ asset('storage/'.$member->photo) }}"
                         class="w-32 h-32 md:w-40 md:h-40 mx-auto rounded-full object-cover border-4 border-emerald-500">

                    <h3 class="mt-6 font-bold text-lg">
                        {{ $member->name }}
                    </h3>

                    <span class="inline-block mt-2 px-4 py-1 text-sm bg-emerald-100 text-emerald-700 rounded-full">
                        {{ $member->position }}
                    </span>

                </div>
            @endforeach

        </div>

        @endif

    </div>
</section>

@endsection
