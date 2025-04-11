@extends('filament.responses.layout.base')

@section('content')
    @foreach ($response?->content ?? [] as $content)
        @if (in_array($content['type'], ['heading', 'addressee', 'paragraph', 'greeting', 'markdown', 'signatories']))
            @include('filament.responses.partials.' . $content['type'], ['data' => $content['data']])
        @endif
    @endforeach
@endsection
