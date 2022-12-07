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
        $this->insertModule('admin-dashboard', 'dashboard', 'Admin Dashboard');

        // Fixes Module
        $this->insertModule('fixes', 'screwdriver-wrench', 'Fixes');

        // Joiners Module
        $this->insertModule('joiners', 'helmet-safety', 'Joiners');

        // Joiners Module
        $this->insertModule('builders', 'user-group', 'Builder');

        // Jobs Module
        $this->insertModule('hutton-jobs', 'tasks', 'Hutton Jobs');

        // Jobs Module
        $this->insertModule('wage-sheet', 'sheet-plastic', 'WageSheet');

        // Reports Module
        $this->insertModule('reports', 'user-group', 'Reports');

        /* 
            Joiner Modules Start here 
        */

        // joiner dashoboard
        $this->insertModule(
            'joiner-dashboard',
            'dashboard',
            'Joiner Dashboard'
        );

        // Joiner Jobs Module
        $this->insertModule('joiner-jobs', 'tasks', 'My Jobs');

        // Joiner Weekly Work Module
        $this->insertModule('my-weekly-work', 'briefcase', 'My Weekly Work');

        // Joiner Daily Work Module
        $this->insertModule(
            'my-daily-work',
            'screwdriver-wrench',
            'My Daily Work'
        );

        // Joiner Work History Module
        $this->insertModule('my-work-history', 'history', 'My Work History');

        /* 
            Joiner Modules End here 
        */
    }
}
