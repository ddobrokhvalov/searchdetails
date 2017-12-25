<?
require_once "params.php";
require_once "spares_parts.model.php";
class sparesPartsController{
	private $model;
	
	public $translit = array(
		' ' => '_', 'Ё' => 'YO', 'ё' => 'yo', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
		'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
		'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'KH', 'Ц' => 'TS', 'Ч' => 'CH',
		'Ш' => 'SH', 'Щ' => 'SHCH', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'U', 'Я' => 'YA', 'а' => 'a',
		'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y',
		'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
		'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ъ' => '', 'ы' => 'y',
		'ь' => '', 'э' => 'e', 'ю' => 'u', 'я' => 'ya', '№' => 'N' );
	
	public function __construct() {
		$this->model = new sparesPartsModel();
	}
	
	public function Search($query = "", $sku = ""){
		$res = $this->model->getList($query, $sku, $page_num);
		return json_encode($res);
	}
	
	public function get_unique_file_name( $path, $name )
	{
		$point_index = strrpos( $name, '.' );
		$base = ( $point_index !== false ) ? substr( $name, 0, $point_index ) : $name;
		$ext = ( $point_index !== false ) ? substr( $name, $point_index, strlen( $name ) ) : '';
		
		$new_name = $name; $n = 0;
		while ( file_exists( $path . '/' . $new_name ) )
			$new_name = $base . '_' . ( ++$n ) . $ext;
		return $new_name;
	}
	
	public function get_translit_file_name( $name )
	{
		return preg_replace( '/[^a-z0-9_\.\[\]-]/i', '', strtr( $name, $this->translit ) );
	}
	
	public function loadCsvFile($file_arr, $select_act){
		$new_file_name = $this->get_unique_file_name(params::$params["upload_dir"]["value"], $file_arr["name"]);
		$new_file_name = $this->get_translit_file_name($new_file_name);
		move_uploaded_file($file_arr["tmp_name"], params::$params["upload_dir"]["value"]."/".$new_file_name);
		$file_content = $this->checkCsvFile($new_file_name);
		if($file_content){
			$list = $this->model->getAll();
			$list = $this->array_reindex($list, "sku");
			
			foreach($file_content as $row){
				if(isset($list[$row[3]])){
					$this->model->update($list[$row[3]]["id"], $row);
					unset($list[$row[3]]);
				}else{
					$this->model->insert($row);
				}
			}
			foreach($list as $item){
				if($select_act == "delete"){
					$this->model->delete($item["id"]);
				}
				if($select_act == "deactivate"){
					$this->model->deactivate($item["id"]);
				}
			}
		}else{
			
		}
	}
	
	public function checkCsvFile($file_name){
		$handle = fopen(params::$params["upload_dir"]["value"]."/".$file_name, "r");
		
		$checked = true;
		$file_content = array();
		while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
			$data["1"] = iconv("WINDOWS-1251", "UTF-8", $data["1"]);
			
			if(count($data) < 5 || count($data) > 6){
				$checked = false;
			}else{
				$file_content[] = $data;
			}
		}
		
		fclose($handle);
		unlink(params::$params["upload_dir"]["value"]."/".$file_name);
		if($checked){
			return $file_content;
		}else{
			return false;
		}
	}
	
	public function array_reindex($array, $key1="", $key2="", $key3="", $key4=""){
		$reverted_array=array();
		if(is_array($array)){
			foreach($array as $item){
				if(!$key1){ 
					$reverted_array[$item]=$item;
				}elseif(!$key2){ 
					$reverted_array[$item[$key1]]=$item;
				}elseif(!$key3){ 
					$reverted_array[$item[$key1]][$item[$key2]]=$item;
				}elseif(!$key4){ 
					$reverted_array[$item[$key1]][$item[$key2]][$item[$key3]]=$item;
				}
				else{ 
					$reverted_array[$item[$key1]][$item[$key2]][$item[$key3]][$item[$key4]]=$item;
				}
			}
		}
		return $reverted_array;
	}
	
}