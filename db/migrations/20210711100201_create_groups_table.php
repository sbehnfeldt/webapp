<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateGroupsTable extends AbstractMigration
{
    private $tableName = 'groups';

    public function up(): void
    {
        ////////////////////////////////////////////////////////////////////////////////
        /// User Accounts
        ////////////////////////////////////////////////////////////////////////////////
        $table = $this->table($this->tableName);
        $table->addColumn('groupname', 'string', ['limit' => 63, 'null' => false]);
        $table->addColumn('description', 'string', ['limit' => 255, 'null' => false]);
        $table->addIndex('groupname', ['unique' => true]);
        $table->save();
    }

    public function down(): void
    {
        $this->table($this->tableName)->drop()->save();
    }
}
