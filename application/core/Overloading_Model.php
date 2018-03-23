<?php defined('BASEPATH') OR exit('no direct script access allrowed');

abstract class Overloading_Model extends CI_Model{

    function __construct($config=null){
        parent:: __construct();
    }
    
    //usage: declare function below like this in child class.
    public function method(...$params)
    {
        return overrloading("method",$params);
    }
    public function method0()
    {
        //code...
    }
    public function method1($param1)
    {
        //code...
    }
    public function method2($param1,$param2)
    {
        //code...
    }
    //and use child class
    //example : childInstance->method(); childInstance->method($argument1); childInstance->method($argument1,$argument2);
    //params maxium num is 10.
    //
    protected function overrloading($methodName , ...$params)
    {
        $suffix = (int)func_num_args()-1;
        $oriMethodToCall=$MethodToCall=$methodName.$suffix;
        
        while(method_exists($this,$MethodToCall) === false)
        {
            if($suffix >= 10)
            {
                throw new RuntimeException("no exist original method {$oriMethodToCall} and another");
            }
             $suffix=$suffix + 1;
             $MethodToCall=$methodName.$suffix; 
        }

        switch(count($params))
        {
            case 0: return $this->$MethodToCall(); break;
            case 1: return $this->$MethodToCall($params[0]); break;
            case 2: return $this->$MethodToCall($params[0],$params[1]); break;
            case 3: return $this->$MethodToCall($params[0],$params[1],$params[2]); break;
            case 4: return $this->$MethodToCall($params[0],$params[1],$params[2],$params[3]); break;
            case 5: return $this->$MethodToCall($params[0],$params[1],$params[2],$params[3],$params[4]); break;
            case 6: return $this->$MethodToCall($params[0],$params[1],$params[2],$params[3],$params[4],$params[5]); break;
            case 7: return $this->$MethodToCall($params[0],$params[1],$params[2],$params[3],$params[4],$params[5],$params[7]); break;
            case 8: return $this->$MethodToCall($params[0],$params[1],$params[2],$params[3],$params[4],$params[5],$params[7],$params[8]); break;
            case 9: return $this->$MethodToCall($params[0],$params[1],$params[2],$params[3],$params[4],$params[5],$params[7],$params[8],$params[9]); break;
            case 10: return $this->$MethodToCall($params[0],$params[1],$params[2],$params[3],$params[4],$params[5],$params[7],$params[8],$params[9],$params[10]); break;
        }
    }
}
