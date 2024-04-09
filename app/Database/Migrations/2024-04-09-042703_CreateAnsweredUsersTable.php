<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnsweredUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_question' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_answered' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_multiple_choice' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('answered_users');
    }

    public function down()
    {
        $this->forge->dropTable('answered_users');
    }
}
