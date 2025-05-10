@php($users = App\Models\User::find(collect($data['signers'])->pluck('user'))->load('signature'))

<div class="font-[12pt] mt-6" style="font-family: '{{ $data['font'] }}'">
    @if ($data['alignment'] === 'justify')
        <div class="flex justify-between">
            @foreach ($data['signers'] as $signer)
                @php($user = $users->first(fn ($user) => $user->id === $signer['user']))

                <div class="flex flex-col text-center">
                    <div class="relative">
                        <div class="absolute overflow-hidden" style="top:-0.5in;">
                            <img
                                src="data:image/png;base64,{{ base64_encode(Storage::get($user->signature->specimen)) }}"
                                alt="{{ $user->name }}'s signature"
                                class="w-32 h-auto"
                            >
                        </div>
                        {{ $signer['name'] ?? $user->name }}
                    </div>
                    <div>
                        {{ $signer['designation'] ?? $user->designation }}
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div @class([
            'justify-center' => $data['alignment'] === 'center',
            'justify-start' => $data['alignment'] === 'left',
            'justify-end' => $data['alignment'] === 'right',
            'flex',
        ])>
            <div @class([
                'items-center' => $data['alignment'] !== 'left',
                'flex flex-col gap-y-12 w-fit'
            ])>
                @foreach ($data['signers'] as $signer)
                    @php($user = $users->first(fn ($user) => $user->id === $signer['user']))

                    <div @class([
                        'flex flex-col grow-0 w-fit',
                        $data['alignment'] === 'left' ? 'text-left' : 'text-center',
                    ])>
                        <div class="relative">
                            <div class="absolute size-32" style="top:-0.5in;">
                                <img
                                    src="data:image/png;base64,{{ base64_encode(Storage::get($user->signature->specimen)) }}"
                                    alt="{{ $user->name }}'s signature"
                                    class="w-32 h-auto"
                                >
                            </div>
                            {{ $signer['name'] ?? $user->name }}
                        </div>
                        <div>
                            {{ $signer['designation'] ?? $user->designation }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
