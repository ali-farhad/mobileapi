<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ASeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('faq_answers')->insert([
            [
                'answer' => 'Nigedasht, an online platform serving patients and doctors by eliminating the boundaries of quality healthcare via onlin consultations, managing patient’s self and family medical records in ecure server, syncing data from multiple sources - all stitched together with intuitive user experience across computers, tablet and mobile devices.',
                'question_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),


            ],

            [
                'answer' => 'Nigedasht is available on the web and as a mobile app. To access the web version, simply visit www.nigedasht.com. To access the mobile app, download the app from the App Store or Google Play.',
                'question_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),   
            ],

            [
                'answer' => 'Nigedasht is compliant with HIPAA (Health Insurance Portability and Accountability Act) guidelines. Health records are kept totally secure and only shared between the doctor and the patient. There is nothing more important to us than keeping your data secure.',
                'question_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
         
        ]);
    }
}
