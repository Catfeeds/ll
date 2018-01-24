<?php
include(ROOT_PATH . 'config/config.php');
class cls_memcache
{
	function get_mem($cache_id) {
		$mem = new Memcache();
		$mem->connect(MEMCACHE_HOST, MEMCACHE_PORT);
		$result = array();
		$value = $mem->get($cache_id, MEMCACHE_FLAG);
		if($value == false) {
			return false;
		} else {
			return $value;
		}
	}
	
	function set_mem($cache_id, $value) {
		$mem = new Memcache();
		$mem->connect(MEMCACHE_HOST, MEMCACHE_PORT);
		$mem->set($cache_id, $value, MEMCACHE_FLAG, MEMCACHE_EXPIRE);
	}
}