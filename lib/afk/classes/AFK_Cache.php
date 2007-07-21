<?php
/**
 * Implement this interface to add extra caching mechanisms for use with
 * AFK.
 */
interface AFK_Cache {

	/**
	 * Invalidates the given item, removing it from the cache.
	 *
	 * @param  $id  Id of the cached item.
	 */
	function invalidate($id);

	/**
	 * Invalidates the whole cache.
	 */
	function invalidate_all($max_age=0);

	/**
	 * Load the item with the given key.
	 *
	 * @param  $id       ID of the cached item.
	 * @param  $max_age  Seconds to cache the item for. Defaults to 5 minutes.
	 * @return A reference to the cached item, or null if none found.
	 */
	function load($id, $max_age=300);

	/**
	 * Saves the given item to the cache.
	 * 
	 * @param  $id    ID of the cached item.
	 * @param  $item  The item to be cached.
	 */
	function save($id, $item);
}
?>
