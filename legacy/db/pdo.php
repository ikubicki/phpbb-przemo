<?php


if (!defined('IN_PHPBB')) {
    exit();
}

if (!defined("SQL_LAYER")) {
    
    define("SQL_LAYER", "pdo");

    class sql_db
    {
        public $queries = [];
        public $num_queries = 0;
        
        protected $connection;
        protected $statement;
        protected $in_transaction = 0;

        // Connect to server
        function __construct(array $config = [])
        {
            $options = isset($config['options']) ? $config['options'] : [];
            $user = isset($config['user']) ? $config['user'] : 'root';
            $password = isset($config['pass']) ? $config['pass'] : '';
            $dsn = isset($config['dsn']) ? $config['dsn'] : 'mysql:host=localhost;dbname=phpbb';
            
            $options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            $this->connection = new PDO($dsn, $user, $password, $options);
        }
        
        public function isConnected()
        {
            return !empty($this->connection);
        }

        // SQL Transaction
        function sql_transaction($status = 'begin')
        {
            switch ($status) {
                case 'begin':
                    return $this->connection->beginTransaction();
                    break;
                
                case 'commit':
                    return $this->connection->commit();
                    break;
                
                case 'rollback':
                    return $this->connection->rollBack();
                    break;
            }
            return true;
        }
        
        // Base query method
        function sql_query($query = "", $transaction = FALSE)
        {
            global $show_queries;
            if ($show_queries)
                global $queries;
                
                // Remove any pre-existing queries
                unset($this->statement);
                
                if ($query != "") {
                    if ($show_queries) {
                        $queries .= $query . '<hr>';
                        $this->queries[] = $query;
                    }
                    $this->num_queries ++;
                    if ($transaction == BEGIN_TRANSACTION && !$this->in_transaction) {
                        if (! $this->sql_transaction('begin')) {
                            return false;
                        }
                        $this->in_transaction = TRUE;
                    }
                    
                    try {
                        $this->statement = $this->connection->query($query);
                    }
                    catch(\Throwable $throwable) {
                        $this->statement = false;
                    }
                } else {
                    if ($transaction == END_TRANSACTION && $this->in_transaction) {
                        $this->sql_transaction('commit');
                    }
                }
                
                if ($this->statement) {
                    if ($transaction == END_TRANSACTION && $this->in_transaction) {
                        $this->in_transaction = FALSE;
                        
                        if (!$this->sql_transaction('commit')) {
                            $this->sql_transaction('rollback');
                            return false;
                        }
                    }
                    
                    return $this->statement;
                } else {
                    if ($this->in_transaction) {
                        $this->sql_transaction('rollback');
                        $this->in_transaction = FALSE;
                    }
                    return false;
                }
        }

        // Base prepare method
        function sql_prepare($query)
        {
            global $show_queries;
            if ($show_queries)
                global $queries;
            
            // Remove any pre-existing queries
            unset($this->statement);
            
            if ($query) {
                if ($show_queries) {
                    $queries .= $query . '<hr>';
                    $this->queries[] = $query;
                }
                $this->num_queries ++;
                
                try {
                    $this->statement = $this->connection->prepare($query);
                }
                catch(\Throwable $throwable) {
                    $this->statement = false;
                }
            }
            return $this->statement;
        }
        
        function sql_execute(array $parameters = [], $statement = null)
        {
            if (!$statement) {
                $statement = $this->statement;
            }
            return ($statement) ? $statement->execute($parameters) : false;
        }

        // Fetch current row
        function sql_fetchrow($statement = null)
        {
            if (!$statement) {
                $statement = $this->statement;
            }
            
            return ($statement) ? $statement->fetch(PDO::FETCH_ASSOC) : false;
        }

        // Free sql result
        function sql_freeresult($statement = null)
        {
            if (!$statement) {
                $statement = $this->statement;
            }
            
            return ($statement) ? $statement->closeCursor() : false;
        }

        // Other query methods
        function sql_numrows($statement = null)
        {
            if (!$statement) {
                $statement = $this->statement;
            }
            
            return ($statement) ? $statement->rowcount() : false;
        }

        // Return number of affected rows
        function sql_affectedrows()
        {
            return ($this->statement) ? $this->statement->rowcount() : false;
        }

        // numfields
        function sql_numfields($statement = null)
        {
            if (!$statement) {
                $statement = $this->statement;
            }
            
            return ($statement) ? $statement->columnphp7_count() : false;
        }

        // fieldname
        function sql_fieldname($offset, $statement = null)
        {
            if (!$statement) {
                $statement = $this->statement;
            }
            if ($statement) {
                $columnMetaData = $statement->getColumnMeta($offset);
                return $columnMetaData ? $columnMetaData->name : false;
            } else {
                return false;
            }
        }

        // fieldtype
        function sql_fieldtype($offset, $statement = null)
        {
            if (!$statement) {
                $statement = $this->statement;
            }
            if ($statement) {
                $columnMetaData = $statement->getColumnMeta($offset);
                return $columnMetaData ? $columnMetaData->native_type : false;
            } else {
                return false;
            }
            
        }

        // fetchrowset
        function sql_fetchrowset($statement = null)
        {
            if (!$statement) {
                $statement = $this->statement;
            }
            
            if ($statement) {
                return $statement->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        }

        // Seek to given row number
        function sql_rowseek($rownum, $statement = 0)
        {
            throw new Exception('Unsupported method');
        }

        // Get last inserted id after insert statement
        function sql_nextid()
        {
            return ($this->connection) ? $this->connection->lastInsertId() : false;
        }

        // Escape string used in sql query
        function sql_escape($s)
        {
            throw new Exception('mysql_real_escape_string is not a php7 compatible function');
        }

        // Pings a server connection
        function sql_ping()
        {
            return ($this->connection) ? $this->connection->query('select 1')->fetchColumn(0) > 0 : false;
        }

        // return sql error
        function sql_error($c = false)
        {
            if ($this->connection) {
                $error = $this->connection->errorInfo();
                return [
                    'message' => $error[2],
                    'code' => $error[1],
                ];
            }
            return false;
        }

        // Close sql connection
        function sql_close()
        {
            if ($this->connection) {
                // Commit any remaining transactions
                if ($this->in_transaction) {
                    $this->sql_transaction('commit');
                }
                $this->connection = null; 
                return true;
            } else {
                return false;
            }
        }
    }
}
?>