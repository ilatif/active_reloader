<?php

	class Active_Reloader {

		var $directories;

		public function __construct() {
			$this->base_path           = dirname(__FILE__);
			$this->last_reload_time    = isset($_GET['last_reload_time']) ? $_GET['last_reload_time'] : 0;
			$this->exclude_directories = isset($_GET['exclude_directories']) ? $this->_prepare_array($_GET['exclude_directories']) : array();
		}

		public function inform_about_reloading() {
			$reloading_status = $this->_check_for_reloading($this->base_path);
			$this->_inform_about_reloading($reloading_status);
		}

		private function _check_for_reloading($path) {
			$items = scandir($path);
			foreach($items as $item) {
				$item_path = "$path/$item";
				if (is_file($item_path)) {
					if ($this->last_reload_time > 0) {
						$filemtime = filemtime($item_path);
						if ($filemtime >= $this->last_reload_time) {
							$this->_inform_about_reloading(1);
						}
					}
				} else if (is_dir($item_path)) {
					if ($item[0] != "." && in_array($item_path, $this->exclude_directories) === FALSE) {
						$this->_check_for_reloading($item_path);
					}
				}
			}
			return 0;
		}

		private function _inform_about_reloading($reloading_status) {
			header("Content-Type: application/json");
			echo json_encode(array("reloading_status" => $reloading_status, "last_reload_time" => time()));
			exit;
		}

		private function _prepare_array($str) {
			$arr = array();
			$exploded_items = explode(",", $str);
			foreach($exploded_items as $item) {
				$item  = trim($item);
				$arr[] = $this->base_path . "/$item";
			}
			return $arr;
		}

	}
	$active_reloader = new Active_Reloader();
	$active_reloader->inform_about_reloading();
	