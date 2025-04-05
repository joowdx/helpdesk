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
            $table->json('addressee')->nullable();
            $table->json('content');
            $table->json('options');
            $table->string('disposition')->default('');
            $table->char('hash', 64)->nullable();
            $table->foreignUlid('request_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUlid('user_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
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
