<?php
class Mysql{
	private $host	='127.0.0.1';
	private $user	='root';
	private $pwd	='Hijack';
	private $database	='compaluser';
	private $charset	='utf-8';
	private $link;
	private $rows;
	static $_instance;
	private static $mydb;
	private function __construct($pconnect = false){
		self::$mydb=new mysqli($this->host,$this->user,$this->pwd,$this->database);
		if (self::$mydb->connect_error){
			$this->err();
		}
	}
	private function __clone(){

	}
	public static function getInstance($pconnect = false){
		if (false==(self::$_instance instanceof self)){
			self::$_instance=new self($pconnect);
		}
		return self::$_instance;
	}
	//select
	public function select($sql,$link =''){
		$this->result = self::$mydb->query($sql,$this->link) or $this->err($sql);
		return $this->result;
	}
	public function carrySql($sql){
		self::$mydb->query($sql);
		$nums=self::$mydb->affected_rows;
		return $nums;
	}
	//single
	public function getRow($sql,$type=MYSQLI_ASSOC){

		$result=self::$mydb->query($sql);
		return @mysqli_fetch_array($result);
	}
	//rows
	public function getRows($sql,$type=MYSQLI_ASSOC){
		$result=self::$mydb->query($sql);
		$this->rows = [];//这里必须置空，不然单利模式下每次循环都调用同一个db对象，前面循环出来的值会追加到后面的循环里
		while (($row = @mysqli_fetch_array($result,$type)) !== false&&$row>0){
			$this->rows[]=$row;
		}
		//mysqli_close(self::$mydb);
		//mysqli_free_result($result);
		return $this->rows;

	}
	public function opencommit(){
		self::$mydb->autocommit(false);
	}
	public function surecommit(){
		self::$mydb->commit();
	}
	public function backcommit(){
		self::$mydb->rollback();
	}
	public function closeMysql($res){
		//$res->free();
		self::$mydb->close();
	}
	protected function err($sql=null){
		echo 'error';
		exit();
	}
}
?>