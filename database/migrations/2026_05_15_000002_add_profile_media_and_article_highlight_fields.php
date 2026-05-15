<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('city')->nullable()->after('bio');
            $table->string('avatar_path')->nullable()->after('city');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->boolean('is_highlighted')->default(false)->after('is_accepted');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['city', 'avatar_path']);
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('is_highlighted');
        });
    }
};
