<?php
/**
 * To create the appropriate, you'll need to run something like the following:
 * 
 * CREATE TABLE cache (
 *     id   CHAR(32) NOT NULL,
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
class AFK_Cache_DB implements AFK_Cache {

	private $dbh;
	private $table;

	public function __construct(DB_Base $dbh, $table='cache') {
		$this->dbh = $dbh;
		$this->table = $table;
	}

	public function invalidate($id) {
		$this->dbh->execute("DELETE FROM {$this->table} WHERE id = %s", md5($id));
	}

	public function invalidate_all($max_age=0) {
		$this->dbh->execute("DELETE FROM {$this->table} WHERE ts < %d", time() - $max_age);
	}

	public function load($id, $max_age=300) {
		$data = $this->dbh->query_value("
			SELECT	data
			FROM	{$this->table}
			WHERE	id = %s AND ts > %d", md5($id), time() - $max_age);

		if (!is_null($data)) {
			return unserialize($data);
		}
		return null;
	}

	public function save($id, $item) {
		$hash = md5($id);

		$item_exists = $this->dbh->query_value("
			SELECT	COUNT(*)
			FROM	{$this->table}
			WHERE	id = %s", $hash) != 0;

		if ($item_exists) {
			$query = "UPDATE {$this->table} SET data = %s, ts = %d WHERE id = %s";
		} else {
			$query = "INSERT INTO {$this->table} (data, ts, id) VALUES (%s, %d, %s)";
		}
		$this->dbh->execute($query, serialize($item), time(), $hash);
	}
}
?>
