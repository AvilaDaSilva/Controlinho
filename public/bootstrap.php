<?php  
function __autoload($className)  
{  
    $className = ltrim($className, '\\'); 
    $fileName  = ''; 
    $namespace = ''; 
    if ($lastNsPos = strrpos($className, '\\')) { 
        $namespace = substr($className, 0, $lastNsPos); 
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR; 
    } 
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';  
	if(file_exists('../lib'.DIRECTORY_SEPARATOR.$fileName))
	    	require '../lib'.DIRECTORY_SEPARATOR.$fileName;   
	if(file_exists('../src'.DIRECTORY_SEPARATOR.$fileName))
    		require '../src'.DIRECTORY_SEPARATOR.$fileName;
	if(file_exists('../conf'.DIRECTORY_SEPARATOR.$fileName))
    		require '../conf'.DIRECTORY_SEPARATOR.$fileName;
}  
