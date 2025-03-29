<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> {{ config('app.name') }} </title>
    <style>{!! Vite::content('resources/css/app.css') !!}</style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cardo:ital,wght@0,400;0,700;1,400&family=Crimson+Pro:ital,wght@0,200..900;1,200..900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Lora:ital,wght@0,400..700;1,400..700&family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
</head>
<body class="font-serif [&>*:first-child]:mt-0 [&>*:last-child]:mb-0" style="margin:0;padding-top:0.5in;">
    @foreach ($response?->content ?? [] as $content)
        @if (in_array($content['type'], ['heading', 'addressee', 'paragraph', 'greeting', 'markdown', 'signatories']))
            @include('filament.responses.partials.' . $content['type'], ['data' => $content['data']])
            <br>
        @endif
    @endforeach
</body>
</html>
