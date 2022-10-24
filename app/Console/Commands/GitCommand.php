<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

class GitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'git:auto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Git auto deploy';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

//        $myArray = array(13,2,4,35,1, 35);
//        ##imprimer el valor mas alto del arreglo myArray
//        $max = max($myArray);
//        echo $max . PHP_EOL;
//
//        #otra forma de imprimir el valor mas alto del arreglo myArray
//        $max = $myArray[0];
//        foreach ($myArray as $value) {
//            if ($value > $max) {
//                $max = $value;
//            }
//        }
//        echo $max . PHP_EOL;





//
//        Scanner input=new Scanner(System.in);
//        System.out.println("Ingresa tamaño de la X:");
//        int tamano=input.nextInt();
//
//        if (tamano == 0)
//            System.out.println("ERROR");
//        else
//        {
//            String[][]dibujo = new String[tamano][tamano];
//
//            for ( int i=0; i < dibujo.length ;i++){
//            for (int j=0;  j<dibujo.length;j++){
//                int x = i +1;
//                    if((i==j)  ||  (j == (tamano - x))){
//                        dibujo[i][j] = "X";
//                        System.out.print(dibujo[i][j] + " ");
//                    }
//                    else{
//                        dibujo[i][j] = "_";
//                        System.out.print(dibujo[i][j] + " ");
//                    }
//                }
//                System.out.println();
//            }
//        }
//    }
//    $n = 5;
//    if($n == 0){
//        echo "ERROR";
//        exit(1);
//    }
//        $dibujo = array();
//        for($i = 0; $i < $n; $i++) {
//            for ($j = 0; $j < $n; $j++) {
//                $x = $i + 1;
//                if (($i == $j) || ($j == ($n - $x))) {
//                    $dibujo[$i][$j] = "X";
//                    echo $dibujo[$i][$j] . "";
//                } else {
//                    $dibujo[$i][$j] = "_";
//                    echo $dibujo[$i][$j] . "";
//                }
//            }
//            echo PHP_EOL;
//        }



        $myArray = [1, 1, 1, 2, 3, 3, 5, 5, 5];
//
//        $histogram = [];
//
//        for ($i = 0; $i < count($myArray); $i++) {
//            if (!isset($histogram[$myArray[$i]])) {
//                $histogram[$myArray[$i]] = 1;
//            } else {
//                $histogram[$myArray[$i]] += 1;
//            }
//        }
//
//        foreach ($histogram as $key => $value) {
//            echo $key . ': ';
//            for ($i = 0; $i < $value; $i++) {
//                echo '*';
//            }
//            echo PHP_EOL;
//        }


        $histogram = [];

        for ($i = 0; $i < count($myArray); $i++) {
            if (!isset($histogram[$myArray[$i]])) {
                $histogram[$myArray[$i]] = 1;
            } else {
                $histogram[$myArray[$i]] += 1;
            }
        }
        for ($i = 1; $i <= max($myArray); $i++) {
            if (!isset($histogram[$i])) {
                echo $i . ': ' . PHP_EOL;
            } else {
                echo $i . ': ';
                for ($j = 0; $j < $histogram[$i]; $j++) {
                    echo '*';
                }
                echo PHP_EOL;
            }
        }



//$myArray = array(1, 2, 3, 4, 5, 1, 2, 3, 1, 2);
//$count = 1;
//$current = null;
//$most = 0;
//$mostNum = null;
//
//foreach ($myArray as $num) {
//    if ($num == $current) {
//        $count++;
//    } else {
//        $count = 1;
//        $current = $num;
//    }
//    if ($count > $most) {
//        $most = $count;
//        $mostNum = $num;
//    }
//}
//echo $mostNum." appears ".$most." times in succession." . PHP_EOL;


#Tienes un arreglo (llamado myArray) con 10 elementos (enteros en el rango de 1 a 9). Escribe un programa en PHP que imprima el número que tiene más ocurrencias consecutivas en el arreglo y también imprimir la cantidad de veces que aparece en la secuencia.

//        $myArray = array(1,2,2,4,5,6,7,8,8,8,8);
//        $newArray = array_count_values($myArray);
//        $imprimir = array_search(max($newArray), $newArray);
//        $imprimir2 = max($newArray);
//        echo "Longest: " . $imprimir2 . PHP_EOL ."Number: " . $imprimir . PHP_EOL;
//

//        try {
//            //exec('git checkout cpanel-production');
//            exec('git pull');
//            exec('php composer install');
//            $this->info('Command success');
//        } catch (Exception $e) {
//            Log::info($e);
//        }
    }
}
