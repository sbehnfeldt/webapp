<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateGroupMembersTable extends AbstractMigration
{
    private $tableName = 'group_members';

    public function up(): void
    {
        $table = $this->table($this->tableName);
        $table->addColumn('group_id', 'integer');
        $table->addColumn('user_id', 'integer');
        $table->addForeignKey('group_id', 'groups', 'id', [ 'delete' => 'CASCADE', 'update' => 'NO_ACTION']);
        $table->addForeignKey('user_id', 'groups', 'id', [ 'delete' => 'CASCADE', 'update' => 'NO_ACTION']);
        $table->addIndex([ 'group_id', 'user_id'], [ 'unique' => true]);
        $table->save();
    }

    public function down()
    {
        $this->table($this->tableName)->drop()->save();
    }
}
