<?php

class ImageController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);
		
		$this->_action = $action;
		$this->_template =& new Template($controller,$action);

	}
	function checkLogin($isAjax=false) {
		if(!isset($_SESSION['account'])) {
			if($isAjax == true) {
				die("ERROR_NOTLOGIN");
			} else {
				redirect(BASE_PATH.'/account/login');
				die();
			}
		}
	}
	function checkAdmin($isAjax=false) {
		if($isAjax==false)
			$_SESSION['redirect_url'] = getUrl();
		if(!isset($_SESSION['account']) || $_SESSION["account"]["role"]>1) {
			if($isAjax == true) {
				die("ERROR_NOTLOGIN");
			} else {
				redirect(BASE_PATH.'/admin/login&reason=admin');
				die();
			}
		}
	}
	function beforeAction () {

	}
	function setModel($model) {
		 $this->$model =& new $model;
	}
	function index() {		
		$_SESSION['redirect_url'] = getUrl();
        $this->_template->renderPage();	
	}
	function showimage($ipageindex = 1,$image_key = null) {
		$strWhere = '';
		if(isset($image_key) && $image_key!='' ) {
			$image_key = mysql_real_escape_string($image_key);
			$image_key = strtolower(remove_accents($image_key));
			$strWhere.=" and filename like '%$image_key%'";
		}
		$this->setModel("image");
		$this->image->where($strWhere);
		$this->image->orderBy('id','desc');
		$this->image->setPage($ipageindex);
		$this->image->setLimit(PAGINATE_LIMIT);
		$lstImage = $this->image->search();
		$totalPages = $this->image->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		$this->set("lstImage",$lstImage);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();	
	}
	function upload() {
		try {
			$image_id = null;
			//Get upload attach image_id
			global $cache;
			$ma=time();
			if($_FILES['fileupload']['name']==NULL)
				die('ERROR_SYSTEM');
			$str=$_FILES['fileupload']['tmp_name'];
			$size= $_FILES['fileupload']['size'];
			if($size==0) {
				die('ERROR_FILESIZE');
			} else {
				$dir = ROOT . DS . 'public'. DS . 'upload' . DS . 'images' . DS;
				$filename = preg_replace("/[&' +-]/","_",$_FILES['fileupload']['name']);				
				move_uploaded_file($_FILES['fileupload']['tmp_name'],$dir . $filename);
				//die($filename);
				$sFileType='';
				$i = strlen($filename)-1;
				while($i>=0) {
					if($filename[$i]=='.')
						break;
					$sFileType=$filename[$i].$sFileType;
					$i--;
				}
				$str=$dir . $filename;
				$fname=$ma.'_'.$filename;
				$arrType = $cache->get('fileTypes');
				if(!in_array(strtolower($sFileType),$arrType)) {
					unlink($str);
					die('ERROR_WRONGFORMAT');
				}
				else {
					$str2= $dir . $fname;
					rename($str,$str2);
					$this->setModel('image');
					$this->image->id = null;
					$this->image->filename = $filename;
					$this->image->fileurl = BASE_PATH.'/upload/images/'.$fname;
					$this->image->status = 1;
					$image_id = $this->image->insert(true);
				}
			}
			$value = "{'id':'".$image_id."','url':'".BASE_PATH.'/upload/images/'.$fname."'}";
			print($value);
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function afterAction() {

	}

}