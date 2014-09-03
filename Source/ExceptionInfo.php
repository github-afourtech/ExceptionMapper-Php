<?php
/**
 * ExceptionInfo class is used to set values 
 *  className, Message,stackTrace,exceptionType,alternateText,statusCode  
 *
 * @author AFour Technologies
 * @version 1.0.0.0
 * @package AFourTech.ExceptionMapper
 */
// This is class show general information of exception
class ExceptionInfo
{
	var $message;
	var $stackTrace;
	var $alternateText=null;
	var $exceptionType;
	var $className;	
	var $statusCode; 
		
		
 /**
 * Set the Message
 *
 * @access public 
 * @param mixed $value
 */
	public function set_Message($value)
	{
		$this->message=$value;
	}
	
 /**
 * Set the Alternate Text
 *
 * @access public 
 * @param mixed $value
 */
	public function set_AlternateText($value)
	{
		$this->alternateText=$value;
	}
	
	
/**
 * Set the Class Name
 *
 * @access public 
 * @param mixed $value
 */
	public function set_ClassName($value)
	{
		$this->className=$value;
	}
	
/**
 * Set the Stack Trace
 *
 * @access public 
 * @param mixed $value
 */
	public function set_StackTrace($value)
	{
		$this->stackTrace=$value;
	}
	
	
/**
 * Set the Exception Type
 *
 * @access public 
 * @param mixed $value
 */
	public function set_ExceptionType($value)
	{
		$this->exceptionType=$value;
	}
	
	
	/**
	 * Set the statusCode
	 *
	 * @access public
	 * @param mixed $value
	 */
	public function set_StatusCode($value)
	{
		$this->statusCode=$value;
	}
	
	// Gettrer
	
	/**
	* Get the Message	
	* @access public
	* @param string $message
	*/
	public function get_Message()
	{
		return $this->message;
	}
	
	
	/**
	* Get the Alternate Text	
	* @access public
	* @param string $alternateText
	*/
	public function get_AlternateText()
	{
		return $this->alternateText;
	}
	
	
	/**
	* Get the Class Name
	* @access public
	* @param string $className
	*/
	public function get_ClassName()
	{
		return $this->className;
	}
	
	
	/**
	* Get the StackTrace 
	* @access public
	* @param string $stackTrace
	*/
	public function get_StackTrace()
	{
		return $this->stackTrace;
	}
	
	
	/**
	* Get the ExceptionType 
	* @access public
	* @param string $exceptionType
	*/
	public function get_ExceptionType()
	{
		return $this->exceptionType;
	}
	
	
	/**
	 * Get the statusCode
	 *
	 * @access public
	 * @param string $statusCode
	 */
	public function get_StatusCode()
	{		
		return $this->statusCode;
	}

}

?>