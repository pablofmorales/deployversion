<?php

use Phinx\Migration\AbstractMigration;

class ProjectsMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * Uncomment this method if you would like to use it.
     *
    public function change()
    {
    }
    */

    /**
     * Migrate Up.
     */
    public function up()
    {
        $tbl = $this->table('projects', ['id' => 'id']);
        $tbl->addColumn('name', 'string', ['limit' => 20])
            ->addColumn('code', 'string', ['limit' => 10])
            ->addColumn('version', 'string', ['limit' => 10])
            ->addColumn('created', 'datetime')
            ->addColumn('updated', 'datetime',
                ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['code'], ['unique' => true])
            ->save();

        $this->execute("INSERT INTO projects
            (name, code, version, created) VALUES
            ('test', 'test', '2.1.01', '2015-06-23 00:00:00')"
        );


    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
