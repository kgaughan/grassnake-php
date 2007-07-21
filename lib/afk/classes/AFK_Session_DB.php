<?php
/**
 * A port to AFK of the new, cleaner session handler I wrote for Tempus Wiki.
 *
 * To create the appropriate, you'll need to run something like the following:
 * 
 * CREATE TABLE sessions (
 *     id   CHAR(32) NOT NULL,
 *     name CHAR(16) NOT NULL,
 *     ts   INTEGER  NOT NULL,
 *     data TEXT     NOT NULL,
 * 
 *     PRIMARY KEY (id),
 *     INDEX ix_timestamp (ts)
 * );
 *
 * I'm pretty sure the table schema and the class itself should work on just
 * about every RDBMS out there.
 *
 * You will need an implementation of DB_Base to get this to work.
 */
class AFK_Session_DB extends AFK_Session {

	private $dbh;
	private $name;
	private $table;

	public function __construct(DB_Base $dbh, $table='sessions') {
		parent::__construct();
		$this->dbh = $dbh;
		$this->table = $table;
	}

	public function open($save_path, $name) {
		$this->name = $name;
		return true;
	}

	public function read($id) {
		$data = $this->dbh->query_value("
			SELECT	data
			FROM	{$this->table}
			WHERE	name = %s AND id = %s", $this->name, $id);
		return is_null($data) ? '' : $data;
	}

	public function write($id, $data) {
		$n = $this->dbh->query_value("
			SELECT	COUNT(*)
			FROM	{$this->table}
			WHERE	name = %s AND id = %s", $this->name, $id);
		if ($n == 0) {
			$query = "INSERT INTO {$this->table} (data, ts, name, id) VALUES (%s, %d, %s, %s)";
		} else {
			$query = "UPDATE {$this->table} SET data = %s, ts = %d WHERE name = %s AND id = %s";
		}
		$this->dbh->execute($query, $data, time(), $this->name, $id);
		return true;
	}

	public function destroy($id) {
		$this->dbh->execute("
			DELETE
			FROM	{$this->table}
			WHERE	name = %s AND id = %s", $this->name, $id);
		return true;
	}

	public function gc($max_age) {
		$this->dbh->execute("
			DELETE
			FROM	{$this->table}
			WHERE	ts < %d", time() - $max_age);
		return true;
	}
}
?>
