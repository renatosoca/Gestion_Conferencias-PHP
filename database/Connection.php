<?php

class Connection {
    private $instanceDB = null;

    protected $db_name;
    protected $db_user;
    protected $db_pass;
    protected $db_host;

    public function __construct() {
        $this->db_name = $_ENV['DB_NAME'];
        $this->db_user = $_ENV['DB_USER'];
        $this->db_pass = $_ENV['DB_PASS'];
        $this->db_host = $_ENV['DB_HOST'];

        try {
            $this->instanceDB = mysqli_connect( $this->db_host, $this->db_user, $this->db_pass, $this->db_name );

            echo 'connectado';
        } catch (\Throwable $th) {
            echo 'error conection db';
            $this->instanceDB = null;
        }
    }
    public function connect() {
        return $this->instanceDB;
    }
}
