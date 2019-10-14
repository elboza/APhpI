<?php
namespace APhPI;
class APhpI{
	private $routes = array();
	function __construct() {
		$this->method=$_SERVER['REQUEST_METHOD'];
		$this->request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
		$this->request_path = $_SERVER['PATH_INFO'];
		//$this->input = json_decode(file_get_contents('php://input'),true);
		$this->input = file_get_contents('php://input');
		$this->get_params=$_GET;
		$this->headers=getallheaders();
	}

	public function test(){
		$method = $this->method;
		$request = $this->request;
		$request2 = $this->request_path;
		$input = $this->input;
		echo "test...";
		var_dump($method);
		var_dump($request);
		var_dump($request2);
		var_dump($input);
	}

	public function add_route($method, $path, $function) {
		$fn=array(
			'method'=>$method,
			'path'=>$path,
			'fn'=>$function
		);
		array_push($this->routes,$fn);
	}

	private function same_path($request_path_arr, $item) {
		$item_path=explode('/', trim($item['path'],'/'));
		if(count($item_path) != count($request_path_arr)) return NULL;
		$params=array();
		for($n=0;$n<count($item_path); $n++){
			if($item_path[$n][0]==':') {
				$v=$request_path_arr[$n];
				$k=ltrim($item_path[$n], ':');
				$params[$k]=$v;
				continue;
			}
			if($item_path[$n] !== $request_path_arr[$n]) return NULL;
		}
		return $params;
	}

	public function run(){
		foreach($this->routes as $item){
			if(strcasecmp($this->method, $item['method'])==0){
				$params=$this->same_path($this->request, $item);
				if(!is_null($params)){
					$event=array(
						'headers'=>$this->headers,
						'get_params'=>$this->get_params,
						'url_params'=>$params,
						'body'=>$this->input,
						'method'=>$this->method,
						'request_path'=>$this->request_path
					);
					//exec fn(event)
					$response=$item['fn']($event);
					//send response...

					if(isset($response['statusCode']))http_response_code($response['statusCode']);
					if(isset($response['headers'])){
						foreach($response['headers'] as $k=>$v){
							header("${k}: ${v}");
						}
					}
					if(isset($response['body'])) echo $response['body'];

					//break;
					return;
				}
			}
		}
		//send not found...
		echo "404 not found";
	}
}
