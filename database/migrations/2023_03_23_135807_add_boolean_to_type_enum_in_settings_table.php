<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddBooleanToTypeEnumInSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE settings DROP CONSTRAINT settings_type_check");
        DB::statement("ALTER TABLE settings ADD CONSTRAINT settings_type_check CHECK ((type)::text = ANY ((ARRAY['text'::character varying, 'markdown'::character varying, 'json'::character varying, 'image'::character varying, 'file'::character varying, 'config'::character varying, 'boolean'::character varying])::text[]))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE settings DROP CONSTRAINT settings_type_check");
        DB::statement("ALTER TABLE settings ADD CONSTRAINT settings_type_check CHECK ((type)::text = ANY ((ARRAY['text'::character varying, 'markdown'::character varying, 'json'::character varying, 'image'::character varying, 'file'::character varying, 'config'::character varying])::text[]))");
    }
}
