<div class="leading-[1.25]" style="font-family: '{{ $data['font'] }}'">
    <div class="font-bold text-[14pt]">
        {{ $data['recipient'] }}
    </div>

    <div class="text-[12pt]">
        {{ $data['position'] }}
    </div>

    <div class="text-[12pt]">
        {{ $data['organization'] }}
    </div>

    @if ($data['address-1'])
        <div class="text-[12pt]">
            {{ $data['address-1'] }}
        </div>
    @endif

    @if ($data['address-2'])
        <div class="text-[12pt]">
            {{ $data['address-2'] }}
        </div>
    @endif

    @if ($data['address-3'])
        <div class="text-[12pt]">
            {{ $data['address-3'] }}
        </div>
    @endif
</div>
