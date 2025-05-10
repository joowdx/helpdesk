<?php

use App\Actions\GenerateQrCode;
use App\Http\Controllers\AttachmentController;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('test', fn (Request $request) => $request->expectsJson() ? response()->json('Hello World') : 'Hello World');

Route::get('attachments/{attachment}/{name}', AttachmentController::class)->name('file.attachment')->where('name', '.*');

Route::get('testt', fn () => view('filament.responses.print', [
    'response' => $response = Response::first(),
    'qr' => app(GenerateQrCode::class)((string) url($response->code), 96),
]));
