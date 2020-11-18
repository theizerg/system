<?php

use Illuminate\Database\Seeder;

class AdministracionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	 DB::table('tasas_iva')->insert([
            'nombre' => 'Básica',
            'tasa' => 16
        ]);
        DB::table('tasas_iva')->insert([
            'nombre' => 'Mínimo',
            'tasa' => 12
        ]);
        DB::table('tasas_iva')->insert([
            'nombre' => 'Exento',
            'tasa' => 0
        ]);


         DB::table('monedas')->insert([
            'nombre' => 'Bolívares Soberanos',
            'simbolo' => 'BSS',
            'redondeo' => 0
        ]);

        DB::table('monedas')->insert([
            'nombre' => 'Dólares',
            'simbolo' => 'U$S',
            'redondeo' => 2            
        ]);

       DB::table('generos')->insert([
            'nb_genero' => 'Masculino'     
        ]);
        DB::table('generos')->insert([
            'nb_genero' => 'Femenino'     
        ]);

        DB::table('nacionalidades')->insert([
            'nb_nacionalidad' => 'V'     
        ]);


        DB::table('nacionalidades')->insert([
            'nb_nacionalidad' => 'E'     
        ]);
         
        DB::table('tipo_pagos')->insert([
                    'nb_tipo_pago' => 'EFECTIVO'     
        ]);

        DB::table('tipo_pagos')->insert([
                    'nb_tipo_pago' => 'TRAMSFERENCIA'     
        ]);

        DB::table('tipo_pagos')->insert([
                    'nb_tipo_pago' => 'PAGO MOVIL'     
        ]);



    }
}
