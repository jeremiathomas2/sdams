<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->string('description')->nullable()->after('action');
            $table->string('ip_address', 45)->nullable()->after('model_id');
            $table->index('action');
            $table->index('model');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropColumn(['description', 'ip_address']);
            $table->dropIndex(['action', 'model', 'created_at']);
        });
    }
};
