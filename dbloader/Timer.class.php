<?php
class Timer
{
	var $start_time;
	var $_elapsed;
	var $paused;

	function Timer($autostart = true)
	{
		$this->start_time = 0;
		$this->_elapsed = 0;
		$this->paused = !$autostart;
		if( $autostart )
		{
			$this->start();
		}
	}

	function start()
	{
		$this->start_time = $this->_get_mtime();
		$this->paused = false;
	}

	function stop()
	{
		$this->_update();
		$this->paused = true;
	}

	function reset()
	{
		$this->_update();
		$this->_elapsed = 0;
	}

	function elapsed($mtime = false)
	{
		$this->_update();
		if( $mtime )
		{
			return $this->_elapsed;
		}
		else
		{
			return round($this->_elapsed, 4);
		}
	}

	function _get_mtime()
	{
		$mtime = microtime();
		$mtime = explode(' ',$mtime);
		return $mtime[1] + $mtime[0];	
	}

	function _update()
	{
		if( $this->paused )
		{
			return;
		}
		$mtime = $this->_get_mtime();
		$this->_elapsed = $this->_elapsed + ($mtime - $this->start_time);
		$this->start_time = $mtime;
	}
}
?>