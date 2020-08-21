<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoryCreatorsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'story_creators';

    /**
     * Run the migrations.
     * @table story_creators
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('story_id');
            $table->unsignedInteger('creator_id');

            $table->index(["story_id"], 'fk_stories_has_creators_stories1_idx');

            $table->index(["creator_id"], 'fk_stories_has_creators_creators1_idx');


            $table->foreign('story_id', 'fk_stories_has_creators_stories1_idx')
                ->references('id')->on('stories')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('creator_id', 'fk_stories_has_creators_creators1_idx')
                ->references('id')->on('creators')
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
