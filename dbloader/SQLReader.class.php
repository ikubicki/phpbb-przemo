<?php
include_once 'read_dump.lib.php';

define('SQL_READER_PMA', 1);
define('SQL_READER_FAST', 2);

class SQLReader
{
	/**
	 * @var Algorytm czytania zapytañ
	 */
	var $method;

	/**
	 * @var Obiekt typu FileReader
	 */
	var $fr;

	/**
	 * @var Bufor pliku (dla algorytmu PMA)
	 */
	var $pma_buffer;

	/**
	 * @var Wielko¶æ bufora PMA
	 */
	var $pma_maxqsize;

	function SQLReader(&$reader, $method = SQL_READER_FAST, $pma_maxqsize = 524288)
	{
		$this->fr = &$reader;
		$this->set_method($method);
		$this->pma_maxqsize = $pma_maxqsize;
	}

	function set_method($method)
	{
if( $method == SQL_READER_PMA && $this->fr->mime() == 'application/x-bzip' ) echo ' Uwaga - plik bz2 i wolny algorytm! Skrypt mo¿e siê zapêtliæ!!! Nobla za rozwi±zanie tego problemu... ';
		$this->method = $method;
	}

	function get_method($method)
	{
		return $this->method;
	}

	function get_query()
	{
		switch ( $this->method )
		{
			case SQL_READER_PMA:
				$ret = $this->_pmaquery();
				break;
			case SQL_READER_FAST:
				$ret = $this->_fastquery();
				break;
		}
		return $ret;
	}

	function _fastquery()
	{
		$query_data['pos'] = $this->fr->tell();
		$query = '';
		$buff = '';
		$in_query = false;
		$is_full_query = false;
		while( !$this->fr->eof() )
		{
			$line = $this->fr->gets();
			if( !$in_query )
			{
				$buff = substr(ltrim($line), 0, 3);
				if( $buff{0} == '#' || $buff == '-- ' || $buff == '' )
				{
					continue;
				}
				else
				{
					$in_query = true;
				}
			}
			$query .= $line;
			$buff = substr($line, -3);
			if( strpos($buff, ';') !== false )
			{
				$query = trim($query);
				$query = substr($query, 0, -1);
				$is_full_query = true;
				break;
			}
		}
		if( $is_full_query )
		{
			$query_data['query'] = $query;
			return $query_data;
		}
		else
		{
			return false;
		}
	}

	function _pmaquery()
	{
		$query_data['pos'] = $this->fr->tell();
		$this->pma_buffer = $this->fr->read($this->pma_maxqsize);
		$start_len = strlen($this->pma_buffer);
		$piece = array();
		$this_pma_buffer = $this->pma_buffer;
		PMA_splitSqlFile($piece, $this_pma_buffer, 1);
		$pos_offset = $start_len - strlen($this->pma_buffer);
		if( $pos_offset != 0 )
		{
			$this->fr->seek($query_data['pos'] + $pos_offset);
		}
		else
		{
			// odczyt nie usun±³ nic z bufora, przesuñ na koniec pliku
			$this->fr->seek($this->fr->realsize());
		}
		if( isset($piece[0]) && is_array($piece[0]) && !$piece[0]['empty'] )
		{
			$lines = explode("\n", $piece[0]['query']);
			$query_data['query'] = '';
			$in_comment = false;
			$lines_count = count($lines);
			for( $i=0; $i < $lines_count; $i++ )
			{
				$lines[$i] = trim($lines[$i]);
				$test = substr($lines[$i], 0, 3);
				if( $test{0} == '#' || $test == '-- ' )
				{
					continue;
				}
				if( $test == '/*' )
				{
					$in_comment = true;
					continue;
				}
				if( $in_comment )
				{
					$test = substr($lines[$i], -2);
					if( $test == '*/' )
					{
						$in_comment = false;
						continue;
					}
				}
				if( !$in_comment )
				{
					$query_data['query'] .= $lines[$i] . "\n";
				}
			}
			$query_data['query'] = trim($query_data['query']);
			if( $query_data['query'] )
			{
				return $query_data;
			}
		}
		return false;
	}
}

?>