<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_module', function (Blueprint $table) {
            $table->foreignId("department_id")->constrained()->onDelete("cascade");
            $table->foreignId("module_id")->constrained()->onDelete("cascade");
            $table->integer("study_year")->nullable();
            $table->unique(["department_id", "module_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department_module');
    }
};
