<?php
/*
* @file mysqli.php
* @date 2/07/2013
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

if(!defined('IN_PHPBB')){ exit; }

if(!defined("SQL_LAYER")) {
    define("SQL_LAYER", "mysqli");

    class sql_db
    {
        var $db_connect_id;
        var $query_result;
        var $num_queries = 0;
        var $in_transaction = 0;

        // Connect to server
        function sql_db($sqlserver, $sqluser, $sqlpassword, $database, $persistency = true)
        {
            $this->persistency = (version_compare(PHP_VERSION, '5.3.0', '>=')) ? $persistency : false;
            $this->user        = $sqluser;
            $this->password    = $sqlpassword;
            $this->dbname      = $database;

            // If persistent connection, set dbhost to localhost when empty and prepend it with 'p:' prefix
            $this->server = ($this->persistency) ? 'p:' . (($sqlserver) ? $sqlserver : 'localhost') : $sqlserver;

            // connect
            $this->db_connect_id = @mysqli_connect($this->server, $this->user, $this->password, $this->dbname);

            if($this->db_connect_id && $this->dbname != '') {
                mysqli_set_charset($this->db_connect_id, 'latin2');
                return $this->db_connect_id;
            }

            return false;
        }

        // SQL Transaction
        function sql_transaction($status = 'begin')
        {
            switch($status) {
                case 'begin':
                    return @mysqli_autocommit($this->db_connect_id, false);
                    break;

                case 'commit':
                    $result = @mysqli_commit($this->db_connect_id);
                    @mysqli_autocommit($this->db_connect_id, true);
                    return $result;
                    break;

                case 'rollback':
                    $result = @mysqli_rollback($this->db_connect_id);
                    @mysqli_autocommit($this->db_connect_id, true);
                    return $result;
                    break;
            }
            return true;
        }

        // Base query method
        function sql_query($query = "", $transaction = FALSE)
        {
            global $show_queries;
            if($show_queries) global $queries;

            // Remove any pre-existing queries
            unset($this->query_result);

            if($query != "") {
                if($show_queries) {
                    $queries .= $query . '<hr>';
                }
                $this->num_queries++;
                if($transaction == BEGIN_TRANSACTION && !$this->in_transaction) {
                    if(!$this->sql_transaction('begin')) {
                        return false;
                    }
                    $this->in_transaction = TRUE;
                }

                $this->query_result = @mysqli_query($this->db_connect_id, $query);
            } else {
                if($transaction == END_TRANSACTION && $this->in_transaction) {
                    $this->sql_transaction('commit');
                }
            }

            if($this->query_result) {
                if($transaction == END_TRANSACTION && $this->in_transaction) {
                    $this->in_transaction = FALSE;

                    if(!$this->sql_transaction('commit')) {
                        $this->sql_transaction('rollback');
                        return false;
                    }
                }

                return $this->query_result;
            } else {
                if($this->in_transaction) {
                    $this->sql_transaction('rollback');
                    $this->in_transaction = FALSE;
                }
                return false;
            }
        }

        // Fetch current row
        function sql_fetchrow($query_id = 0)
        {
            if(!$query_id) {
                $query_id = $this->query_result;
            }

            return ($query_id) ? @mysqli_fetch_array($query_id, MYSQL_ASSOC) : false;
        }

        // Free sql result
        function sql_freeresult($query_id = 0)
        {
            if(!$query_id) {
                $query_id = $this->query_result;
            }

            return ($query_id) ? @mysqli_free_result($query_id) : false;
        }

        // Other query methods
        function sql_numrows($query_id = 0)
        {
            if(!$query_id) {
                $query_id = $this->query_result;
            }

            return ($query_id) ? @mysqli_num_rows($query_id) : false;
        }


        // Return number of affected rows
        function sql_affectedrows()
        {
            return ($this->db_connect_id) ? @mysqli_affected_rows($this->db_connect_id) : false;
        }

        // numfields
        function sql_numfields($query_id = 0)
        {
            if(!$query_id) {
                $query_id = $this->query_result;
            }

            return ($query_id) ? @mysqli_field_count($this->db_connect_id) : false;
        }

        // fieldname
        function sql_fieldname($offset, $query_id = 0)
        {
            if(!$query_id) {
                $query_id = $this->query_result;
            }

            if($query_id) {
                $finfo = @mysqli_fetch_field_direct($query_id, $offset);
                return $finfo->name;
            } else {
                return false;
            }
        }

        // fieldtype
        function sql_fieldtype($offset, $query_id = 0)
        {
            if(!$query_id) {
                $query_id = $this->query_result;
            }

            if($query_id) {
                $finfo = @mysqli_fetch_field_direct($query_id, $offset);
                return $finfo->type;
            } else {
                return false;
            }
        }

        // fetchrowset
        function sql_fetchrowset($query_id = 0)
        {
            if(!$query_id) {
                $query_id = $this->query_result;
            }

            if($query_id) {
                $result = array();
                while($fetchrowset = @mysqli_fetch_array($query_id, MYSQL_ASSOC)) {
                    $result[] = $fetchrowset;
                }
                return $result;
            } else {
                return false;
            }
        }

        // Seek to given row number
        function sql_rowseek($rownum, $query_id = 0)
        {
            if(!$query_id) {
                $query_id = $this->query_result;
            }

            return ($query_id) ? @mysqli_data_seek($query_id, $rownum) : false;
        }

        // Get last inserted id after insert statement
        function sql_nextid()
        {
            return ($this->db_connect_id) ? @mysqli_insert_id($this->db_connect_id) : false;
        }

        // Escape string used in sql query
        function sql_escape($s)
        {
            return @mysqli_real_escape_string($this->db_connect_id, $s);
        }

        // Pings a server connection
        function sql_ping()
        {
            return ($this->db_connect_id) ? @mysqli_ping($this->db_connect_id) : false;
        }

        // return sql error
        function sql_error($c = false)
        {
            if(!$c) {
                $result['message'] = @mysqli_error($this->db_connect_id);
                $result['code']    = @mysqli_errno($this->db_connect_id);
            } else {
                $result['message'] = @mysqli_connect_error();
                $result['code']    = @mysqli_connect_errno();
            }
            return $result;
        }

        // Close sql connection
        function sql_close()
        {
            if($this->db_connect_id) {
                // Commit any remaining transactions
                if($this->in_transaction) {
                    $this->sql_transaction('commit');
                }

                return @mysqli_close($this->db_connect_id);
            } else {
                return false;
            }

        }

    }
}
?>