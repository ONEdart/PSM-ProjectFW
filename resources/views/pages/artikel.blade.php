@extends('layouts.app')

@section('content')

@if(!$article)

<section class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="text-center max-w-md">
        <div class="text-6xl mb-6">📰</div>
        <h2 class="text-2xl font-bold mb-4">Artikel Tidak Ditemukan</h2>
        <p class="text-gray-500">
            Artikel yang Anda cari belum tersedia atau telah dihapus.
        </p>
        <a href="{{ url('/') }}"
           class="inline-block mt-6 px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
            Kembali ke Beranda
        </a>
    </div>
</section>

@else

<section class="pt-36 pb-16 bg-gradient-to-r from-emerald-700 to-green-500 text-white">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold leading-tight">
            {{ $article->title }}
        </h1>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-6">

        <img src="{{ asset('storage/'.$article->thumbnail) }}"
             class="w-full rounded-2xl shadow-lg mb-10 object-cover">

        <div class="prose max-w-none prose-emerald">
            {!! $article->content !!}
        </div>

    </div>
</section>

@endif

@endsection
