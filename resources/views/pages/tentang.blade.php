@extends('layouts.app')

@section('content')

<section class="pt-36 pb-24 bg-gradient-to-r from-emerald-800 to-green-600 text-white text-center">
    <div class="max-w-4xl mx-auto px-6">
        <h1 class="text-4xl md:text-5xl font-bold">
            Tentang UKM PSM Polije
        </h1>
        <p class="mt-6 text-lg text-gray-100">
            Harmoni dalam keberagaman, prestasi dalam kebersamaan.
        </p>
    </div>
</section>

<section class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">

        <div>
            <h2 class="text-3xl font-bold mb-6 text-emerald-700">
                Sejarah Singkat
            </h2>
            <p class="text-gray-600 leading-relaxed text-lg">
                UKM Paduan Suara Polije merupakan wadah pengembangan bakat
                mahasiswa dalam bidang seni musik, khususnya paduan suara.
                Organisasi ini menjadi ruang kreativitas, kebersamaan,
                dan pembinaan karakter mahasiswa.
            </p>
        </div>

        <div class="bg-emerald-100 rounded-2xl h-80 shadow-inner"></div>

    </div>
</section>

<section class="py-24 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12">

        <div class="bg-white p-8 rounded-2xl shadow">
            <h3 class="text-2xl font-bold mb-4 text-emerald-700">Visi</h3>
            <p class="text-gray-600">
                Menjadi UKM seni yang unggul, berprestasi, dan berkarakter.
            </p>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow">
            <h3 class="text-2xl font-bold mb-4 text-emerald-700">Misi</h3>
            <ul class="list-disc pl-5 text-gray-600 space-y-2">
                <li>Mengembangkan bakat mahasiswa di bidang musik.</li>
                <li>Meningkatkan solidaritas dan kerja sama tim.</li>
                <li>Berpartisipasi dalam kompetisi dan event seni.</li>
            </ul>
        </div>

    </div>
</section>

@endsection
