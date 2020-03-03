<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKindlustusedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kindlustused', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active');
            $table->text('notes')->collation('utf8_estonian_ci');
            $table->date('duedate');
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
        Schema::dropIfExists('kindlustused');
    }
}
