<?php

include'ExceptionMapper.php';

/**
 * method1() is a method  call the method method2()
 *
 */
function method1(Mapper $objMapper)
{
	method2($objMapper);
}

/**
 * method2() is a method  call the method method3()
 *
 */
function method2(Mapper $objMapper)
{
	method3($objMapper);
}

/**
 * method3() is a method  call the method GetExceptionInfo()
 *
 */
function method3(Mapper $objMapper)
{
	
	
	try
	{		
		throw new Exception('Some Error Message');		
	}
	catch (Exception $e)
	{
		//$s=$objMapping->GetExceptionInfo($e);		
		
		$s=Mapper::GetExceptionInfo($e,"given");
		echo "<br>"."Exception Type :".$s->get_ExceptionType();	
		echo "<br>"."Alternate Text :".$s->get_AlternateText();		
		echo "<br>"."Message :".$s->get_Message();		
		echo "<br>"."Stack Trace :".$s->get_StackTrace();	
		echo "<br>"."Class Name : ".$s->get_ClassName();
		echo "<br>"."StatusCode : ".$s->get_StatusCode();		
	}
	
	
	
}
// Create object of Mapper class
$objMapper=new Mapper();
//$GLOBALS['xmlFilePath']="D:\Sudhir\Working Directory\Eclips Project\XML\ExceptionMapping.xml";
method1($objMapper);

?>