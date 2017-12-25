<?
require_once "safemysql.class.php";
class sparesPartsModel{
	
	private $db;
	
	public function __construct() {
		$opts = array(
					'host'		=> params::$params["db_server"]["value"],
					'user'    	=> params::$params["db_user"]["value"],
					'pass'    	=> params::$params["db_password"]["value"],
					'db'      	=> params::$params["db_name"]["value"],
					'port' 		=> params::$params["db_port"]["value"]
					);
		$this->db = new SafeMySQL($opts);
				
	}
	
	public function getList($query = "", $sku = ""){
		if(!trim($query) && !trim($sku)){
			return array("items"=>array(), "count"=>0);
		}
		
		$w = array();
		$where = '';
		if(trim($query) && !trim($sku)){
			$where = $this->db->parse("where ru_name like ?s", "%$query%"); 
		}
		if(!trim($query) && trim($sku)){
			
			$where = $this->db->parse("where sku = ?s", "$sku"); 
		}
		if(trim($query) && trim($sku)){
			$where = $this->db->parse("where ru_name like ?s and sku = ?s", "%$query%", $sku); 
		}
		$where .= " and active = 1";
		//return $where;
		$sql_query = "select * from ?p ?p";
		$items = $this->db->getAll($sql_query, params::$params["table_name"]["value"], $where);
		
		$res["items"] = $items;
		$res["count"] = count($items);
		return $res;
	}
	
	
	public function getAll(){
		$sql_query = "select * from ?p";
		$items = $this->db->getAll($sql_query, params::$params["table_name"]["value"]);
		return $items;
	}
	
	public function insert($data){
		$data = array('manufacture' => $data[0], 'ru_name' => $data[1], 'quantity' => $data[2], 'sku' => $data[3], 'price' => $data[4], 'active' => '1');
		$sql  = "insert into ?p set ?u";
		$this->db->query($sql, params::$params["table_name"]["value"], $data);
	}
	public function update($id, $data){
		$data = array('manufacture' => $data[0], 'ru_name' => $data[1], 'quantity' => $data[2], 'sku' => $data[3], 'price' => $data[4], 'active' => '1', 'timestamp'=>date("Y-m-d H:i:s"));
		$sql  = "update ?p set ?u where id = ?i";
		$this->db->query($sql, params::$params["table_name"]["value"], $data, $id);
	}
	public function delete($id){
		$sql  = "delete from ?p where id = ?i";
		$this->db->query($sql, params::$params["table_name"]["value"], $id);
	}
	public function deactivate($id){
		$sql  = "update ?p set active=0 where id = ?i";
		$this->db->query($sql, params::$params["table_name"]["value"], $id);
	}
	
	
}