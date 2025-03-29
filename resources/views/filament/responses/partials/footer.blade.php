<footer style="display: inline-flex; height: 1in; width: 100%;">

    <div style="flex: 1; height: 1in; overflow: hidden; font-size: 12pt;">
        <img
            src="data:image/png;base64,{{base64_encode(Storage::disk('public')->get('footer.png'))}}"
            style="width: 100%; height: auto;"
        />
    </div>

</footer>
