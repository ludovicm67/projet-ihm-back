<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('players', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name', 20);
      $table->string('password', 100);
      $table->integer('points')->default(0);
      $table->integer('won_games')->default(0);
      $table->integer('lost_games')->default(0);
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
    Schema::dropIfExists('players');
  }
}
