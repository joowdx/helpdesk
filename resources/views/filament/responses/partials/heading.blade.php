<{{ $data['level'] ?? 'h1' }}
    @class([
        'justify-center' => $data['alignment'] === 'center',
        'justify-start' => $data['alignment'] === 'left',
        'justify-end' => $data['alignment'] === 'right',
        'flex',
    ])
    style="font-family: '{{ $data['font'] ?? 'Times New Roman' }}'"
>
    @foreach ($data['content'] as $heading)
        {{ $heading }} <br>
    @endforeach
</{{ $data['level'] ?? 'h1' }}>
