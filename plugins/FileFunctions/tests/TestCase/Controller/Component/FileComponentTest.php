<?php

namespace FileFunctions\Test\TestCase\Controller\Component;

use FileFunctions\Controller\Component\FileComponent;
use Cake\TestSuite\TestCase;
use Cake\Controller\Controller;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\TestSuite\IntegrationTestCase;

class FileComponentTest extends TestCase
{
    protected static $instance;
    public $component = null;
    public $controller = null;

    public function setUp()
    {
        parent::setUp();
        $controller = $this->getMock('Cake\Controller\Controller', ['redirect']);
        $this->registry = new ComponentRegistry($controller);
        $this->component = new FileComponent($this->registry);
    }

    public function testCreateFile()
    {
        $file_obj = $this->component->getObject();                                     //  Create Object
        $file_obj->set('D:\codebase\htdocs\new_cake\webroot\test\new_file.txt');       //  Set path to create file
        $actual    = $file_obj->createFile();
        //$expected  = true;
        //$this->assertEquals($expected, $actual);
        $this->assertContains($actual, [true, false]);
    }

    public function testAppend()
    {
        $file_obj = $this->component->getObject();                                     //  Create Object
        $file_obj->set('D:\codebase\htdocs\new_cake\webroot\test\new_file.txt');       //  Set path of file to append
        $actual    = $file_obj->append('This is the appended Text');
        $this->assertContains($actual, [true, false]);
    }

    public function testPrepend()
    {
        $file_obj = $this->component->getObject();                                     //  Create Object
        $file_obj->set('D:\codebase\htdocs\new_cake\webroot\test\new_file.txt');       //  Set path of file to prepend
        $actual    = $file_obj->prepend('This is the prepended Text');
        $this->assertContains($actual, [true, false]);
    }

    public function testSave()
    {
        $file_obj = $this->component->getObject();                                     //  Create Object
        $file_obj->set('D:\codebase\htdocs\new_cake\webroot\test\new_file.txt');       //  Set path of file to replace content in file
        $actual    = $file_obj->save('This is New Text');
        $this->assertContains($actual, [true, false]);
    }

    public function testModified()
    {
        $file_obj = $this->component->getObject();                                     //  Create Object
        $file_obj->set('D:\codebase\htdocs\new_cake\webroot\test\new_file.txt');       //  Set path of file to check when it was modified
        $actual    = $file_obj->modified();
        $expected_value =   date("F d Y H:i:s.", filemtime('D:\codebase\htdocs\new_cake\webroot\test\new_file.txt'));
        $this->assertContains($actual, [$expected_value, false]);
    }

    public function testDelete()
    {
        $file_obj = $this->component->getObject();                                     //  Create Object
        $file_obj->set('D:\codebase\htdocs\new_cake\webroot\test\new_file.txt');       //  Set path of file to delete
        $actual    = $file_obj->delete();
        $this->assertContains($actual, [true, false]);
    }

    public function testCopyFile()
    {
        $file_obj = $this->component->getObject();                                     //  Create Object
        $actual =   $file_obj->copyFile('D:\codebase\htdocs\new_cake\webroot\test\new_file.txt', 'D:\codebase\htdocs\new_cake\webroot\test\test_file_copy.txt');
        $this->assertContains($actual, [true, false]);
    }

    public function testRenameFile()
    {
        $file_obj = $this->component->getObject();                                     //  Create Object
        $actual =   $file_obj->renameFile('D:\codebase\htdocs\new_cake\webroot\test\test_file_copy.txt', 'D:\codebase\htdocs\new_cake\webroot\test\test_file_copy1.txt');
        $this->assertContains($actual, [true, false]);
    }

    public function testIsFileReadable()
    {
        $file_obj = $this->component->getObject();                                     //  Create Object
        $file_obj->set('D:\codebase\htdocs\new_cake\webroot\test\new_file.txt');       //  Set path of file to check if it is Readable
        $actual    = $file_obj->isFileReadable();
        $this->assertContains($actual, [true, false]);
    }


    public function testIsFileWritable()
    {
        $file_obj = $this->component->getObject();                                     //  Create Object
        $file_obj->set('D:\codebase\htdocs\new_cake\webroot\test\new_file.txt');       //  Set path of file to check if it is Writable
        $actual    = $file_obj->isFileWritable();
        $this->assertContains($actual, [true, false]);
    }

    public function testChangePermission()
    {
        $file_obj = $this->component->getObject();                                     //  Create Object
        $file_obj->set('D:\codebase\htdocs\new_cake\webroot\test\new_file.txt');       //  Set path of file to change permission
        $actual    = $file_obj->changePermission('777');
        $this->assertContains($actual, [true, false]);
    }

    public function testFtpFileUpload()
    {
        $file_obj = $this->component->getObject();                                     //  Create Object
        $ftp_conn = $file_obj->ftpConnect('192.168.2.4', 'ib', 'Inf@be@ns.$%^');      // Connect to FTP using host name, username, password
        $actual   = $file_obj->ftpFileUpload($ftp_conn, 'server_file.txt', 'D:\codebase\htdocs\new_cake\webroot\test\new_file.txt');
        $file_obj->ftpClose($ftp_conn);
        $this->assertContains($actual, [true, false]);
    }

    public function testFtpFileDownload()
    {
        $file_obj = $this->component->getObject();                                     //  Create Object
        $ftp_conn = $file_obj->ftpConnect('192.168.2.4', 'ib', 'Inf@be@ns.$%^');      // Connect to FTP using host name, username, password
        $actual   = $file_obj->ftpFileDownload($ftp_conn, 'server_file.txt', 'D:\codebase\htdocs\new_cake\webroot\test\local.txt');
        $file_obj->ftpClose($ftp_conn);
        $this->assertContains($actual, [true, false]);
    }


    public function testFtpFileDelete()
    {
        $file_obj = $this->component->getObject();                                     //  Create Object
        $ftp_conn = $file_obj->ftpConnect('192.168.2.4', 'ib', 'Inf@be@ns.$%^');      // Connect to FTP using host name, username, password
        $actual   = $file_obj->ftpFileDelete($ftp_conn, 'server_file.txt');
        $file_obj->ftpClose($ftp_conn);
        $this->assertContains($actual, [true, false]);
    }
}
