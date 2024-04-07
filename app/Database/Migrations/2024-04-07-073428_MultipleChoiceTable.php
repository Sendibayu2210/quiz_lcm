<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MultipleChoiceTable extends Migration
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
            'id_question' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'choice_text' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'is_correct' => [
                'type' => 'ENUM("yes", "no")',
                'default' => 'no',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('multiple_choice');
    }

    public function down()
    {
        $this->forge->dropTable('multiple_choice');
    }
}
