<div
    class="text-[12pt] prose max-w-none [&>*:first-child]:mt-0 [&>*:last-child]:mb-0 [&>p]:text-[12pt] prose-sm text-sm leading-[1.5] grow text-justify"
    style="font-family: '{{ $data['font'] }}'"
>
    {{ str($data['content'])->markdown()->toHtmlString() }}
</div>
