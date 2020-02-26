<?php

class openFile 
{

    function __construct($file) 
    {
        $file1 = file($file);

        $file = file_get_contents($file);

        // $grid = "..o......" . PHP_EOL .
        //         "..o..o..." . PHP_EOL .
        //         "...o....." . PHP_EOL .
        //         ".......o." . PHP_EOL .
        //         "..o......" . PHP_EOL .
        //         "........." . PHP_EOL .
        //         "o........" . PHP_EOL .
        //         "........o" . PHP_EOL .
        //         "........." . PHP_EOL;

        $makeArray = new makeArray($file);
        
    }
}

class makeArray 
{
    function __construct($lines) 
    {
        
        //Toutes les lignes dans tableau 
        $lines = explode("\n", $lines);
        $data = array();
        foreach($lines as $value) {

            array_push($data, str_split($value)); 
        }
        verify::$squareXY = array_shift($data);
        
        $verify = new verify($data);
    }
}

class verify 
{

    public static $squareXY;

    function __construct($data) 
    {
        $colNbr = 0;
        $totalLineNbr = -1;
        $lineNbr = 0;
        $remove = array_pop($data);
        $i = 0;
        
        $biggerSquareSize = 0;
        $biggerSquareSizeX = 0;
        $biggerSquareSizeY = 0;
        foreach ($data as $lines) {
            
            foreach ($lines as $element) {
                makeSquare::$totalElements++;
                
                if($element == "o"){
                    makeSquare::$trueObstacleNbr++;
                    makeSquare::$currentObstacleNbr++;
                }
                $i++;
            }
        }

        foreach($data as $lines) {
            $colNbr = 0;           
            foreach ($lines as $element) {

                if($element == "."){
                    $squareSize = 1;
                                                 
                    while(makeSquare::$currentObstacleNbr == makeSquare::$trueObstacleNbr && $squareSize < verify::$squareXY) {
                        if($colNbr < verify::$squareXY && $lineNbr < verify::$squareXY){

                            $makeSquare = new makeSquare($data, $squareSize, $colNbr, $lineNbr);
                            
                            // echo "biggerSquareSize " . $biggerSquareSize . PHP_EOL;
                            // echo "biggerSquareSizeX " . $biggerSquareSizeX . PHP_EOL;
                            // echo "biggerSquareSizeY " . $biggerSquareSizeY . PHP_EOL;
                            $squareSize++;
                            // usleep(100000);
                        }
                    }
                    
                    foreach ($data as $lines) {
                        $totalLineNbr++;
                                               
                    }
                    $t = $totalLineNbr - $squareSize;
                
                    if($biggerSquareSize < $squareSize - 1 && $squareSize < $t){
                        
                        $biggerSquareSize = $squareSize - 1;
                        $biggerSquareSizeX = $colNbr;
                        $biggerSquareSizeY = $lineNbr;
                    }   
                    makeSquare::$currentObstacleNbr = makeSquare::$trueObstacleNbr;
                    $colNbr++;
                }
            }
           $lineNbr++;
        }

        $biggerSquareSize -= 1;
        $final = true;
        $makeSquare = new makeSquare($data, $biggerSquareSize, $biggerSquareSizeX, $biggerSquareSizeY, $final);     
    }
}

class makeSquare 
{
    public static $currentObstacleNbr;
    public static $trueObstacleNbr;
    public static $totalElements;

    function __construct($data, $squareSize, $colStartsAt, $lineStartsAt, $final = false) 
    {
        // $squareSize = 5;
        // $colStartsAt = 4 - 1;
        // $lineStartsAt = 5 - 1;
        $trueObstacleNbr = 8;
        $currentObstacleNbr = 0;
        $square = $squareSize + $colStartsAt;
        $line = 0;
        $total = 0;

        while($line < $squareSize){
            for($i = $colStartsAt; $i < $square; $i++){
                if(isset($data[$lineStartsAt])){
                    $rep = array_replace($data[$lineStartsAt], array($i => "x"));
                    $data = array_replace($data, array($lineStartsAt => $rep));
                }else{
                    break 2;
                }
            }

            $lineStartsAt++;
            $line++;
        }

        foreach ($data as $lines) {
            foreach ($lines as $element) {
                $total++;
                if($element == "o"){
                    $currentObstacleNbr++;
                }
            }
        }

        if($currentObstacleNbr != $trueObstacleNbr) {
            makeSquare::$currentObstacleNbr = $currentObstacleNbr;

        }
        if($total != makeSquare::$totalElements){
            makeSquare::$currentObstacleNbr = 0;
        }

        if($final == true){
            $genGrid = new genGrid($data);

        }
    
    }
}

class genGrid 
{
    function __construct($data) 
    {
        foreach($data as $lines){
            echo implode("", $lines) . PHP_EOL;            
        }
    }
}

$open = new openFile($argv[1]);



