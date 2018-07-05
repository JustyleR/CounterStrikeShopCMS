<?php
/*
RCon Class
	Author: elvago9 <gabrieel09@gmail.com>
*/ 
class RCon
{
	public $host, $port, $pass;
	private $fp, $challenge_number;
	public function __construct($host, $pass){
		$_host = explode(":", $host);
		$this->host = $_host[0];
		$this->port = $_host[1];
		$this->pass = $pass;
	}
	public function Connect(){
		$this->fp = fsockopen("udp://".$this->host, $this->port);
		return $this->fp ? $this->GetChallengeNumber() : false;
	}
	public function Disconnect(){
		return fclose($this->fp) ? true : false;
	}
	public function Command($command){
		return $this->RconCommand("\xff\xff\xff\xffrcon $this->challenge_number \"$this->pass\" $command");
	}
	private function GetChallengeNumber(){
		$this->challenge_number = trim($this->RconCommand("\xff\xff\xff\xffchallenge rcon"));
		if(!empty($this->challenge_number)){
			$_challenge = explode(" ", $this->challenge_number);
			$this->challenge_number = $_challenge["2"];
			return $this->challenge_number;
		}else return false;
	}
	private function RconCommand($command){
		fputs($this->fp, $command, strlen($command));
		$buffer =  fread($this->fp, 1);
		$status = socket_get_status($this->fp);
		$buffer .= fread($this->fp, $status["unread_bytes"]);
		return $buffer;
	}
}