@extends('layouts.app')

@section('content')

<section class="pt-28 pb-20 bg-linear-to-r from-primary to-red-900 text-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 text-center">

        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
            UKM Paduan Suara Polije
        </h1>

        <p class="text-base sm:text-lg md:text-xl opacity-90">
            Harmoni • Kreativitas • Prestasi
        </p>

    </div>
</section>

<section class="py-20">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">

        <h2 class="text-2xl md:text-3xl font-bold mb-12 text-center">
            Artikel Terbaru
        </h2>

        <div class="grid
                    grid-cols-1
                    sm:grid-cols-2
                    lg:grid-cols-3
                    gap-8">

            <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6">
                <h3 class="font-semibold text-lg mb-2">Judul Artikel</h3>
                <p class="text-gray-600 text-sm">
                    Deskripsi singkat artikel...
                </p>
            </div>

            <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6">
                <h3 class="font-semibold text-lg mb-2">Judul Artikel</h3>
                <p class="text-gray-600 text-sm">
                    Deskripsi singkat artikel...
                </p>
            </div>

        </div>

    </div>
</section>

@endsection
