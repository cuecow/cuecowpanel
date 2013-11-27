<!--Trying to read or reverse engineer the API source code is violation of license.--> <?php 

class GoogleAlert 
{  

	private $V7694f4a6, $Ve358efa4, $V8fa14cdd, $V9e3669d1; 

	private $Va14351b0 = false; 

	private $V0c83f57c, $V7e612d4d, $V03c7c0ac, $V937a7113;   

	public function __toString() 
	{  
		$Vb4a88417 = "Query=" . $this->V7694f4a6. ",Type=" . $this->Ve358efa4. ",Frequency=" . $this->V8fa14cdd. ",Volume=" . $this->V9e3669d1; 
		
		if ($this->Va14351b0) 
		{  
			$Vb4a88417 .= ",FeedURL=" . $this->V7e612d4d; 
		} 
		else 
		{ 
			$Vb4a88417 .= ",Email=" . $this->V0c83f57c; 
		} 
		
		if ($this->V03c7c0ac!= null) 
		{ 
			$Vb4a88417 .= ",ID=" . $this->V03c7c0ac; 
		}   
		
		return $Vb4a88417; 
	}   
	
	public function __construct($V1b1cc7f0, $V599dcce2, $Vfad6c43b, $V210ab9e7, $Vaa639856, $V0c83f57c) 
	{  
		$this->V7694f4a6= $V1b1cc7f0; 
		$this->Ve358efa4= $V599dcce2; 
		$this->V8fa14cdd= $Vfad6c43b; 
		$this->V9e3669d1= $V210ab9e7; 
		$this->Va14351b0= $Vaa639856; 
		$this->V0c83f57c= $V0c83f57c; 
	}  
	
	public function getQuery() 
	{  
		return $this->V7694f4a6; 
	}  
	
	public function getType() 
	{  
		return $this->Ve358efa4; 
	}  
	
	public function getFrequency() 
	{  
		return $this->V8fa14cdd; 
	}  
	
	public function getVolume() 
	{  
		return $this->V9e3669d1; 
	}  
	
	public function isFeedDelivery() 
	{  
		return $this->Va14351b0; 
	}  
	
	public function getEmail() 
	{  
		return $this->V0c83f57c; 
	}   
	
	public function getID() 
	{  
		return $this->V03c7c0ac; 
	}   
	
	public function setID($Vb718adec) 
	{  
		$this->V03c7c0ac= $Vb718adec; 
	}   
	
	public function getFeedURL() 
	{  
		return $this->V7e612d4d; 
	}   
	
	public function setFeedURL($V572d4e42) 
	{  
		$this->V7e612d4d= $V572d4e42; 
	}   
	
	public function getGoogleReaderURL() 
	{  
		return $this->V937a7113; 
	}   
	
	public function setGoogleReaderURL($V572d4e42) 
	{  
		$this->V937a7113= $V572d4e42; 
	} 
} 
?> 