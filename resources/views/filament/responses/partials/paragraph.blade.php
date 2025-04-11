<div>
    @foreach (explode("\n", $data['content']) as $content)
        <pre class='whitespace-pre-line text-[12pt] indent-[0.5in] leading-[1.5] text-justify my-0' style="font-family: '{{ $data['font'] }}'">
            {{ $content }}
        </pre>
    @endforeach
</div>
