<?php

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
        Schema::table('users', function (Blueprint $table) {
              $table->date('date_of_birth')->nullable()->after('last_name');
            $table->string('username')->nullable()->unique()->after('date_of_birth');
            $table->string('phone_number', 20)->nullable()->after('username');
             $table->text('description')->nullable()->after('phone_number');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
             // Drop added columns
            $table->dropColumn([
                'date_of_birth',
                'username',
                'phone_number',
                'description',
            ]);
        });
    }
};
