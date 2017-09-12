<?php
defined('IN_PHPCMS') or exit('No permission resources.');
if(!defined('CACHE_MODEL_PATH')) define('CACHE_MODEL_PATH',PHPCMS_PATH.'caches'.DIRECTORY_SEPARATOR.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);

pc_base::load_sys_class('model', '', 0);

/**
 * Class product_model
 * @property model
 */
class dict_model extends model {
	public function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'dict';
		parent::__construct();
	}


}
?>