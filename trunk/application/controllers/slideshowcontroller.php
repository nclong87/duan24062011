<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admincontroller
 *
 * @author nclong
 */
class SlideshowController extends VanillaController {
	function __construct($controller, $action) {
		global $inflect;

		$this->_controller = ucfirst($controller);
		$this->_action = $action;
		$model = "slideshow";
		$this->$model =& new $model;
		$this->_template =& new Template($controller,$action);

	}
	function checkLogin($isAjax=false) {
		if($isAjax==false)
			$_SESSION['redirect_url'] = getUrl();
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
		performAction('webmaster', 'updateStatistics');
	}
    function setModel($model) {
		 $this->$model =& new $model;
	} 
	function afterAction() {

	}
	function listSlideshows($ajax) {
		$this->checkAdmin(true);
		$this->slideshow->showHasOne(array('image'));
		$this->slideshow->orderBy('backuped,`prior`','ASC');
		$lstslideshows = $this->slideshow->search('slideshow.id,image.id,title,fileurl,filename,url,prior,backuped');
		$this->set("lstslideshows",$lstslideshows);
		$this->_template->renderPage();
	}
	function activeSlideshow($id=null) {
		$this->checkAdmin(true);
		if($id!=null) {
			$this->slideshow->id = $id;
			$this->slideshow->backuped = 0;
			$this->slideshow->save();
			//$this->cacheSlideshows();
			echo "DONE";
		}
	}
	function unActiveSlideshow($id=null) {
		$this->checkAdmin(true);
		if($id!=null) {
			$this->slideshow->id = $id;
			$this->slideshow->backuped = 1;
			$this->slideshow->save();
			//$this->cacheSlideshows();
			echo "DONE";
		}
	}
	function saveSlideshow() {
		$this->checkAdmin(true);
		$id = $_POST["slideshow_id"];
		$image_id = $_POST["slideshow_image"];
		$title = $_POST["slideshow_title"];
		$url = $_POST["slideshow_url"];
		$prior = $_POST["slideshow_prior"];
		if($id==null) { //insert
			$this->slideshow->id = null;
			$this->slideshow->title = $title;
			$this->slideshow->image_id = $image_id;
			$this->slideshow->url = $url;
			$this->slideshow->prior = $prior;
			$this->slideshow->backuped = 0;
		} else { //update
			$this->slideshow->id = $id;
			$this->slideshow->title = $title;
			$this->slideshow->image_id = $image_id;
			$this->slideshow->url = $url;
			$this->slideshow->prior = $prior;
		}
		$this->slideshow->save();
		echo "DONE";
	}
	function cacheSlideshows() {
		$this->checkAdmin(true);
		global $cache;
		$this->slideshow->where('AND backuped=0');
		$this->slideshow->orderBy('`order`','ASC');
		$data = $this->slideshow->search();
		$cache->set("slideshowList",$data);
	}
	function exist($id=null){
		$this->checkAdmin(true);
		if($id==null)
			die("ERROR_SYSTEM");
		$this->slideshow->id = $id;
		$slideshow = $this->slideshow->search();
		if(empty($slideshow)) {
			echo "0";
		} else {
			echo "1";
		}
	}
	function deleteSlideshow() {
		$this->checkAdmin(true);
		if(!isset($_GET["id"]))
			die("ERROR_SYSTEM");
		$id = $_GET["id"];
		$this->slideshow->id=$id;
		if($this->slideshow->delete()==-1) {
			echo "ERROR_SYSTEM";
		} else {
			$this->cacheSlideshows();
			echo "DONE";
		}
	}
	function __destruct()
	{

	}

}

