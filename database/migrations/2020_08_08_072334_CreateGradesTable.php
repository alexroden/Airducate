<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('assignment_id');
            $table->float('progress')->nullable()->default(null);
            $table->float('score')->nullable()->default(null);
            $table->timestamp('completed_at')->nullable()->default(null);
            $table->timestamps();

            $table->index(['user_id', 'assignment_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grades');
    }
}
