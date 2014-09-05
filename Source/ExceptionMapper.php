<?php

/**
* Copyright 2014 AFour Technologies
*
* Licensed under the Apache License, Version 2.0 (the "License");
* you may not use this file except in compliance with the License.
* You may obtain a copy of the License at
*
*   http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
* See the License for the specific language governing permissions and
* limitations under the License.
*/


include 'ExceptionInfo.php';
// Set the xml parser flag here as true
libxml_use_internal_errors(true);

/**
 * @access Global
 * @var string
 */
global $arrayObject;

// We set the xmlFilePath globaly in this '$GLOBALS['xmlFilePath']' Veriable
/**
 *  Special global veriable declaration DocBlock
 * @global String  $GLOBALS['xmlFilePath']
 * @name  xmlFilePath
 */ 
$GLOBALS['xmlFilePath']=null;


/**
 * @global array $GLOBALS['tempArrayObj']
 * @name tempArrayObj
 */
$GLOBALS['tempArrayObj'] =new ArrayObject();

/**
 * @global array  $GLOBALS['statusCodeDictionary']
 * @name statusCodeDictionary
 */
$GLOBALS['statusCodeDictionary']=array();


/**
 * @global  integer  $GLOBALS['statusCodeDictionaryFinder']
 * @name  statusCodeDictionaryFinder
 */
$GLOBALS['statusCodeDictionaryFinder']=100;


 /**
 * CatchXml  class is used to set information to object of this class.
 *
 * @author AFour Technologies
 * @version 1.0.0.0
 * @package AFourTech.ExceptionMapper
 */
// Create catchXML class to store the exception info in object
class catchXML
{
	// Veriable for getter setter
	/**
	 * @access private
	 * @var string
	 */
	var $exceptionTag=null;
	
	/**
	 * @access private
	 * @var string
	 */
	var $exceptionAttribute=null;
	
	/**
	 * @access private
	 * @var string
	 */
	var $message=null;
	
	/**
	 * @access private
	 * @var string
	 */
	var $alternateText=null;
	

	// Getter Setter for the $exceptionTag
	/**
	 * Sets the exceptionTag
	 *
	 * @param string $value The exception Tag name.
	 */
	public function set_exceptionTag($value)
	{
		$this->exceptionTag=$value;
	}
	/**
	 * Get the exceptionTag name
	 */
	public function get_exceptionTag()
	{
		return $this->exceptionTag;
	}



	// Getter Setter for the exceptionAttribute
	/**
	 * Sets the exceptionAttribute
	 *
	 * @param string $value The exceptionAttribute  name.
	 */
	public function set_exceptionAttribute($value)
	{
		$this->exceptionAttribute=$value;
	}
	/**
	 * Get the exceptionAttribute name
	 */
	public function get_exceptionAttribute()
	{
		return $this->exceptionAttribute;
	}


	// Getter Setter for the message
	/**
	 * Sets the message
	 *
	 * @param string $value The message  name.
	 */
	public function set_message($value)
	{
		$this->message=$value;
	}
	/**
	 * Get the message name
	 */
	public function get_message()
	{
		return $this->message;
	}


	// Getter Setter for the alternateText
	/**
	 * Sets the alternateText
	 *
	 * @param string $value The alternateText  name.
	 */
	public function set_alternateText($value)
	{
		$this->alternateText=$value;
	}
	
	/**
	 * Get the alternateText name
	 */
	public function get_alternateText()
	{
		return $this->alternateText;
	}
	

}


// Class to find StepCondition type 
/**
 * StepCondition is a Class in Mapper class that initialise StepCondition i.e GIVEN,WHEN
 *
 */
final class StepCondition
{
	const GIVEN = "GIVEN";
	const WHEN = "WHEN";	
}

 


/**
 * class Mapper to read and show exception information
 *
 * @author AFour Technologies
 * @version 0.0.0.9
 * @package AFourTech.ExceptionMapper
 */
