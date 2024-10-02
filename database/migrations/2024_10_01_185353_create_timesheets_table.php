<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->string('task_name');
            $table->date('date');
            $table->float('hours');
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId("project_id")->constrained("projects", "id");
            $table->foreignId("user_id")->constrained("users", "id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timesheets');
    }
};
