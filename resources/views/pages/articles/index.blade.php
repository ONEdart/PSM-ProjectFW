@extends('layouts.app')

@section('content')

<section class="pt-28 pb-20 bg-gradient-to-r from-blue-950 to-blue-700 text-white text-center">
    <h1 class="text-4xl md:text-5xl font-bold">Artikel & Berita</h1>
    <p class="mt-5 text-blue-200">Informasi terbaru UKM PSM Polije</p>
</section>

<section class="py-20 bg-blue-50">
    <div class="max-w-6xl mx-auto px-6">

        @if($articles->isEmpty())

        <div class="text-center py-20">
            <h2 class="text-xl font-semibold text-blue-900">
                Artikel belum tersedia.
            </h2>
        </div>

        @else

        <div class="grid md:grid-cols-3 gap-10">

            @foreach($articles as $article)
            <a href="{{ route('artikel.show', $article->slug) }}"
               class="bg-white border border-blue-100 block">

                <img loading="lazy" decoding="async"
                     src="{{ $article->thumbnail ? asset('storage/'.$article->thumbnail) : 'https://via.placeholder.com/600x400' }}"
                     class="w-full h-48 object-cover">

                <div class="p-5">
                    <h2 class="font-semibold text-blue-900">
                        {{ $article->title }}
                    </h2>
                </div>

            </a>
            @endforeach

        </div>

        @endif

    </div>
</section>

@endsection
