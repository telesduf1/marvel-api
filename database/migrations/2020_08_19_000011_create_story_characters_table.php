<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoryCharactersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'story_characters';

    /**
     * Run the migrations.
     * @table story_characters
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('story_id');
            $table->unsignedInteger('character_id');

            $table->index(["character_id"], 'fk_stories_has_characters_characters1_idx');

            $table->index(["story_id"], 'fk_stories_has_characters_stories1_idx');


            $table->foreign('story_id', 'fk_stories_has_characters_stories1_idx')
                ->references('id')->on('stories')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('character_id', 'fk_stories_has_characters_characters1_idx')
                ->references('id')->on('characters')
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
