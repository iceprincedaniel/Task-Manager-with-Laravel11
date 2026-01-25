<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    
    // database/migrations/xxxx_xx_xx_add_project_id_to_tasks_table.php
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('project_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete()
                ->after('id');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            //
        });
    }
};
