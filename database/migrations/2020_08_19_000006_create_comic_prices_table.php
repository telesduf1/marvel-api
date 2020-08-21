<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComicPricesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'comic_prices';

    /**
     * Run the migrations.
     * @table comic_prices
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('type', 50);
            $table->decimal('price', 8, 2);
            $table->unsignedInteger('comic_id');

            $table->index(["comic_id"], 'fk_comic_prices_comics1_idx');


            $table->foreign('comic_id', 'fk_comic_prices_comics1_idx')
                ->references('id')->on('comics')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
