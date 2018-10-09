<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMiniProgramTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mini_program_templates', function (Blueprint $table) {
            $table->unsignedInteger('template_id')->primary()->comment('模版id');
            $table->string('user_version', 8)->comment('模版版本号');
            $table->string('user_desc', 256)->comment('模版描述');
            $table->timestamp('create_time')->comment('模版创建时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mini_program_templates');
    }
}
