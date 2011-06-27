<?php

class duan extends VanillaModel {
	var $hasOne = array('loaiduan' => 'loaiduan','account' => 'account','data' => 'data','image' => 'image');
}