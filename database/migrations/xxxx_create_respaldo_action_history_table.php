// database/migrations/xxxx_create_respaldo_action_history_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('respaldo_action_history', function (Blueprint $table) {
            $table->id();
            $table->string('action');                        // 'created' | 'deleted'
            $table->unsignedBigInteger('respaldo_id')->nullable();
            $table->json('snapshot');                        // estado anterior
            $table->unsignedBigInteger('performed_by');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('respaldo_action_history');
    }
};