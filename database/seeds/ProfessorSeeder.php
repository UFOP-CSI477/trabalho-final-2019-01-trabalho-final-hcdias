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
        $np1->siape = '1000001';
        $np1->email = '1000001@ufop.br';
        $np1->nome = 'Alana Deusilan Sester Pereira';
        $np1->departamento_id = '1';
        $np1->save();

        $np2 = new Professor();
        $np2->siape = '1000002';
        $np2->email = '1000002@ufop.br';
        $np2->nome = 'Alexandre Xavier Martins';
        $np2->departamento_id = '1';
        $np2->save();


        $np3 = new Professor();
        $np3->siape = '1000003';
        $np3->email = '1000003@ufop.br';
        $np3->nome = 'Elisângela de Fátima Oliveira';
        $np3->departamento_id = '1';
        $np3->save();

        $np4 = new Professor();
        $np4->siape = '1000004';
        $np4->email = '1000004@ufop.br';
        $np4->nome = 'Eva Bessa Soares';
        $np4->departamento_id = '1';
        $np4->save();

        $np5 = new Professor();
        $np5->siape = '1000005';
        $np5->email = '1000005@ufop.br';
        $np5->nome = 'Frederico César de Vasconcelos Gomes';
        $np5->departamento_id = '1';
        $np5->save();

        $np6 = new Professor();
        $np6->siape = '1000006';
        $np6->email = '1000006@ufop.br';
        $np6->nome = 'Gilbert Cardoso Bouyer';
        $np6->departamento_id = '1';
        $np6->save();

        $np7 = new Professor();
        $np7->siape = '1000007';
        $np7->email = '1000007@ufop.br';
        $np7->nome = 'Isabela Carvalho de Morais';
        $np7->departamento_id = '1';
        $np7->save();

        $np8 = new Professor();
        $np8->siape = '1000008';
        $np8->email = '1000008@ufop.br';
        $np8->nome = 'Jean Carlos Machado Alves';
        $np8->departamento_id = '1';
        $np8->save();

        $np9 = new Professor();
        $np9->siape = '1000009';
        $np9->email = '1000009@ufop.br';
        $np9->nome = 'June Marques Fernandes';
        $np9->departamento_id = '1';
        $np9->save();

        $np10 = new Professor();
        $np10->siape = '1000010';
        $np10->email = '1000010@ufop.br';
        $np10->nome = 'Luciana Paula Reis';
        $np10->departamento_id = '1';
        $np10->save();

        $np11 = new Professor();
        $np11->siape = '1000011';
        $np11->email = '1000011@ufop.br';
        $np11->nome = 'Maressa Nunes Ribeiro Tavares';
        $np11->departamento_id = '1';
        $np11->save();

        $np12 = new Professor();
        $np12->siape = '1000012';
        $np12->email = '1000012@ufop.br';
        $np12->nome = 'Mônica do Amaral';
        $np12->departamento_id = '1';
        $np12->save();

        $np13 = new Professor();
        $np13->siape = '1000013';
        $np13->email = '1000013@ufop.br';
        $np13->nome = 'Paganini Barcellos de Oliveira';
        $np13->departamento_id = '1';
        $np13->save();

        $np14 = new Professor();
        $np14->siape = '1000014';
        $np14->email = '1000014@ufop.br';
        $np14->nome = 'Rafael Lucas Machado Pinto';
        $np14->departamento_id = '1';
        $np14->save();

        $np15 = new Professor();
        $np15->siape = '1000015';
        $np15->email = '1000015@ufop.br';
        $np15->nome = 'Rita de Cássia Oliveira';
        $np15->departamento_id = '1';
        $np15->save();

        $np16 = new Professor();
        $np16->siape = '1000016';
        $np16->email = '1000016@ufop.br';
        $np16->nome = 'Sérgio Evangelista Silva';
        $np16->departamento_id = '1';
        $np16->save();

        $np17 = new Professor();
        $np17->siape = '1000017';
        $np17->email = '1000017@ufop.br';
        $np17->nome = 'Thiago Augusto de Oliveira Silva';
        $np17->departamento_id = '1';
        $np17->save();

        $np18 = new Professor();
        $np18->siape = '1000018';
        $np18->email = '1000018@ufop.br';
        $np18->nome = 'Viviane da Silva Serafim';
        $np18->departamento_id = '1';
        $np18->save();

        $np19 = new Professor();
        $np19->siape = '1000019';
        $np19->email = '1000019@ufop.br';
        $np19->nome = 'Wagner Ragi Curi Filho';
        $np19->departamento_id = '1';
        $np19->save();
    }
}
