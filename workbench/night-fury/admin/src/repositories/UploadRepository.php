<?php

class UploadRepository extends Exception{
	public function __construct($message = 'error',$code = 0){
		parent::__construct($message);
	}
	public function UploadImage($file,$accept_array = null,$dir = null){
		$accept_array == null ? $accept_array = ['jpg','jpeg','png','gif'] : '';
		$dir == null ? $dir = STR_DIR_UPLOAD_DEAL_IMAGE : '';
		try {
			$file_name = $file->getClientOriginalName();
			$file_type = $file->getClientOriginalExtension();
			$file_type = strtolower($file_type);
			if(!in_array($file_type,$accept_array))
				throw new Exception(STR_ERROR_FILE_TYPE, 1);
			else
				$file_name = $dir.time().'-'.preg_replace('/[^a-zA-Z0-9-_\.]/s','', $file_name);
				$file->move($dir,$file_name);
				return $file_name;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());			
		}
	}
}
?>