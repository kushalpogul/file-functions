FTP File upload, Download, Delete & File manipulation operations plugin for CakePHP 3.X
=======================================================================================

[![Build status](https://img.shields.io/travis/kushalpogul/file-functions.svg?style=flat-square)](https://travis-ci.org/kushalpogul/file-functions)
[![Code coverage](https://img.shields.io/coveralls/kushalpogul/file-functions.svg?style=flat-square)](https://coveralls.io/github/kushalpogul/file-functions)
[![License](https://img.shields.io/packagist/l/kushalpogul/file-functions.svg?style=flat-square)](https://github.com/kushalpogul/file-functions/blob/master/LICENSE)
[![Latest Stable Version](https://img.shields.io/github/release/kushalpogul/file-functions.svg?style=flat-square)](https://github.com/kushalpogul/file-functions/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/kushalpogul/file-functions.svg?style=flat-square)](https://packagist.org/packages/kushalpogul/file-functions)
[![Code Climate](https://img.shields.io/codeclimate/github/kushalpogul/file-functions.svg?style=flat-square)](https://codeclimate.com/github/kushalpogul/file-functions)

Plugin helps to upload, download, delete file from FTP Server. This plugin also allows various useful file manipulation operations.

Installation
------------

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require kushalpogul/file-functions
```

After installing it you'll need to load it on your `bootstrap.php` file:

```php
Plugin::load('FileFunctions', ['autoload' => true]);
```

And load it into initialize() function of Controller File:

```php
$this->loadComponent('FileFunctions.File' );	
```

Requirements
-----

1) CakePHP 3
2) PHP 5.4
3) FTP Server


Functions in Plugin
--------------------

Plugin allows upload, download, delete file from FTP Server, file manipulation operations like create, append, prepend, save content into file, last modified time, delete file, make copy of file, rename file, check file is readable and writable, change permission of file and get File Extension.

Usage:
------

1) For FTP File Upload, Download & Delete:

In Controller file:	

```php
	//  Create Object 
	$file_obj = $this->File->getObject();       							
	
	// Connect to FTP using host name, username, password
	$ftp_conn=  $file_obj->ftpConnect('HOST', 'USERNAME' , 'PASSWORD');         

	// ftpFileUpload returns true -> after upload, false -> failure
	$file_obj->ftpFileUpload($ftp_conn, 'server_file', 'local_file');           

	// ftpFileDownload returns true -> after download, false -> failure
	$file_obj->ftpFileDownload($ftp_conn,'server_file', 'local_file');          

	// ftpFileDeletereturns true -> after delete, false -> failure
	$file_obj->ftpFileDelete($ftp_conn,'server_file');               	

	// Close FTP Connection
	$file_obj->ftpClose($ftp_conn);
```

2) For File Manipulation operation:

In Controller file:	

```php
	//  Create Object 
	$file_obj = $this->File->getObject();       

	// Set file
	$file_obj->set('set/file/path/file_name'); 
    
	// createFile returns true -> file is created, false -> file is already present
	$file_obj->createFile();                 

	// append returns true -> text is appended, false -> failure
	$file_obj->append('Last Text');          

	// prepend returns true -> text is prepend, false -> failure
	$file_obj->prepend('Start Text');        

	// save returns true -> content of file is replaced by text, false -> failure
	$file_obj->save('This is new Text');     

	// modified returns date & time of when file was modified last, false -> failure	
	echo $file_obj->modified();            

	// delete returns true -> file is deleted, false -> failure	
	$file_obj->delete();                   

	// copyFile returns true -> file copied , false -> failure	
	$file_obj->copyFile('path/of/file/src','path/of/file/dst');
	
	// renameFile returns true -> file is renamed , false -> failure	
	$file_obj->renameFile('path/of/file/file_name','path/of/file/new_filename');

	// isFileReadable returns true -> file is readable, false -> file is not readable	
	$file_obj->isFileReadable();          

	// isFileWritable returns true -> file is writable, false -> file is not writable
	$file_obj->isFileWritable();          

	// changePermission returns true -> file permission is changed, false -> failure     	
	$file_obj->changePermission('777'); 
	
	// getFileType returns file type, false -> failure	  	
	echo $file_obj->getFileType(); 
	
```

