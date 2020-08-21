<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComicsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'comics';

    /**
     * Run the migrations.
     * @table comics
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('digital_id');
            $table->string('title', 150);
            $table->integer('issue_number');
            $table->string('variant_description', 200);
            $table->text('description');
            $table->string('isbn', 30)->nullable();
            $table->string('upc', 30)->nullable();
            $table->string('diamond_code', 30)->nullable();
            $table->string('ean', 30)->nullable();
            $table->string('issn', 30)->nullable();
            $table->string('format', 30);
            $table->integer('page_count');
            $table->string('thumbnail', 100)->nullable();
            $table->timestamp('modified');
            $table->unsignedInteger('series_id');

            $table->index(["series_id"], 'fk_comics_series_idx');


            $table->foreign('series_id', 'fk_comics_series_idx')
                ->references('id')->on('series')
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
