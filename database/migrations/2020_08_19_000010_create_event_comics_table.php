<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventComicsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'event_comics';

    /**
     * Run the migrations.
     * @table event_comics
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('comic_id');

            $table->index(["event_id"], 'fk_events_has_comics_events1_idx');

            $table->index(["comic_id"], 'fk_events_has_comics_comics1_idx');


            $table->foreign('event_id', 'fk_events_has_comics_events1_idx')
                ->references('id')->on('events')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('comic_id', 'fk_events_has_comics_comics1_idx')
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
