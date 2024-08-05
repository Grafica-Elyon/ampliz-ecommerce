<?php 
namespace MisterPrint\Helper;

 class Log{  

 	public static function info($message){                          
		$res = self::createLog($message, "INFO");  
	}
	public static function debug($message){                          
		$res = self::createLog($message, "DEBUG");  
	}
	public static function error($message){                          
		$res = self::createLog($message, "ERROR");  
	}
	public static function notice($message){                          
		$res = self::createLog($message, "NOTICE");  
	}

	public static function createLog($message, $level){
		$data = date('d-m-Y_H:i:s');
		$log = "[{$data}] [PLUGIN_{$level}] {$message} \n";
		$short_date = "".date('d_m_Y');
		//cria arquivo com nome da data atual, grava e fecha ele  
		$nome = "log_{$short_date}_.log";    

		$arquivo = fopen(plugin_dir_path( __FILE__ )."../../".$nome, "a+");
		$res = fwrite($arquivo, $log);  
		fclose($arquivo); 
	}
}
