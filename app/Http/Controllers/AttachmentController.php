<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     *
     * @return array<int,\Illuminate\Routing\Controllers\Middleware|\Closure|string>
     */
    public static function middleware(): array
    {
        return [
            \App\Http\Middleware\Authenticate::class,
            \App\Http\Middleware\Verify::class,
            \App\Http\Middleware\Approve::class,
            \App\Http\Middleware\Active::class,
            \App\Http\Middleware\Initialize::class,
        ];
    }

    /**
     * Handle the incoming file attachment download request.
     */
    public function __invoke(Request $request, Attachment $attachment, string $name)
    {
        abort_unless($attachment->paths->contains($name) && Storage::exists($attachment->paths->search($name)), 404);

        $allowed = match ($attachment->attachable_type) {
            'App\Models\Request' => in_array(Auth::user()->organization_id, [$attachment->attachable->organization_id, $attachment->attachable->from_id]) ||
                Auth::id() === $attachment->attachable->user_id,
            'App\Models\Action' => in_array(Auth::user()->organization_id, [$attachment->attachable->request->organization_id, $attachment->attachable->request->from_id]) ||
                Auth::id() === $attachment->attachable->request->user_id,
            'App\Models\Note' => in_array(Auth::user()->organization_id, [$attachment->attachable->notable->organization_id]) ||
                Auth::id() === $attachment->attachable->notable->user_id,
            'App\Models\Response' => true,
            default => false,
        };

        abort_unless($allowed, 403);

        return filter_var($request->input('preview') ?? null, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
            ? Storage::response($attachment->paths->search($name), $name)
            : Storage::download($attachment->paths->search($name), $name);
    }
}
