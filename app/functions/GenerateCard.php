<?php

namespace app\functions;


class GenerateCard{

    /*
    função que gera numero de cartão ordenados em grupo de 4 digitos 0000-0000-0000-0000-0000 digitos aleatorios*/
    public static function gCard(){

        $totalRows = 4;

        

        for ($i=0; $i <= $totalRows; $i++) { 
            $num = rand(1000,10000)." ".rand(1000,10000)." ".rand(1000,10000)." ".rand(1000,10000)." ".rand(1000,10000);
        }

        return $num;
    }

    /*
    função que gera numero de conta ordenados em 9 digitos 0000-0000 digitos aleatorios*/
    public static function gAccount(){

        $totalRows = 1;

        

        for ($i=0; $i <= $totalRows; $i++) { 
            $num = rand(1000,1000000000);
        }

        return $num;
    }


    /*
    função que gera Csv de 3 digitos aleatorios*/
    public static function gCsv(){

        $totalRows = 1;

      
            $num = rand(1000,100);
        

        return $num;

    }


    /*
    função que gera PIN de 4 digitos aleatorios*/
    public static function gPin(){
        
            $num = rand(1000,10000);
        
        return $num;

    }
}