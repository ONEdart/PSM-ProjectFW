@extends('layouts.app')

@section('content')

<section class="pt-28 pb-20 bg-gradient-to-r from-blue-950 to-blue-700 text-white text-center">
    <h1 class="text-4xl md:text-5xl font-bold">Struktur Organisasi</h1>
    <p class="mt-5 text-blue-200">Pengurus UKM PSM Polije</p>
</section>

<section class="py-20 bg-blue-50">
    <div class="max-w-7xl mx-auto px-6">

        @if($members->isEmpty())

        <div class="text-center py-20">
            <h2 class="text-xl font-semibold text-blue-900">
                Struktur organisasi belum tersedia.
            </h2>
        </div>

        @else

        <div class="grid grid-cols-2 md:grid-cols-4 gap-12">

            @foreach($members as $member)
            <div class="text-center">

                <img loading="lazy" decoding="async"
                     src="{{ $member->photo ? asset('storage/'.$member->photo) : 'https://via.placeholder.com/200' }}"
                     class="w-28 h-28 mx-auto rounded-full object-cover">

                <h3 class="mt-4 font-semibold text-blue-900">
                    {{ $member->name }}
                </h3>

                <p class="text-sm text-gray-600">
                    {{ $member->position }}
                </p>

            </div>
            @endforeach

        </div>

        @endif

    </div>
</section>

@endsection
