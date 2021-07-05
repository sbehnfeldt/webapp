<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Users extends AbstractMigration
{
    private $tableName = 'users';

    public function up(): void
    {
        ////////////////////////////////////////////////////////////////////////////////
        /// User Accounts
        ////////////////////////////////////////////////////////////////////////////////
        $table = $this->table($this->tableName);
        $table->addColumn('username', 'string', ['limit' => 31, 'null' => false]);
        $table->addColumn('password', 'string', ['limit' => 63, 'null' => false]);
        $table->addColumn('email', 'string', ['limit' => 255]);
        $table->addIndex('username', ['unique' => true]);
        $table->save();
    }

    public function down(): void
    {
        $this->table($this->tableName)->drop()->save();
    }
}
