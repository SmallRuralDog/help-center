<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('help_work_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('p_id');
            $table->integer('user_id');
            $table->text('content');
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->json('images')->nullable();
            $table->boolean('is_close')->default(false);
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
        Schema::dropIfExists('help_work_orders');
    }
}