class Mapper 
{ 	
	// beginning of docblock template area
    /**
     * @access private
     * @var string 
     */
	var $exceptionType=null;
	
    /**
     * @access private
     * @var string 
     */
	var $alternateText=null;
	
    /**
     * @access private
     * @var string 
     */
	var $message;
	
    /**
     * @access private
     * @var string 
     */
	var $stackTrace;
	
    /**
     * @access private
     * @var string 
     */
	var $className;
	
  
	
	/**
	 * initializeErrorCodeDict() is a method in Mapper class that initialise statusCodeDictionary
	 *	
	 */
	public static  function initializeErrorCodeDict()
	{
	   $GLOBALS['statusCodeDictionary']=array(100=>"Successfully run.",101=>"An Error has occurred in our library please contact AFourTech for further Information on debugging this error.",102=>"File Could not find at specified location",103=>"Syntax Error in file. Please follow Proper Syntax");	  		
	}

	
	/**
	 * Method to cache xml file to Hashtable  in array of object	 	 
	 *	
	 */
	public static  function cacheXMLDocument()
	{	
		
		static ::initializeErrorCodeDict();						
		
		if($GLOBALS['xmlFilePath']==null)
		{			
			//Get the XML file path from current Directory
			$tempPath= getcwd()."\\"."ExceptionMapping.xml";
		}		
		else
		{		
			//Get the XML file path from User define path
			$tempPath=$GLOBALS['xmlFilePath'];			
		}
		
		
		if(!file_exists($tempPath))
	    {	    	
	    	$GLOBALS['statusCodeDictionaryFinder']=102;
	    	
		}
		else 
		{	
			// Here we load the XML File
			$xml=simpleXml_load_file($tempPath);
			// If XML not formatted properly
			if ($xml === false)
			{	
				$GLOBALS['statusCodeDictionaryFinder']=102;
				foreach(libxml_get_errors() as $error)
				{
					$GLOBALS['statusCodeDictionaryFinder']=103;
					echo "\t", $error->message."=";
				}
			}
			
			else
			{				
				// Create an array object to store current object
				$arrayObject = new ArrayObject();
				try
				{	
					foreach($xml->children() as $child)
					{
						$parentNode=$child->attributes();
						foreach($child as $subTag)
						{
							$objCatchXml=new catchXML();
							if($subTag->attributes()!=null)
							{
								$alternateText=$subTag->attributes();
								$objCatchXml->set_alternateText($alternateText);
							}
							$exceptionMessage=$subTag;
							// set values to the $objCatchXml
							$objCatchXml->set_message($exceptionMessage);
							$objCatchXml->set_exceptionTag($child->getName());
							$objCatchXml->set_exceptionAttribute($parentNode);
								
							// Append current object to Array of object
							$arrayObject->append($objCatchXml);
								
						}
						//  "Other"  If no any message pass in xml file
						if($child->getName()=="OtherException")
						{
							$GLOBALS['defaultExceptionTypeGlobal']=$child->attributes();
						}
			
					}
						
				}
				catch (FileNotFoundException $k)
				{
					$GLOBALS['statusCodeDictionaryFinder']=102;
				}
				catch(Exception $e)
				{
					$GLOBALS['statusCodeDictionaryFinder']=103;
				}
			
				// set the reference of current object to the global object
				$GLOBALS['tempArrayObj']=$arrayObject;
					
			}
		}
			
	} 
	
	
		
