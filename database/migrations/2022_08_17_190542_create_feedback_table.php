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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId("module_id")->constrained()->onDelete('cascade');
            $table->boolean("is_compulsory");
            $table->integer("module_difficulty");
            $table->integer("amount_of_assignments");
            $table->integer("exam_difficulty");
            $table->text("tips")->nullable();
            $table->integer("evaluation");
            $table->text("comments")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback');
    }
};
