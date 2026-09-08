<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SetSequence extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $tables = [
            'ki_config' => 'ki_config_id_seq',
            'pemohon' => 'pemohon_id_seq',
            'penomoran' => 'penomoran_id_seq',
            'permissions' => 'permissions_id_seq',
            'sengketa' => 'sengketa_id_seq',
            'sengketa_history' => 'sengketa_history_table_and_drop_sengketa_jadwal_id_seq',
            'termohon' => 'termohon_id_seq',
            'user_internal' => 'user_internal_id_seq',
            'users' => 'users_id_seq',
        ];

        foreach ($tables as $table => $sequence) {
            \DB::statement("SELECT setval('$sequence', (SELECT MAX(id) FROM $table))");
        }
    }
}
