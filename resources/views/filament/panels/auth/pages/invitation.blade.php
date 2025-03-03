@extends('filament.panels.auth.layout.base')

@section('content')
    @if(request()->hasValidSignature() && $this->recipient !== Auth::user()->email)
        <p class="text-sm text-center text-gray-500 dark:text-gray-400">
            You are not authorized to accept this invitation.
        </p>
    @elseif (request()->hasValidSignature() && $this->to() && $this->as())
        <div class="flex flex-col items-center text-center">
            <div class="flex flex-col items-center pb-3">
                <img class="size-11 rounded-full" src="{{ Auth::user()->avatar_url }}" alt="User Avatar">

                <div class="font-medium dark:text-white text-center">
                    {{ Auth::user()->name }}
                </div>

                <div class="text-lg font-semibold text-gray-900 dark:text-white">
                    You have been invited to join
                </div>
            </div>

            <div class="flex items-center min-w-72 gap-4 p-6 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-sm">
                <img class="size-24 rounded-full shadow" src="{{ $this->to()->logo_url }}" alt="Organization Logo">

                <div class="text-left">
                    <div class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ $this->to()->code }}
                    </div>

                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <span class="font-medium text-gray-900 dark:text-white">
                            {{ $this->to()->name }}
                        </span>
                    </div>

                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        Role:
                        <span class="font-semibold text-primary dark:text-primary-light text-sm">
                            {{ $this->as()->getLabel() }}
                        </span>
                    </div>
                </div>
            </div>

            @if($this->referrer())
                <div class="flex flex-col items-center space-y-3 p-4">
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <div class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    Invitation sent by
                                </span>
                                {{ $this->referrer()->name }}
                            </div>

                            <div class="text-xs font-semibold text-gray-700 dark:text-gray-300">
                                <span class="text-gray-500 dark:text-gray-400"> at </span>
                                {{ $this->at('l jS \o\f F Y H:i') }}
                            </div>
                        </div>

                        <img class="size-8 rounded-full" src="{{ $this->referrer()->avatar_url }}" alt="Inviter Avatar">
                    </div>
                </div>
            @endif
        </div>
        {{ $this->acceptAction }}
    @else
        <p class="text-sm text-center text-gray-500 dark:text-gray-400">
            This invitation link is invalid or has expired.
        </p>
        <p class="text-sm text-center text-gray-500 dark:text-gray-400">
            Please contact your administrator for assistance.
        </p>
    @endif

    {{ $this->logoutAction }}
@endsection
