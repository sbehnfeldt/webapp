<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateLoginAttemptsTable extends AbstractMigration
{
    private $tableName = 'login_attempts';

    public function up(): void
    {
        $table = $this->table($this->tableName);
        $table->addColumn('username', 'string', ['length' => 63, 'default' => '']);
        $table->addCOlumn('attempted_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addCOlumn('remember', 'boolean', ['default' => true]);
        $table->addColumn('user_id', 'integer', ['null' => true, 'length' => 11, 'default' => 0]);
        $table->addColumn('logout_at', 'timestamp', ['null' => true]);
        $table->addColumn('note', 'string', ['default' => '']);
        $table->addIndex('username');
        $table->addForeignKey('user_id', 'users', 'id', [ 'delete' => 'RESTRICT', 'update' => 'NO_ACTION']);
        $table->save();
    }

    public function down(): void
    {
        $this->table($this->tableName)->drop()->save();
    }
}
