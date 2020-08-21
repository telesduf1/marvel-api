<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTextObjectsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'text_objects';

    /**
     * Run the migrations.
     * @table text_objects
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('type', 30);
            $table->string('language', 10);
            $table->text('text');
            $table->unsignedInteger('comic_id');

            $table->index(["comic_id"], 'fk_text_objects_comics1_idx');


            $table->foreign('comic_id', 'fk_text_objects_comics1_idx')
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
