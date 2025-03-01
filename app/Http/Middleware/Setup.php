<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Setup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User $user */
        $user = $request->user();

        if (
            ! $request->route()->named('filament.auth.auth.logout') &&
            in_array($user->role, [UserRole::ADMIN, UserRole::MODERATOR, UserRole::AGENT]) &&
            is_null($user->organization_id)
        ) {
            return redirect()->route('filament.auth.auth.organization-setup.prompt');
        }

        return $next($request);
    }
}
