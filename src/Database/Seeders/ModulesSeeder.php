<?php
namespace Sty\Hutton\Database\Seeders;

use App\Database\Seeders\ModuleSeeder;

class ModulesSeeder extends ModuleSeeder
{
    /*
     *
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        /* Admin Modules */

        // Fixes Module
        $this->insertModule('fixes', 'user-group', 'Fixes');

        // Joiners Module
        $this->insertModule('joiners', 'user-group', 'Joiners');

        // Joiners Module
        $this->insertModule('builders', 'user-group', 'Builder');

        // Jobs Module
        $this->insertModule('hutton-jobs', 'user-group', 'Hutton Jobs');

        // Jobs Module
        $this->insertModule('wage-sheet', 'user-group', 'WageSheet');

        // Reports Module
        $this->insertModule('reports', 'user-group', 'Reports');

        /* 
            Joiner Modules Start here 
        */

        // Joiner Jobs Module
        $this->insertModule('joiner-jobs', 'user-group', 'My Jobs');

        // Joiner Weekly Work Module
        $this->insertModule('my-weekly-work', 'user-group', 'My Weekly Work');

        // Joiner Daily Work Module
        $this->insertModule('my-daily-work', 'user-group', 'My Daily Work');

        // Joiner Work History Module
        $this->insertModule(
            'joiner-work-history',
            'user-group',
            'My Work History'
        );

        /* 
            Joiner Modules End here 
        */
    }
}
