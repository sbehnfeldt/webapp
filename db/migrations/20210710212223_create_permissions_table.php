<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePermissionsTable extends AbstractMigration
{
    private $tableName = 'permissions';

    public function up(): void
    {
        $table = $this->table($this->tableName);
        $table->addColumn('slug', 'string', ['length' => 127]);
        $table->addColumn('description', 'string', ['length' => 1023]);
        $table->addIndex(['slug'], ['unique' => true]);
        $table->save();
    }

    public function down(): void
    {
        $this->table($this->tableName)->drop()->save();
    }
}
