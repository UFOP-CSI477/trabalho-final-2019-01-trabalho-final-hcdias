<?php

use Illuminate\Database\Seeder;
use PesquisaProjeto\Professor;

class ProfessorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(PesquisaProjeto\Professor::class,5)->create();

        $np1 = new Professor();
        $np1->professor_siape = '1000001';
        $np1->professor_nome = 'Alana Deusilan Sester Pereira';
        $np1->departamento_id = '1';
        $np1->save();

        $np2 = new Professor();
        $np2->professor_siape = '1000002';
        $np2->professor_nome = 'Alexandre Xavier Martins';
        $np2->departamento_id = '1';
        $np2->save();


        $np3 = new Professor();
        $np3->professor_siape = '1000003';
        $np3->professor_nome = 'Elisângela de Fátima Oliveira';
        $np3->departamento_id = '1';
        $np3->save();

        $np4 = new Professor();
        $np4->professor_siape = '1000004';
        $np4->professor_nome = 'Eva Bessa Soares';
        $np4->departamento_id = '1';
        $np4->save();

        $np5 = new Professor();
        $np5->professor_siape = '1000005';
        $np5->professor_nome = 'Frederico César de Vasconcelos Gomes';
        $np5->departamento_id = '1';
        $np5->save();

        $np6 = new Professor();
        $np6->professor_siape = '1000006';
        $np6->professor_nome = 'Gilbert Cardoso Bouyer';
        $np6->departamento_id = '1';
        $np6->save();

        $np7 = new Professor();
        $np7->professor_siape = '1000007';
        $np7->professor_nome = 'Isabela Carvalho de Morais';
        $np7->departamento_id = '1';
        $np7->save();

        $np8 = new Professor();
        $np8->professor_siape = '1000008';
        $np8->professor_nome = 'Jean Carlos Machado Alves';
        $np8->departamento_id = '1';
        $np8->save();

        $np9 = new Professor();
        $np9->professor_siape = '1000009';
        $np9->professor_nome = 'June Marques Fernandes';
        $np9->departamento_id = '1';
        $np9->save();

        $np10 = new Professor();
        $np10->professor_siape = '1000010';
        $np10->professor_nome = 'Luciana Paula Reis';
        $np10->departamento_id = '1';
        $np10->save();

        $np11 = new Professor();
        $np11->professor_siape = '1000011';
        $np11->professor_nome = 'Maressa Nunes Ribeiro Tavares';
        $np11->departamento_id = '1';
        $np11->save();

        $np12 = new Professor();
        $np12->professor_siape = '1000012';
        $np12->professor_nome = 'Mônica do Amaral';
        $np12->departamento_id = '1';
        $np12->save();

        $np13 = new Professor();
        $np13->professor_siape = '1000013';
        $np13->professor_nome = 'Paganini Barcellos de Oliveira';
        $np13->departamento_id = '1';
        $np13->save();

        $np14 = new Professor();
        $np14->professor_siape = '1000014';
        $np14->professor_nome = 'Rafael Lucas Machado Pinto';
        $np14->departamento_id = '1';
        $np14->save();

        $np15 = new Professor();
        $np15->professor_siape = '1000015';
        $np15->professor_nome = 'Rita de Cássia Oliveira';
        $np15->departamento_id = '1';
        $np15->save();

        $np16 = new Professor();
        $np16->professor_siape = '1000016';
        $np16->professor_nome = 'Sérgio Evangelista Silva';
        $np16->departamento_id = '1';
        $np16->save();

        $np17 = new Professor();
        $np17->professor_siape = '1000017';
        $np17->professor_nome = 'Thiago Augusto de Oliveira Silva';
        $np17->departamento_id = '1';
        $np17->save();

        $np18 = new Professor();
        $np18->professor_siape = '1000018';
        $np18->professor_nome = 'Viviane da Silva Serafim';
        $np18->departamento_id = '1';
        $np18->save();

        $np19 = new Professor();
        $np19->professor_siape = '1000019';
        $np19->professor_nome = 'Wagner Ragi Curi Filho';
        $np19->departamento_id = '1';
        $np19->save();
    }
}
