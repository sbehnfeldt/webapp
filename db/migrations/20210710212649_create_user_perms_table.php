<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUserPermsTable extends AbstractMigration
{
    private $tableName = 'user_permissions';

    public function up(): void
    {
        $table = $this->table($this->tableName);
        $table->addColumn('user_id', 'integer');
        $table->addColumn('permissions_id', 'integer');
        $table->addForeignKey('user_id', 'users', 'id', [ 'delete' => 'CASCADE', 'update' => 'NO_ACTION']);
        $table->addForeignKey('permissions_id', 'permissions', 'id', [ 'delete' => 'CASCADE', 'update' => 'NO_ACTION']);
        $table->addIndex('user_id');
        $table->save();
    }

    public function down(): void
    {
        $this->table($this->tableName)->drop()->save();
    }
}
