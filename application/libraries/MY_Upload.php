<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class MY_Upload extends CI_Upload {
    
    public $files =null;
    public $inputName =null;
    public function __construct($config = array())
    {
            parent::__construct($config);
           $this->files =  $_FILES;
           $this->inputName ="files"; // input name
           $this->limit_numFiles =10;
    }
    private function getConfig($kind)
    {
        
        $config['overwrite'] = FALSE;
        if($kind === "image")
        {
            $config['max_size'] = '10000000'; //10mg
            $config['allowed_types'] = 'jpg|png|jpeg|bmp|tiff';
            $config['max_width']  = '10240';
            $config['max_height']  = '7680';
        }
        else if($kind === "file")
        {
            $config['max_size'] = uploadLimitSize; //2mg
            $config['allowed_types'] = 'gif|jpg|jpeg|png|txt|zip|xlsx|xls|hwp';
        }
        else
        {
            $config['allowed_types'] = '*';
        }
        return $config;
    }
    
    private function returnNone()
    {
        if(isset($_FILES[$this->inputName])===false) return false;
        if($_FILES[$this->inputName]["name"][0] === "") return false;
        $cpt = count($_FILES[$this->inputName]['name']);
        if($cpt > $this->limit_numFiles)
        {
            return false;
        }

        
        return true;
    }
    public function vlidationFileSize($fileName,$limitSize)
    {
        $fileSizeValidation = true;
        if(isset($_FILES[$fileName]["size"]))
        foreach ($_FILES[$fileName]["size"] as $size) {
            if($size >= $limitSize)
            {
                $fileSizeValidation = false;
                break;
            }
        }        
        return $fileSizeValidation;
    }
    public function validation($kind,$inputConfig=array())
    {
        if(($this->returnNone()) === false)  return array("result"=>"none"); //보낸 파일이없다면 return

        $config = $this->getConfig($kind);
        foreach ($inputConfig as $key => $value) {
            $config[$key] = $value;
        }

        $cpt = count($_FILES[$this->inputName]['name']);
        $data["result"] = "success";
        $data["errors"] = "";
        $data["files"] =array();
        if($_FILES[$this->inputName]["name"][0] === "") return array("result"=>"none"); //보낸 파일이없다면 return
        for($i=0; $i<$cpt; $i++)
        {           
            $original_name = $this->files[$this->inputName]['name']= $_FILES[$this->inputName]['name'][$i];
            $this->files[$this->inputName]['type']= $_FILES[$this->inputName]['type'][$i];
            $this->files[$this->inputName]['tmp_name']= $_FILES[$this->inputName]['tmp_name'][$i];
            $this->files[$this->inputName]['error']= $_FILES[$this->inputName]['error'][$i];
            $this->files[$this->inputName]['size']= $_FILES[$this->inputName]['size'][$i];    
            
            $this->initialize($config);
            if (!$this->do_upload($this->inputName,true)) 
            {//실패
                $error = $this->display_errors(false,false);
                $data["files"][] = array("result"=>"fail","error"=>$error,"fileName"=>$original_name);
                $data["result"] = "fail";
                $data["errors"] .= "{$original_name}은(는) {$error} \n";
            }
            else//성공
            {
                $data["files"][] = array("result"=>"success","fileName"=>$original_name);
            }
        }
        //끝
        return $data;
    }
    public function multiUpload($kind,$who,$inputConfig = array())
    {       
        if(($this->returnNone()) === false)  return array("result"=>"none"); //보낸 파일이없다면 return
        $successCallback = $inputConfig["successCallback"] ?? null;
        $failCallback = $inputConfig["failCallback"] ?? null;
        $endCallback = $inputConfig["endCallback"] ?? null;

        $config = $this->getConfig($kind);
        $config['encrypt_name'] = TRUE;
        $config['upload_path'] = "./public/uploads/{$who}/{$kind}s";
        
        $fileUri = "";
        $cpt = count($_FILES[$this->inputName]['name']);
        
        $data["result"] = "success";
        $data["errors"] = "";
        $data["files"] =array();
        
        for($i=0; $i<$cpt; $i++)
        {           
            $original_name = $this->files[$this->inputName]['name']= $_FILES[$this->inputName]['name'][$i];
            $extention =$this->files[$this->inputName]['type']= $_FILES[$this->inputName]['type'][$i];
            $this->files[$this->inputName]['tmp_name']= $_FILES[$this->inputName]['tmp_name'][$i];
            $this->files[$this->inputName]['error']= $_FILES[$this->inputName]['error'][$i];
            $size=$this->files[$this->inputName]['size']= $_FILES[$this->inputName]['size'][$i];    
            
            $this->initialize($config);
            if (!$this->do_upload($this->inputName)) {//실패
                $error = $this->display_errors(false,false);
                $data["files"][] = array("result"=>"fail","error"=>$error,"fileName"=>$original_name);
                $data["result"] = "fail";
                $data["errors"] .= "{$original_name}은(는) {$error} \n";
                if($failCallback !== null)
                {
                    $failCallback($error);
                }
            }
            else//성공
            {
                $fileName= $this->data()['file_name'];
                
                $fileUri= "/public/uploads/{$who}/{$kind}s/{$fileName}";
                $tmp_data=array(
                    "result"=>"success",
                    "uri"=>$fileUri,
                    "original_name"=>$original_name,
                    "extention"=>$extention,
                    "tmp_name"=>$fileName,
                    "size"=>$size
                );
                $data["files"][] =$tmp_data;
                if($successCallback !== null)
                {
                    $successCallback($tmp_data);
                }
            }
        }
        //끝

        if($endCallback !== null)
        {
            $endCallback($data);
        }
        return $data;
    }
    
   
    
    public function verifyFileContentType($allowedType,$fileName)
    {   
        $type = strtolower($this->getFileCOntentType($fileName));
        $arr_allowedType = explode("|",$allowedType);
        $sw_ok = false;
        foreach ($arr_allowedType as $key => $item_arr_allowedType)
         {
            $item_arr_allowedType =strtolower($item_arr_allowedType);
            if($type === $item_arr_allowedType)
            {
                $sw_ok = true;
                break;
            }
        }
        return $sw_ok;
    }
    private function getFileCOntentType($fileName)
    {
        list(,$type) = explode(".",$fileName);
        return $type;
    }
}