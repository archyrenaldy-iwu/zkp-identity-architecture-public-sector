<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleHasPermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('role_has_permissions')->delete();

        \DB::table('role_has_permissions')->insert([
            0 => [
                'permission_id' => 1,
                'role_id' => 1,
            ],
            1 => [
                'permission_id' => 2,
                'role_id' => 1,
            ],
            2 => [
                'permission_id' => 3,
                'role_id' => 1,
            ],
            3 => [
                'permission_id' => 4,
                'role_id' => 1,
            ],
            4 => [
                'permission_id' => 5,
                'role_id' => 1,
            ],
            5 => [
                'permission_id' => 7,
                'role_id' => 1,
            ],
            6 => [
                'permission_id' => 13,
                'role_id' => 1,
            ],
            7 => [
                'permission_id' => 14,
                'role_id' => 1,
            ],
            8 => [
                'permission_id' => 15,
                'role_id' => 1,
            ],
            9 => [
                'permission_id' => 16,
                'role_id' => 1,
            ],
            10 => [
                'permission_id' => 18,
                'role_id' => 1,
            ],
            11 => [
                'permission_id' => 19,
                'role_id' => 1,
            ],
            12 => [
                'permission_id' => 20,
                'role_id' => 1,
            ],
            13 => [
                'permission_id' => 21,
                'role_id' => 1,
            ],
            14 => [
                'permission_id' => 22,
                'role_id' => 1,
            ],
            15 => [
                'permission_id' => 23,
                'role_id' => 1,
            ],
            16 => [
                'permission_id' => 24,
                'role_id' => 1,
            ],
            17 => [
                'permission_id' => 25,
                'role_id' => 1,
            ],
            18 => [
                'permission_id' => 26,
                'role_id' => 1,
            ],
            19 => [
                'permission_id' => 27,
                'role_id' => 1,
            ],
            20 => [
                'permission_id' => 28,
                'role_id' => 1,
            ],
            21 => [
                'permission_id' => 29,
                'role_id' => 1,
            ],
            22 => [
                'permission_id' => 30,
                'role_id' => 1,
            ],
            23 => [
                'permission_id' => 31,
                'role_id' => 1,
            ],
            24 => [
                'permission_id' => 32,
                'role_id' => 1,
            ],
            25 => [
                'permission_id' => 33,
                'role_id' => 1,
            ],
            26 => [
                'permission_id' => 34,
                'role_id' => 1,
            ],
            27 => [
                'permission_id' => 35,
                'role_id' => 1,
            ],
            28 => [
                'permission_id' => 36,
                'role_id' => 1,
            ],
            29 => [
                'permission_id' => 37,
                'role_id' => 1,
            ],
            30 => [
                'permission_id' => 38,
                'role_id' => 1,
            ],
            31 => [
                'permission_id' => 39,
                'role_id' => 1,
            ],
            32 => [
                'permission_id' => 40,
                'role_id' => 1,
            ],
            33 => [
                'permission_id' => 41,
                'role_id' => 1,
            ],
            34 => [
                'permission_id' => 42,
                'role_id' => 1,
            ],
            35 => [
                'permission_id' => 43,
                'role_id' => 1,
            ],
            36 => [
                'permission_id' => 44,
                'role_id' => 1,
            ],
            37 => [
                'permission_id' => 45,
                'role_id' => 1,
            ],
            38 => [
                'permission_id' => 46,
                'role_id' => 1,
            ],
            39 => [
                'permission_id' => 47,
                'role_id' => 1,
            ],
            40 => [
                'permission_id' => 48,
                'role_id' => 1,
            ],
            41 => [
                'permission_id' => 49,
                'role_id' => 1,
            ],
            42 => [
                'permission_id' => 50,
                'role_id' => 1,
            ],
            43 => [
                'permission_id' => 51,
                'role_id' => 1,
            ],
            44 => [
                'permission_id' => 52,
                'role_id' => 1,
            ],
            45 => [
                'permission_id' => 53,
                'role_id' => 1,
            ],
            46 => [
                'permission_id' => 12,
                'role_id' => 1,
            ],
            47 => [
                'permission_id' => 54,
                'role_id' => 1,
            ],
            48 => [
                'permission_id' => 55,
                'role_id' => 1,
            ],
            49 => [
                'permission_id' => 8,
                'role_id' => 1,
            ],
            50 => [
                'permission_id' => 9,
                'role_id' => 1,
            ],
            51 => [
                'permission_id' => 10,
                'role_id' => 1,
            ],
            52 => [
                'permission_id' => 11,
                'role_id' => 1,
            ],
            53 => [
                'permission_id' => 56,
                'role_id' => 1,
            ],
            54 => [
                'permission_id' => 1,
                'role_id' => 4,
            ],
            55 => [
                'permission_id' => 11,
                'role_id' => 4,
            ],
            56 => [
                'permission_id' => 56,
                'role_id' => 4,
            ],
            57 => [
                'permission_id' => 2,
                'role_id' => 4,
            ],
            58 => [
                'permission_id' => 12,
                'role_id' => 4,
            ],
            59 => [
                'permission_id' => 14,
                'role_id' => 4,
            ],
            60 => [
                'permission_id' => 21,
                'role_id' => 4,
            ],
            61 => [
                'permission_id' => 25,
                'role_id' => 4,
            ],
            62 => [
                'permission_id' => 3,
                'role_id' => 4,
            ],
            63 => [
                'permission_id' => 26,
                'role_id' => 4,
            ],
            64 => [
                'permission_id' => 4,
                'role_id' => 4,
            ],
            65 => [
                'permission_id' => 27,
                'role_id' => 4,
            ],
            66 => [
                'permission_id' => 1,
                'role_id' => 5,
            ],
            67 => [
                'permission_id' => 11,
                'role_id' => 5,
            ],
            68 => [
                'permission_id' => 56,
                'role_id' => 5,
            ],
            69 => [
                'permission_id' => 2,
                'role_id' => 5,
            ],
            70 => [
                'permission_id' => 12,
                'role_id' => 5,
            ],
            71 => [
                'permission_id' => 14,
                'role_id' => 5,
            ],
            72 => [
                'permission_id' => 15,
                'role_id' => 5,
            ],
            73 => [
                'permission_id' => 16,
                'role_id' => 5,
            ],
            74 => [
                'permission_id' => 21,
                'role_id' => 5,
            ],
            75 => [
                'permission_id' => 3,
                'role_id' => 5,
            ],
            76 => [
                'permission_id' => 26,
                'role_id' => 5,
            ],
            77 => [
                'permission_id' => 4,
                'role_id' => 5,
            ],
            78 => [
                'permission_id' => 27,
                'role_id' => 5,
            ],
            79 => [
                'permission_id' => 28,
                'role_id' => 5,
            ],
            80 => [
                'permission_id' => 29,
                'role_id' => 5,
            ],
            81 => [
                'permission_id' => 30,
                'role_id' => 5,
            ],
            82 => [
                'permission_id' => 31,
                'role_id' => 5,
            ],
            83 => [
                'permission_id' => 1,
                'role_id' => 6,
            ],
            84 => [
                'permission_id' => 11,
                'role_id' => 6,
            ],
            85 => [
                'permission_id' => 56,
                'role_id' => 6,
            ],
            86 => [
                'permission_id' => 2,
                'role_id' => 6,
            ],
            87 => [
                'permission_id' => 12,
                'role_id' => 6,
            ],
            88 => [
                'permission_id' => 14,
                'role_id' => 6,
            ],
            89 => [
                'permission_id' => 21,
                'role_id' => 6,
            ],
            90 => [
                'permission_id' => 3,
                'role_id' => 6,
            ],
            91 => [
                'permission_id' => 26,
                'role_id' => 6,
            ],
            92 => [
                'permission_id' => 4,
                'role_id' => 6,
            ],
            93 => [
                'permission_id' => 27,
                'role_id' => 6,
            ],
            94 => [
                'permission_id' => 5,
                'role_id' => 6,
            ],
            95 => [
                'permission_id' => 32,
                'role_id' => 6,
            ],
            96 => [
                'permission_id' => 33,
                'role_id' => 6,
            ],
            97 => [
                'permission_id' => 34,
                'role_id' => 6,
            ],
            98 => [
                'permission_id' => 35,
                'role_id' => 6,
            ],
            99 => [
                'permission_id' => 36,
                'role_id' => 6,
            ],
            100 => [
                'permission_id' => 1,
                'role_id' => 8,
            ],
            101 => [
                'permission_id' => 11,
                'role_id' => 8,
            ],
            102 => [
                'permission_id' => 56,
                'role_id' => 8,
            ],
            103 => [
                'permission_id' => 2,
                'role_id' => 8,
            ],
            104 => [
                'permission_id' => 12,
                'role_id' => 8,
            ],
            105 => [
                'permission_id' => 14,
                'role_id' => 8,
            ],
            106 => [
                'permission_id' => 15,
                'role_id' => 8,
            ],
            107 => [
                'permission_id' => 16,
                'role_id' => 8,
            ],
            108 => [
                'permission_id' => 21,
                'role_id' => 8,
            ],
            109 => [
                'permission_id' => 3,
                'role_id' => 8,
            ],
            110 => [
                'permission_id' => 26,
                'role_id' => 8,
            ],
            111 => [
                'permission_id' => 4,
                'role_id' => 8,
            ],
            112 => [
                'permission_id' => 27,
                'role_id' => 8,
            ],
            113 => [
                'permission_id' => 28,
                'role_id' => 8,
            ],
            114 => [
                'permission_id' => 29,
                'role_id' => 8,
            ],
            115 => [
                'permission_id' => 30,
                'role_id' => 8,
            ],
            116 => [
                'permission_id' => 31,
                'role_id' => 8,
            ],
            117 => [
                'permission_id' => 1,
                'role_id' => 7,
            ],
            118 => [
                'permission_id' => 11,
                'role_id' => 7,
            ],
            119 => [
                'permission_id' => 56,
                'role_id' => 7,
            ],
            120 => [
                'permission_id' => 2,
                'role_id' => 7,
            ],
            121 => [
                'permission_id' => 12,
                'role_id' => 7,
            ],
            122 => [
                'permission_id' => 13,
                'role_id' => 7,
            ],
            123 => [
                'permission_id' => 14,
                'role_id' => 7,
            ],
            124 => [
                'permission_id' => 15,
                'role_id' => 7,
            ],
            125 => [
                'permission_id' => 16,
                'role_id' => 7,
            ],
            126 => [
                'permission_id' => 18,
                'role_id' => 7,
            ],
            127 => [
                'permission_id' => 19,
                'role_id' => 7,
            ],
            128 => [
                'permission_id' => 21,
                'role_id' => 7,
            ],
            129 => [
                'permission_id' => 22,
                'role_id' => 7,
            ],
            130 => [
                'permission_id' => 23,
                'role_id' => 7,
            ],
            131 => [
                'permission_id' => 24,
                'role_id' => 7,
            ],
            132 => [
                'permission_id' => 25,
                'role_id' => 7,
            ],
            133 => [
                'permission_id' => 3,
                'role_id' => 7,
            ],
            134 => [
                'permission_id' => 26,
                'role_id' => 7,
            ],
            135 => [
                'permission_id' => 4,
                'role_id' => 7,
            ],
            136 => [
                'permission_id' => 27,
                'role_id' => 7,
            ],
            137 => [
                'permission_id' => 28,
                'role_id' => 7,
            ],
            138 => [
                'permission_id' => 29,
                'role_id' => 7,
            ],
            139 => [
                'permission_id' => 30,
                'role_id' => 7,
            ],
            140 => [
                'permission_id' => 31,
                'role_id' => 7,
            ],
            141 => [
                'permission_id' => 5,
                'role_id' => 7,
            ],
            142 => [
                'permission_id' => 32,
                'role_id' => 7,
            ],
            143 => [
                'permission_id' => 33,
                'role_id' => 7,
            ],
            144 => [
                'permission_id' => 34,
                'role_id' => 7,
            ],
            145 => [
                'permission_id' => 35,
                'role_id' => 7,
            ],
            146 => [
                'permission_id' => 36,
                'role_id' => 7,
            ],
            147 => [
                'permission_id' => 8,
                'role_id' => 7,
            ],
            148 => [
                'permission_id' => 37,
                'role_id' => 7,
            ],
            149 => [
                'permission_id' => 38,
                'role_id' => 7,
            ],
            150 => [
                'permission_id' => 39,
                'role_id' => 7,
            ],
            151 => [
                'permission_id' => 40,
                'role_id' => 7,
            ],
            152 => [
                'permission_id' => 9,
                'role_id' => 7,
            ],
            153 => [
                'permission_id' => 42,
                'role_id' => 7,
            ],
            154 => [
                'permission_id' => 43,
                'role_id' => 7,
            ],
            155 => [
                'permission_id' => 44,
                'role_id' => 7,
            ],
            156 => [
                'permission_id' => 45,
                'role_id' => 7,
            ],
            157 => [
                'permission_id' => 1,
                'role_id' => 3,
            ],
            158 => [
                'permission_id' => 11,
                'role_id' => 3,
            ],
            159 => [
                'permission_id' => 56,
                'role_id' => 3,
            ],
            160 => [
                'permission_id' => 2,
                'role_id' => 3,
            ],
            161 => [
                'permission_id' => 12,
                'role_id' => 3,
            ],
            162 => [
                'permission_id' => 13,
                'role_id' => 3,
            ],
            163 => [
                'permission_id' => 14,
                'role_id' => 3,
            ],
            164 => [
                'permission_id' => 15,
                'role_id' => 3,
            ],
            165 => [
                'permission_id' => 16,
                'role_id' => 3,
            ],
            166 => [
                'permission_id' => 18,
                'role_id' => 3,
            ],
            167 => [
                'permission_id' => 19,
                'role_id' => 3,
            ],
            168 => [
                'permission_id' => 21,
                'role_id' => 3,
            ],
            169 => [
                'permission_id' => 22,
                'role_id' => 3,
            ],
            170 => [
                'permission_id' => 23,
                'role_id' => 3,
            ],
            171 => [
                'permission_id' => 24,
                'role_id' => 3,
            ],
            172 => [
                'permission_id' => 25,
                'role_id' => 3,
            ],
            173 => [
                'permission_id' => 3,
                'role_id' => 3,
            ],
            174 => [
                'permission_id' => 26,
                'role_id' => 3,
            ],
            175 => [
                'permission_id' => 4,
                'role_id' => 3,
            ],
            176 => [
                'permission_id' => 27,
                'role_id' => 3,
            ],
            177 => [
                'permission_id' => 9,
                'role_id' => 3,
            ],
            178 => [
                'permission_id' => 42,
                'role_id' => 3,
            ],
            179 => [
                'permission_id' => 43,
                'role_id' => 3,
            ],
            180 => [
                'permission_id' => 44,
                'role_id' => 3,
            ],
            181 => [
                'permission_id' => 45,
                'role_id' => 3,
            ],
            182 => [
                'permission_id' => 1,
                'role_id' => 2,
            ],
            183 => [
                'permission_id' => 11,
                'role_id' => 2,
            ],
            184 => [
                'permission_id' => 2,
                'role_id' => 2,
            ],
            185 => [
                'permission_id' => 12,
                'role_id' => 2,
            ],
            186 => [
                'permission_id' => 13,
                'role_id' => 2,
            ],
            187 => [
                'permission_id' => 14,
                'role_id' => 2,
            ],
            188 => [
                'permission_id' => 18,
                'role_id' => 2,
            ],
            189 => [
                'permission_id' => 19,
                'role_id' => 2,
            ],
            190 => [
                'permission_id' => 21,
                'role_id' => 2,
            ],
            191 => [
                'permission_id' => 24,
                'role_id' => 2,
            ],
            192 => [
                'permission_id' => 3,
                'role_id' => 2,
            ],
            193 => [
                'permission_id' => 26,
                'role_id' => 2,
            ],
            194 => [
                'permission_id' => 4,
                'role_id' => 2,
            ],
            195 => [
                'permission_id' => 27,
                'role_id' => 2,
            ],
        ]);

    }
}
