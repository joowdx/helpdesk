@php($organization = Auth::user()->organization)

@php($final ??= false)

<footer @style([
    '-webkit-print-color-adjust: exact',
    'display: inline-flex',
    'flex-direction: column',
    'height: 1in',
    'width: 100%',
    'place-content: end',
])>
    @if (isset($organization->settings['footer']))
        @php($alignment = $organization->settings['footer_alignment'] ?? 'left')

        <div @style([
            'display: inline-flex',
            'flex: 1',
            'height: 0.5in',
            'overflow: hidden',
            'font-size: 8pt',
            'justify-content: flex-end' => $alignment === 'right',
            'justify-content: center' => $alignment === 'center',
            'justify-content: flex-start' => $alignment === 'left',
        ])>
            <img
                src="data:image/png;base64,{{base64_encode(Storage::disk('public')->get($organization->settings['footer']))}}"
                style="width: auto; height: 0.5in;"
            />
        </div>
    @endif

    @if ($final)
        <div style="font-size: 8pt; color: #B0B0B0; text-align: right; font-family: 'Liberation Sans';">
            <div style="padding: 0 0.25in;">
                To verify the authenticity of this document, please visit:
                <a style="font-family: 'DejaVu Sans Mono'; font-size: 7pt; font-style: italic; text-decoration: underline; letter-spacing: -0.125em;">
                    {{ $url }}
                </a>
            </div>
        </div>
    @endif
</footer>
