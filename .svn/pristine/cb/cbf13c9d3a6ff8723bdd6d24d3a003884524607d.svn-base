<?php
class ecs_log
{
	/**
	 *
	 */
	function debug($str)
	{
		$this->doDebug($str, "0");
	}

	/**
	 *
	 * Enter description here ...
	 * @param unknown_type $str
	 */
	function info($str)
	{
		$this->doDebug($str, "1");
	}

	/**
	 *
	 * Enter description here ...
	 * @param unknown_type $str
	 */
	function warn($str)
	{
		$this->doDebug($str, "2");
	}

	/**
	 *
	 * Enter description here ...
	 * @param unknown_type $str
	 */
	function error($str)
	{
		$this->doDebug($str, "3");
	}

	/**
	 *
	 * Enter description here ...
	 * @param unknown_type $str
	 * @param unknown_type $dm
	 */
	function doDebug($str, $dm)
	{
		if(0 <= $dm)
		{
			$this->doFileDebug($this->get_client_ip() . '_' . $str, $this->getLogLevel($dm));
		}
	}

	function getLogLevel($level) {
		switch($level) {
			case 0:
				return '[DEBUG]';
			case 1:
				return '[ INFO]';
			case 2:
				return '[ WARN]';
			case 3:
				return '[ERROR]';
			default:
				return '[FATAL]';
		}
	}

	/**
	 *
	 * Enter description here ...
	 * @param unknown_type $str
	 * @param unknown_type $dlevel
	 */
	function doFileDebug($str, $dlevel)
	{
		$file = LOG_DIR.'service-'.date("Ymd").".log.txt";
		file_put_contents($file, date("H:i:s ").$dlevel." ".$str."\r\n", FILE_APPEND);
	}

	/**
	 *
	 * Enter description here ...
	 * @return Ambigous <string, unknown>
	 */
	function get_client_ip()
	{
		if ($_SERVER['REMOTE_ADDR']) {
			$cip = $_SERVER['REMOTE_ADDR'];
		} elseif (getenv("REMOTE_ADDR")) {
			$cip = getenv("REMOTE_ADDR");
		} elseif (getenv("HTTP_CLIENT_IP")) {
			$cip = getenv("HTTP_CLIENT_IP");
		} else {
			$cip = "unknown";
		}
		return $cip;
	}
}
