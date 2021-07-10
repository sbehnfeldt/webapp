<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateLoginAttemptsAlterRememberColumn extends AbstractMigration
{
    private $tableName = 'login_attempts';

    public function up(): void
    {
        $table = $this->table($this->tableName);
        $table->changeColumn('remember', 'timestamp');
        $table->save();
    }

    public function down(): void
    {
        $table = $this->table($this->tableName);
        $table->changeColumn('remember', 'boolean', ['default' => true]);
    }
}
