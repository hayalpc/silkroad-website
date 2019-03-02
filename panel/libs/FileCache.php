<?php
//define("DIR_CACHE",__DIR__."/resourse/cache/");

class FileCache {
	private $expire;
	public static $connection = null;

	public function __construct($expire = 3600) {
		$this->expire = $expire;
	}

    public function checkTime() {
        $files = glob(DIR_CACHE . 'cache.*');
        if ($files) {
            foreach ($files as $file) {
                $time = substr(strrchr($file, '.'), 1);
                if ($time < time()) {
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            }
        }
	}

	public function get($key) {
        $files = glob(DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');
		if ($files) {
			$handle = fopen($files[0], 'r');
			flock($handle, LOCK_SH);
			$data = fread($handle, filesize($files[0]));
			flock($handle, LOCK_UN);
			fclose($handle);
			return json_decode($data, true);
		}
		return false;
	}

	public function add($key, $value,$time = null) {
	    $this->delete($key);
		$file = DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.' . (time() + ($time?:$this->expire));
		$handle = fopen($file, 'w');
		flock($handle, LOCK_EX);
		fwrite($handle, json_encode($value));
		fflush($handle);
		flock($handle, LOCK_UN);
		fclose($handle);
	}

	public function delete($key) {
		$files = glob(DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');
		if ($files) {
			foreach ($files as $file) {
				if (file_exists($file)) {
					unlink($file);
				}
			}
		}
	}

    public function getList($key = "",$withTime = false) {
        $files = glob(DIR_CACHE . 'cache.*' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '*',GLOB_BRACE);
        if ($files) {
            if(!$withTime){
                $list = [];
                foreach(array_map("basename", $files) as $item) {
                    $a = explode(".", $item);
                    $time = end($a);
                    unset($a[count($a) - 1]);
                    unset($a[0]);
                    $list[] = implode("", $a);
                }
                return $list;
            }else{
                $list = array_map("basename", $files);
                return $list;
            }
        }
        return false;
	}

    /**
     * @return FileCache
     */
    public static function getConnection()
    {
        if(self::$connection == null){
            self::$connection = new self();
        }
        return self::$connection;
	}
}