	/**
	 * GetExceptionInfo() is a method in Mapper class ths shows how to call the method GetExceptionInfo()
	 *
	 * $s=Mapper::GetExceptionInfo($e,"given");	 
	 * $s=Mapper::GetExceptionInfo($e,"when");
	 * $s=Mapper::GetExceptionInfo($e,"then");	 
	 * 
	 * @param Exception $exception , This is an exception
	 * @param string $stepString stepstring can be anyone out of 'given','when','then'
     * @return ExceptionInfo class object
	 */
	public static function GetExceptionInfo(Exception $exception, $stepString=NULL)
	{	
	
		/**
		 * @access Local
		 * @var String
		 */
		$alternateText=null;

		/**
		 * @access Local
		 * @var String
		 */
		$exceptionType=null;
		
		$WhenGivenConditionChecker=0;
		

		// Create object  ExceptionInfo class to access the methods
		$objExceptionInfo=new ExceptionInfo();
		$objExceptionInfo->set_AlternateText("null");

		static $check=0;
		if($check==0)
		{
			// Check array of object is null 
			if($GLOBALS['tempArrayObj']!=null)		
			{
			  $check=1;
			  static ::cacheXMLDocument();
			}	
		}	
		
		if($stepString!=null)
		{	
			if((StepCondition::GIVEN)==(string)strtoupper($stepString) ||((string)StepCondition::WHEN)==(string)strtoupper($stepString))
			{			
				$exceptionType = "Environmental";	
				$WhenGivenConditionChecker=1;
				$objExceptionInfo->set_ExceptionType($exceptionType);
			}
		}

		try
		{	 		
			    //Traverse (HashTable) Global Array to get Exception Data present in xml file.
			     $iterator = $GLOBALS['tempArrayObj']->getIterator();	
			   
			   		    while ($iterator->valid())
						 {
						 	    $currentMessage=$iterator->current()->get_message();						 	   
						 	 	if(($exception->getMessage()==$currentMessage)||($exception->getMessage()==$currentMessage && $exceptionType=="Environmental"))
							 	{
							 		$exceptionType=$iterator->current()->get_exceptionAttribute();
									// If Exception type is Functional and step string is provided then set alternateText=null
									if($exceptionType=="Functional" && $WhenGivenConditionChecker==1)
									{
										$alternateText="";
									}
									else
									{
										$alternateText=$iterator->current()->get_alternateText();
									}								
								    break;
							 	}
								$iterator->next();							
						}			   	
				
						
			    if($exceptionType==null)
			    {			    	
			    	$objExceptionInfo->set_ExceptionType($GLOBALS['defaultExceptionTypeGlobal']);			    		    	
			    }
			    if($alternateText==null)
			    {
			    	$alternateText="";
			    }
			    if($objExceptionInfo->get_ExceptionType()==null)
			    {
			    	$objExceptionInfo->set_ExceptionType($exceptionType);			    	
			    }
			 
		}
		
		catch(Exception $e)
		{
			$GLOBALS['statusCodeDictionaryFinder'] = 101;
		}		 
		
		$objExceptionInfo->set_AlternateText($alternateText);
		$objExceptionInfo->set_Message((string)$exception->getMessage());
		$objExceptionInfo->set_ClassName((string)get_class($exception));
		$objExceptionInfo->set_StackTrace($exception->getTraceAsString());
		
		$objExceptionInfo->set_StatusCode($GLOBALS['statusCodeDictionary'][$GLOBALS['statusCodeDictionaryFinder']]);
		
		
		//  Write a code create a log files and store them in StackLog Folder
		date_default_timezone_set('Asia/Kolkata');
		$md = microtime();
		$da = explode(" ",$md);
		$date = date("Y-m-d h-i-s",$da[1]);
		$DateTime=$date."-".round($da[0]*100);
		
		
		$folderName="StackLog";
		$parentDirName=getcwd();
		$subDirectoryName=$parentDirName."\\".$folderName;
		if(!file_exists($subDirectoryName))
		{
			mkdir($subDirectoryName);
		}
		$logFile=$subDirectoryName."\\StackTrace".$DateTime.".log";
		
		if($logFile)
		{
			$fp = fopen($logFile,"wb");
			if($fp)
			{
				fwrite($fp,$exception->getTraceAsString());
				fclose($fp);
			}
		}
	
		return $objExceptionInfo;
	}

}




?>