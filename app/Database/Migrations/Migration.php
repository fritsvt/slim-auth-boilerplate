<?php

namespace App\Database\Migrations;

use Phinx\Migration\AbstractMigration;
use Illuminate\Database\Capsule\Manager as Capsule;

class Migration extends AbstractMigration
{
    protected $schema;

    public function init()
    {
        $this->schema = (new Capsule)->schema();
    }
}
