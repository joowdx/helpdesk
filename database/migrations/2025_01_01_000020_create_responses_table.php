<?php

use App\Enums\PaperSize;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->char('code', 10)->unique();
            $table->boolean('file')->default(false);
            $table->json('content')->nullable();
            $table->json('options')->nullable();
            $table->char('hash', 64)->nullable();
            $table->foreignUlid('request_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUlid('user_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->foreignUlid('document_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->check(
                "(
                    (`file` IS NOT NULL AND `content` IS NULL AND `options` IS NULL) OR
                    (`file` IS NULL AND `content` IS NOT NULL AND `options` IS NOT NULL)
                )",
                'file_or_content_check',
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};
