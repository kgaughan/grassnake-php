<?php
/**
 * A null cache. Doesn't actually cache anything but instead always responds
 * that the item wasn't found.
 *
 * This cache is useful as a default one for use in development environments.
 *
 * Please note that if you're exercising something which uses caching, it
 * ought to be tested using both AFK_Cache_Array and AFK_Cache_Null as both
 * implement different elements of the AFK_Cache interface contract that code
 * using caches ought to expect.
 */
class AFK_Cache_Null implements AFK_Cache {

	public function invalidate($id) {
		// Do nothing.
	}

	public function invalidate_all($max_age=0) {
		// Do nothing.
	}

	public function load($id, $max_age=300) {
		// Do nothing.
		return null;
	}

	public function save($id, $item) {
		// Do nothing.
    }
}
?>
