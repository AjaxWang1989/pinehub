<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMiniProgramDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mini_program_drafts', function (Blueprint $table) {
            $table->unsignedInteger('draft_id')->primary()->comment('草稿id');
            $table->string('user_version', 8)->comment('模版版本号');
            $table->string('user_desc', 256)->comment('模版描述');
            $table->timestamp('create_time')->comment('草稿创建时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mini_program_drafts');
    }
}
