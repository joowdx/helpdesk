@php($file = $response->attachment?->files->first())

@if($file)
    @php($link = Storage::temporaryUrl($response->attachment?->files->first(), now()->addMinutes(5)))

    <div class="flex justify-center">
        <iframe
            src="{{ $link }}"
            @class([
                'rounded-lg',
                'max-w-5xl',
                'w-full',
                'border-0',
                ])
            @style([
                'height: ' . \App\Enums\PaperSize::tryFrom($response->options['size'] ?? 'A4')->getDimensions('in')[1] . 'in',
            ])
        >
            <p>Your browser does not support iframes.</p>
        </iframe>
    </div>
@endif
