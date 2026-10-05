<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PagePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name'=>'Pages — View','slug'=>'pages.view','module'=>'pages','action'=>'view'],
            ['name'=>'Pages — Create','slug'=>'pages.create','module'=>'pages','action'=>'create'],
            ['name'=>'Pages — Update','slug'=>'pages.update','module'=>'pages','action'=>'update'],
            ['name'=>'Pages — Delete','slug'=>'pages.delete','module'=>'pages','action'=>'delete'],
            ['name'=>'Page Sections — Create','slug'=>'pages.sections.create','module'=>'pages','action'=>'sections.create'],
            ['name'=>'Page Sections — Update','slug'=>'pages.sections.update','module'=>'pages','action'=>'sections.update'],
            ['name'=>'Page Sections — Delete','slug'=>'pages.sections.delete','module'=>'pages','action'=>'sections.delete'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['slug'=>$permission['slug']], $permission);
        }
    }
}
