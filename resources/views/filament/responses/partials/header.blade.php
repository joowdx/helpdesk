<header style="display: inline-flex; height: 1in; width: 100%;">

    <div style="flex: 1; height: 1in; overflow: hidden; font-size: 12pt;">
        <img
            src="data:image/png;base64,{{base64_encode(Storage::disk('public')->get('header.png'))}}"
            style="width: auto; height: 1in;"
        />
    </div>

    <div style="height: 1in; width: 1in; overflow: hidden; position: relative; flex-shrink: 0; margin-right: 12pt;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; font-size: 6pt; color: #D7922A;">
            ᴠᴇʀɪꜰɪᴄᴀᴛɪᴏɴ
        </div>
        {!! $qr !!}
    </div>

</header>
