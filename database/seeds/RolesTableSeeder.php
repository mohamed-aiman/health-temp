<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
        	['name' => 'Front Desk', 'slug' => 'front_desk'],
        	['name' => 'Inspector', 'slug' => 'inspector'],
        	['name' => 'Supervisor', 'slug' => 'supervisor'],
            ['name' => 'Head', 'slug' => 'head'],
        	['name' => 'All', 'slug' => 'all'],
        ];

        $role = new Role;
        foreach ($roles as $data) {
            $role->create($data);
        }

        // $groups = [
        // 	'front_desk' => [
	       //  	'name' => 'Form Entering', 'slug' => 'form_entering',
	       //  	'name' => 'Scanning', 'slug' => 'scanning',
        // 	],
        // 	'inspector' => [
	       //  	'name' => 'Form Entering', 'slug' => 'form_entering',
	       //  	'name' => 'Filling Checklist', 'slug' => 'filling_checklist',
	       //  	'name' => 'Genratting Reports', 'slug' => 'genratting_reports',
	       //  	'name' => 'Get Approval From Supervisor', 'slug' => 'get_approval_from_supervisor',
	       //  	'name' => 'Take a printout and handover to client', 'slug' => 'take_a_printout_and_handover_to_client', 
	       //  	'name' => 'Entering next follow up date', 'slug' => 'entering_next_follow_up_date', 
	       //  	'name' => 'Entering Grading check list', 'slug' => 'entering_grading_check_list',
	       //  	'name' => 'Generate grading through data base (A,B,C)', 'slug' => 'generate_grading',
	       //  	'name' => 'Entering follow-up dates', 'slug' => 'entering_follow_up_dates',
	       //  	// 'name' => '', 'slug' => '',
	       //  	// 'name' => '', 'slug' => '',
	       //  	// 'name' => '', 'slug' => '',
	       //  	// 'name' => '', 'slug' => '',
	       //  	// 'name' => '', 'slug' => '',
        // 	]
        // ]

    }
}
