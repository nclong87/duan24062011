<?php

class DuanController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);		
		$this->_action = $action;
		$model = 'duan';
		$this->$model =& new $model;
		$this->_template =& new Template($controller,$action);
	}
	function beforeAction () {
		performAction('webmaster', 'updateStatistics');
	}
	function checkAdmin($isAjax=false) {
		if($isAjax==false)
			$_SESSION['redirect_url'] = getUrl();
		if(!isset($_SESSION['duan']) || $_SESSION['duan']['role']>1) {
			if($isAjax == true) {
				die('ERROR_NOTLOGIN');
			} else {
				redirect(BASE_PATH.'/admin/login&reason=admin');
				die();
			}
		}
	}
	function checkEmployee($isAjax=false) {
		if($isAjax==false)
			$_SESSION['redirect_url'] = getUrl();
		if(!isset($_SESSION['duan']) || $_SESSION['duan']['role']>2) {
			if($isAjax == true) {
				die('ERROR_NOTEMPLOYEE');
			} else {
				error('Vui lòng đăng nhập tài khoản nhân viên!');
			}
		}
	}
	function checkLogin($isAjax=false) {
		if(!isset($_SESSION['duan'])) {
			if($isAjax == true) {
				die('ERROR_NOTLOGIN');
			} else {
				redirect(BASE_PATH.'/duan/login');
				die();
			}
		}
	}
	function checkActive($isAjax=false,$msg='Vui lòng kiểm tra email để xác nhận tài khoản!') {
		if($_SESSION['duan']['active']==0) {
			if($isAjax == true) {
				die('ERROR_NOTACTIVE');
			} else {
				error($msg);
			}
		}
	}
	function setModel($model) {
		 $this->$model =& new $model;
	}
	//Functions of Administrator
	function getDuanById($id=null) {	
		$this->checkAdmin(true);
		if($id != null && $id != 0) {
			$this->duan->id=$id;
            return $this->duan->search();
		}
		return null;
	}
    function listDuans($ipageindex) {
		$this->checkAdmin();
		$cond_keyword = isset($_GET['cond_keyword'])?$_GET['cond_keyword']:null;
		$strWhere = '';
		$arrJoin = array('account','loaiduan');
		if(isset($cond_keyword) && $cond_keyword!='' ) {
			$cond_keyword = mysql_real_escape_string($cond_keyword);
			$cond_keyword = strtolower(remove_accents($cond_keyword));
			$strWhere.=" and data like '%$cond_keyword%'";
			array_push($arrJoin,'data');
		}
		
		$this->duan->showHasOne($arrJoin);
		$this->duan->where($strWhere);
		$this->duan->orderBy('duan.id','desc');
		$this->duan->setPage($ipageindex);
		$this->duan->setLimit(PAGINATE_LIMIT);
		$lstDuan = $this->duan->search('duan.id,tenduan,username,datepost,dateupdate,tenloaiduan,backuped');
		$totalPages = $this->duan->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstDuan);die();
		$this->set('lstDuan',$lstDuan);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	function saveDuan() {
		$this->checkAdmin(true);
		$id = $_POST['duan_id'];
		$tenduan = $_POST['duan_tenduan'];
		$alias = $_POST['duan_alias'];
		$image_id = $_POST['duan_image'];
		$thongtinchitiet = $_POST['duan_thongtinchitiet'];
		$vitri = $_POST['duan_vitri'];
		$loaiduan_id = $_POST['duan_loaiduan'];
		$validate = new Validate();
		if($validate->check_null(array($id,$tenduan,$alias,$thongtinchitiet,$loaiduan_id))==false)
			die('ERROR_SYSTEM');
		if($validate->check_length($tenduan,255))
			die('ERROR_SYSTEM');
		$this->data->id = $id;
		$duan = $this->data->search('data_id');
		if(empty($duan))
			die('ERROR_NOTEXIST');
		$data_id = $duan['duan']['duan_id'];
		$this->setModel('data');
		$sIndex = "$id $tenduan $vitri ".strip_tags($thongtinchitiet);
		$this->data->id = $data_id;
		$this->data->data = $sIndex;
		$this->data->update();
		$this->setModel('duan');
		$this->duan->id = $id;
		$this->duan->tenduan = $tenduan;
		$this->duan->alias = $alias;
		$this->duan->image_id = $image_id;
		$this->duan->thongtinchitiet = $thongtinchitiet;
		$this->duan->vitri = $vitri;
		$this->duan->loaiduan_id = $loaiduan_id;
		$this->duan->dateupdate = GetDateSQL();
		$this->duan->save();		
		echo 'DONE';
	}  
	function delete() {
		$this->checkAdmin(true);
		$id = $_GET['duan_id'];
		if(isset($id)) {
			$this->duan->id = $id;
			$data = $this->duan->search('id');
			if(empty($data))
				die('ERROR_SYSTEM');
			$this->duan->id = $id;
			$this->duan->delete();
			echo 'DONE';
		} else {
			echo 'ERROR_SYSTEM';
		}
	}
	function deleteNDuans() {
		$this->checkAdmin(true);
		if(isset($_POST["duan_id"])) {
			$lstDuans = $_POST["duan_id"];
			foreach($lstDuans as $duan_id) {
				$this->duan->id = $duan_id;
				$this->duan->delete();
			}
			echo 'DONE';
		} else {
			echo 'ERROR_SYSTEM';
		}
	}
	function doActive($id=null,$active=null) {
		$this->checkAdmin(true);
		if(!isset($id) || !isset($active))
			die('ERROR_SYSTEM');
		$this->duan->id = $id;
		$this->duan->backuped = $active;
		$this->duan->save();
		echo 'DONE';
	}
	function index() {
		$this->_template->render();
	}
	function afterAction() {

	}

}