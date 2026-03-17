<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('events') && !Schema::hasTable('blogs')) {
            Schema::rename('events', 'blogs');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('blogs') && !Schema::hasTable('events')) {
            Schema::rename('blogs', 'events');
        }
    }
};
