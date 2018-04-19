<?php

class HandleDB {
  private $db;

  function __construct($logs) {
    $this->logs = $logs;
    $this->connect_database();
  }

  public function get_instance() {
    return $this->db;
  }

  function connect_database() {
    try {
    	$this->db = new PDO($this->logs->servername, $this->logs->username, $this->logs->password, $this->logs->options);
    } catch (PDOException $e) {
    	$this->db = null;
    }
  }
}
?>
