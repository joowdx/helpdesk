@php($organization = Auth::user()->organization)

@php($final ??= false)

<header @style([
    '-webkit-print-color-adjust: exact',
    'display: inline-flex',
    'height: 1in',
    'width: 100%',
])>
    <div @style([
        'flex: 1',
        'overflow: hidden',
        'height: 1in',
        'font-size: 12pt',
        'padding-right: 0.5in',
    ])>
        @if(isset($organization->settings['header']))
            <img
                src="data:image/png;base64,{{base64_encode(Storage::disk('public')->get($organization->settings['header']))}}"
                style="height: 1in; width: auto;"
            />
        @else
            <div @style([
                'display: inline-flex',
                $organization->logo ? 'margin-left: 0.175in' : 'margin-left: 1in',
            ])>
                @if ($organization->logo)
                    <img
                        src="data:image/png;base64,{{base64_encode(Storage::disk('public')->get($organization->logo))}}"
                        style="height: 1in; width: auto;"
                    />
                @endif

                <div @style([
                    'display: inline-flex',
                    'place-content: center',
                    'flex-direction: column',
                    'margin-left: 0.25in',
                    'font-family: "Nimbus Roman"',
                    'height: 1in',
                ])>
                    <b style="font-size: 14pt; font-family: 'Liberation Serif'; text-wrap: balance;">
                        {{ $organization->name }}
                    </b>

                    <i>
                        @php($room = $organization->room)
                        @php($building = $organization->building)
                        {{ $room ? "$room, $building" : $building }}
                    </i>

                    <span>{{ $organization->address }}</span>
                </div>
            </div>
        @endif
    </div>

    <div @style([
        'position: relative',
        'overflow: hidden',
        'flex-shrink: 0',
        'margin-right: 12pt',
        'height: 1in',
        'width: 1in',
    ])>
        <label @style([
            'position: absolute',
            'top: 50%',
            'left: 50%',
            'transform: translate(-50%, -50%)',
            'background: white',
            'font-size: 8pt',
            'color: #D7922A',
            'border-radius: 5pt',
        ])>
            @if ($final)
                &nbsp;ᴠᴇʀɪꜰɪᴄᴀᴛɪᴏɴ&nbsp;
            @else
                &nbsp;ᴅʀᴀғᴛ&nbsp;ᴏɴʟʏ&nbsp;
            @endif
        </label>
        {!! $qr !!}
    </div>

    @if (!$final)
        <div class="watermark">DRAFT</div>
    @endif
</header>

<style>
    header {
        position: relative;
    }
    .watermark {
        position: absolute;
        top: 500%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-45deg);
        font-size: 172pt;
        color: rgba(0, 0, 0, 0.1);
        white-space: nowrap;
        pointer-events: none;
        z-index: 9999;
    }
</style>
