<?php
class FileReader
{
	/**
	 * @var Nazwa pliku
	 */
	var $f_name = '';

	/**
	 * @var Typ mime pliku (gzip, bzip2, tekstowy)
	 */
	var $f_mime = '';

	/**
	 * @var Uchwyt otwartego pliku
	 */
	var $handle = null;

	/**
	 * @var Aktualna pozycja w pliku
	 */
	var $offset = 0;

	/** Rozmiar wczytanego pliku
	 * @var
	 */
	var $file_size = 0;

	/**
	 * @var Rozmiar wczytanego pliku (zdekompresowanego)
	 */
	var $real_file_size = 0;

	function FileReader($fname, $real_size = 0)
	{
		$real_size = intval($real_size);
		$this->f_name = $fname;
		$this->f_mime = $this->_get_mime($fname);
		switch ( $this->f_mime )
		{
			case 'application/x-gzip':
				$this->handle = @gzopen($fname, 'rb');
				break;
			case 'application/x-bzip':
				$this->handle = bzopen($fname, 'rb');
				break;
			default:
				$this->handle = @fopen($fname, 'rb');
		}
		$this->offset = 0;
		$this->file_size = @filesize($fname);
		$this->real_file_size = ($real_size > 0) ? $real_size : $this->_size();
	}

	function close()
	{
		switch ( $this->f_mime )
		{
			case 'application/x-gzip':
				@gzclose($this->handle);
				break;
			case 'application/x-bzip':
				@bzclose($this->handle);
				break;
			default:
				@fclose($this->handle);
		}
	}

	function mime()
	{
		return $this->f_mime;
	}

	function size()
	{
		return $this->file_size;
	}

	function realsize()
	{
		return $this->real_file_size;
	}

	function gets()
	{
		$ret = '';
		switch ( $this->f_mime )
		{
			case 'application/x-gzip':
				while( !@gzeof($this->handle) )
				{
					$buffer = @gzgets($this->handle);
					$ret .= $buffer;
					$buffer = substr($buffer, -3);
					if( strpos($buffer, "\n") !== false )
					{
						break;
					}
				}
				$this->offset = @gztell($this->handle);
				break;
			case 'application/x-bzip':
				$line_len = 0;
				$char = '';
				while( !$this->eof() && $char != "\n" )
				{
					$char = bzread($this->handle, 1);
					$ret .= $char;
					$this->offset++;
				}
				break;
			default:
				while( !feof($this->handle) )
				{
					$buffer = @fgets($this->handle);
					$ret .= $buffer;
					$buffer = substr($buffer, -3);
					if( strpos($buffer, "\n") !== false )
					{
						break;
					}
				}
				$this->offset = @ftell($this->handle);
		}
		return $ret;
	}

	function tell()
	{
		return $this->offset;
	}

	function seek($offset)
	{
		if( $this->offset == $offset )
		{
			return 0;
		}
		switch ( $this->f_mime )
		{
			case 'application/x-gzip':
				$ret = @gzseek($this->handle, $offset);
				break;
			case 'application/x-bzip':
				bzclose($this->handle);
				$this->handle = bzopen($this->f_name, 'rb');
				bzread($this->handle, $offset);
				$ret = 0;
				break;
			default:
				$ret = @fseek($this->handle, $offset);
		}
		$this->offset = $offset;
		return $ret;
	}

	function eof()
	{
		return ($this->offset >= $this->real_file_size);
	}

	function read($length)
	{
		switch ( $this->f_mime )
		{
			case 'application/x-gzip':
				$content = @gzread($this->handle, $length);
				$this->offset = @gztell($this->handle);
				break;
			case 'application/x-bzip':
				$content = bzread($this->handle, $length);
				$this->offset += strlen($content);
				break;
			default:
				$content = @fread($this->handle, $length);
				$this->offset = @ftell($this->handle);
		}
		return $content;
	}

	// Zwraca typ mime pliku (application/x-gzip, application/x-bzip,
	//  application/zip, text/plain)
	function _get_mime($fname)
	{
		if( $fname == $this->f_name && $this->f_mime != '' )
		{
			return $this->f_mime;
		}
		$file = @fopen($fname, 'rb');
		$test = @fread($file, 3);
		@fclose($file);
		if ( $test[0] == chr(31) && $test[1] == chr(139) )
		{
			return 'application/x-gzip';
		}
		elseif( $test == 'BZh' )
		{
			return 'application/x-bzip';
		}
		elseif( substr($test, 0, 2) == 'PK' )
		{
			return 'application/zip';
		}
		else
		{
			return 'text/plain';
		}
	}

	function _size()
	{
		switch ( $this->f_mime )
		{
			case 'application/x-gzip': // gz
				$lastpos = @gztell($this->handle);
				@gzrewind($this->handle);
				while( !gzeof($this->handle) )
				{
					@gzread($this->handle, 102400);
				}
				$size = @gztell($this->handle);
				@gzseek($this->handle, $lastpos);
				break;
			case 'application/x-bzip': // bz2
				$fh = bzopen($this->f_name, 'rb');
				$size = 0;
				while( true )
				{
					$s = bzread($fh, 102400);
					if( $s )
					{
						$len = strlen($s);
						$size += $len;
					}
					else
					{
						bzclose($fh);
						break;
					}
				}
				break;
			default:
				$size = @filesize($this->f_name);
		}
		return $size; 
	}
}
?>