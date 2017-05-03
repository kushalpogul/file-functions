<?php
namespace FileFunctions\Controller\Component;

use Cake\Controller\Component;

class FileComponent extends Component
{
    protected static $instance;

    public function __construct()
    {
    }

    public static function getObject()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function createFile()
    {
        if (!$this->exists()) {
            file_put_contents($this->get(), '');
            return true;
        }
        return false;
    }

    public function copyFile($file, $newfile)
    {
        return copy($file, $newfile);
    }

    public function renameFile($file, $newfile)
    {
        return copy($file, $newfile);
    }

    public function isFileReadable()
    {
        if (is_readable($this->get())) {
            return true;
        } else {
            return false;
        }
    }

    public function isFileWritable()
    {
        if (is_writable($this->get())) {
            return true;
        } else {
            return false;
        }
    }

    public function changePermission($mode)
    {
        if ($this->exists()) {
            return chmod($this->get(), $mode);
        }
        return false;
    }

        
    public function set($file)
    {
        $file = preg_replace('#[\\\\/]+#', DIRECTORY_SEPARATOR, $file);
        $this->file = $file;
        return $this;
    }

    public function get()
    {
        if ($this->file) {
            return $this->file;
        }
        return null;
    }

    public function save($string)
    {
        if ($this->validateDirectory() && !empty($string)) {
            file_put_contents($this->get(), $string);
            return true;
        }
        return false;
    }
    
    public function append($string)
    {
        if ($this->validateDirectory() && !empty($string)) {
            file_put_contents($this->get(), $string, FILE_APPEND);
            return true;
        }
        return false;
    }

    public function prepend($string)
    {
        if ($this->validateDirectory() && !empty($string)) {
            $handle = fopen($this->get(), 'a+');
            fclose($handle);
            $handle = fopen($this->get(), 'r+');
            $len = strlen($string);
            $final_len = filesize($this->get()) + $len;
            $cache_old = fread($handle, $len);
            rewind($handle);
            $i = 1;
            while (ftell($handle) < $final_len) {
                fwrite($handle, $string);
                $string = $cache_old;
                $cache_old = fread($handle, $len);
                fseek($handle, $i * $len);
                $i++;
            }
            fclose($handle);
            return true;
        }
        return false;
    }

    public function exists()
    {
        $args = func_get_args();
        if (!$args) {
            return file_exists($this->get());
        } else {
            return file_exists($args[0]);
        }
    }

    public function validateDirectory()
    {
        $args = func_get_args();
        if (!$args) {
            $directory = dirname($this->get());
        } else {
            $directory = dirname($args[0]);
        }
        if (!is_dir($directory)) {
            if (file_exists($directory)) {
                return false;
            }
            $this->validateDirectory($directory);
            if (is_writable(dirname($directory))) {
                mkdir($directory);
            } else {
                return false;
            }
        }
        return true;
    }
    
    public function render()
    {
        if ($this->exists()) {
            return file_get_contents($this->get());
        }
        return false;
    }
    
    public function delete()
    {
        if ($this->exists()) {
            @unlink($this->get());
            return true;
        }
        return false;
    }
    
    public function modified()
    {

        //date_default_timezone_set("Asia/Kolkata");

        if ($this->exists()) {
            return date("F d Y H:i:s.", filemtime($this->get()));
        }
        return false;
    }
    
    public function getAge()
    {
        if (($mod = $this->modified())) {
            return $_SERVER["REQUEST_TIME"] - $mod;
        }
        return false;
    }

    public function getFileType()
    {
        if ($this->exists()) {
            $file_type  =   pathinfo($this->get());
            return $file_type['extension'];
        }
        return false;
    }

    public function ftpConnect($ftp_server, $ftp_username, $ftp_userpass)
    {
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login    = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
        return $ftp_conn;
    }

    public function ftpFileUpload($ftp_conn, $server_file, $local_file)
    {
        if (file_exists($local_file) && ftp_put($ftp_conn, $server_file, $local_file, FTP_ASCII)) {
            return true;
        } else {
            return false;
        }
    }

    public function ftpFileDownload($ftp_conn, $server_file, $local_file)
    {
        if (ftp_get($ftp_conn, $local_file, $server_file, FTP_ASCII)) {
            return true;
        } else {
            return false;
        }
    }

    public function ftpFileDelete($ftp_conn, $server_file)
    {
        if (ftp_delete($ftp_conn, $server_file)) {
            return true;
        } else {
            return false;
        }
    }

    public function ftpClose($ftp_conn)
    {
        ftp_close($ftp_conn);
    }
}
