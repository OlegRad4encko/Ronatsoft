<?php
    class Database {
        private $link;

        public function __construct() {
            $this->connect();
        }


        private function connect() {
            try {
                $config = require_once "config.php";
                $dbh = 'mysql:host='.$config['host'].
                    ';port='.$config['port'].';dbname='.$config['database'].
                    ';charset='.$config['charset'];

                $this->link = new PDO($dbh, $config['username'], $config['password']);
            } catch(Exception $e) {
                echo '<center><h1>Error connecting to database</h1></center>';
            }
        }


        public function execute($sql) {
            $sth = $this->link->prepare($sql);
            return $sth->execute();
        }

        public function query($sql, $params = null) {
            if(!empty($params) && !is_array($params)) {
                throw new Exception("Must be array or NULL.");
            }

            if(empty($params)) {
                $params = [];
            }

            $exe = $this->link->prepare($sql);
            $exe->execute($params);
            $result = $exe->fetchAll(PDO::FETCH_ASSOC);

            if($result === false) {
                return ['error' => 'Request error!'];
            }

            return $result;
        }
    }
 ?>
