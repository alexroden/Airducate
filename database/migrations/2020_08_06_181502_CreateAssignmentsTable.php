<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->uuid('token')->nullable()->default(null);
            $table->integer('type')->index();
            $table->string('name');
            $table->text('description')->nullable()->default(null);
            $table->string('source')->nullable()->default(null);
            $table->text('content')->nullable()->default(null);
            $table->string('cover_image')->nullable()->default(null);
            $table->float('length')->nullable()->default(null);
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
        Schema::dropIfExists('assignments');
    }
}
