<?php

use Phinx\Migration\AbstractMigration;

class User extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $user = $this->table('user');
        $user
            ->addColumn('email', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('first_name', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('last_name', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('password', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('deleted_at', 'timestamp', ['null' => true])
        ;

        $user->create();
    }
}