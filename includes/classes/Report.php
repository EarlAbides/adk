<?php
	
	class Report{
		
		public $csv;
		
		public function __construct(){
			
		}


		private static function wrapQuotes($str){
			return '"'.$str.'"';
		}

		public function getCorrsReport($ADK_CORRESPONDENTS){
			$this->csv = "Name,Username,Email,Member Since,# Hikers\r\n";
			foreach($ADK_CORRESPONDENTS->correspondents as $ADK_CORRESPONDENT){
				$row = [self::wrapQuotes($ADK_CORRESPONDENT->name), self::wrapQuotes($ADK_CORRESPONDENT->username), self::wrapQuotes($ADK_CORRESPONDENT->email)
							, (date('Y', strtotime($ADK_CORRESPONDENT->datetime)) === '1969'? '': date('m/d/Y', strtotime($ADK_CORRESPONDENT->datetime)))
							, $ADK_CORRESPONDENT->numhikers];
				$this->csv .= implode(',', $row)."\r\n";
			}
		}

		public function getHikersReport($ADK_HIKERS){
			$this->csv = "Name,Username,Email,Staff Correspondent,Hiker Since,Last Active,# Peaks\r\n";
			foreach($ADK_HIKERS->hikers as $ADK_HIKER){
				$row = [self::wrapQuotes($ADK_HIKER->name), self::wrapQuotes($ADK_HIKER->username), self::wrapQuotes($ADK_HIKER->email)
							, self::wrapQuotes($ADK_HIKER->corrname), (date('Y', strtotime($ADK_HIKER->datetime)) === '1969'? '': date('m/d/Y', strtotime($ADK_HIKER->datetime)))
							, $ADK_HIKER->lastactive, $ADK_HIKER->numpeaks];
				$this->csv .= implode(',', $row)."\r\n";
			}
		}

		public function getHikerReport($ADK_HIKER, $ADK_HIKERS_PEAKS){
			$this->csv = "Name,Username,Email,Staff Correspondent,Hiker Since,# Peaks,# Peaks (Total)\r\n";
			$row = [self::wrapQuotes($ADK_HIKER->name), self::wrapQuotes($ADK_HIKER->username), self::wrapQuotes($ADK_HIKER->email)
			            , self::wrapQuotes($ADK_HIKER->corrname), (date('Y', strtotime($ADK_HIKER->datetime)) === '1969'? '': date('m/d/Y', strtotime($ADK_HIKER->datetime)))
			            , $ADK_HIKER->numpeaks, $ADK_HIKER->numclimbed];
			$this->csv .= implode(',', $row)."\r\n";
			
			$this->csv .= "\r\n\r\nName,Date\r\n";
			foreach($ADK_HIKERS_PEAKS->hikerspeaks as $ADK_HIKERS_PEAK){
				$row = [$ADK_HIKERS_PEAK->peakname, $ADK_HIKERS_PEAK->datetime];
				$this->csv .= implode(',', $row)."\r\n";
			}
		}
		
	}
	
?>