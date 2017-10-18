<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {

	/**
	 * Constructor
	 *
	 * @access public
	 */
	function __construct()
	{
		log_message('debug', "Model Class Initialized");
	}

	/**
	 * __get
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string
	 * @access private
	 */
	function __get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}
        
        function delete($tableName,$where) {
            $this->db->delete($tableName, $where);
        }
        
        function getListData($limit=10, $offset = 0, $where=array(),$condition='like',$order='id,ASC') {
            $this->db->select("*");
            $this->db->from($this->_table);
        
            if ($order != '') {
                $order = explode(',',$order);
                if(sizeof($order) > 1) {
                    $this->db->order_by($order[0],$order[1]);
                } else if(sizeof($order) == 1){
                    $this->db->order_by('id',$order[0]);
                }
                 
            }
            if ($limit > 0) {
                $this->db->limit($limit, $offset);
            }
            if ($where && sizeof($where) > 0) {
                foreach($where as $key => $value) {
                    if ($value == '') {
                        $this->db->$condition($key);
                    } else {
                        $this->db->$condition($key, $value,'after');
                    }
                }
            }
            
            $query = $this->db->get()->result_array();
//            echo $this->db->last_query();exit;
            return $query;
        }
}
// END Model Class

/* End of file Model.php */
/* Location: ./system/core/Model.php */