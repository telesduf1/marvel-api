<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoriesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'stories';

    /**
     * Run the migrations.
     * @table stories
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title', 100);
            $table->text('description');
            $table->string('type', 30);
            $table->string('thumbnail', 100)->nullable();
            $table->unsignedInteger('originalissue');
            $table->unsignedInteger('comic_id');
            $table->timestamp('modified');

            $table->index(["originalissue"], 'fk_stories_comics2_idx');

            $table->index(["comic_id"], 'fk_stories_comics1_idx');


            $table->foreign('comic_id', 'fk_stories_comics1_idx')
                ->references('id')->on('comics')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('originalissue', 'fk_stories_comics2_idx')
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
