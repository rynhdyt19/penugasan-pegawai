<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {

            // Tambah kolom notifiable
            $table->string('notifiable_type')->after('type');
            $table->unsignedBigInteger('notifiable_id')->after('notifiable_type');

            // Index untuk performa
            $table->index(['notifiable_type', 'notifiable_id']);
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {

            $table->dropIndex(['notifiable_type', 'notifiable_id']);
            $table->dropColumn(['notifiable_type', 'notifiable_id']);

        });
    }
};
