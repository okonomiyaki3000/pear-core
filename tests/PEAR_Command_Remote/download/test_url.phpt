--TEST--
download command (url)
--SKIPIF--
<?php
if (!getenv('PHP_PEAR_RUNTESTS')) {
    echo 'skip';
}
?>
--FILE--
<?php
error_reporting(E_ALL);
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$reg = &$config->getRegistry();
$pathtopackagexml = dirname(__FILE__)  . DIRECTORY_SEPARATOR .
    'packages'. DIRECTORY_SEPARATOR . 'test-1.0.tgz';
$GLOBALS['pearweb']->addHtmlConfig('http://www.example.com/test-1.0.tgz', $pathtopackagexml);
mkdir($temp_path . DIRECTORY_SEPARATOR . 'bloob');
chdir($temp_path . DIRECTORY_SEPARATOR . 'bloob');
$e = $command->run('download', array(), array('http://www.example.com/test-1.0.tgz'));
$phpunit->assertNoErrors('download');
$phpunit->assertEquals(array (
  0 => 
  array (
    0 => 1,
    1 => 'downloading test-1.0.tgz ...',
  ),
  1 => 
  array (
    0 => 1,
    1 => 'Starting to download test-1.0.tgz (785 bytes)',
  ),
  2 => 
  array (
    0 => 1,
    1 => '.',
  ),
  3 => 
  array (
    0 => 1,
    1 => '...done: 785 bytes',
  ),
  4 => 
  array (
    'info' => 'File ' . $temp_path . DIRECTORY_SEPARATOR . 'bloob' .
        DIRECTORY_SEPARATOR . 'test-1.0.tgz downloaded',
    'cmd' => 'download',
  ),
), $fakelog->getLog(), 'log');
$phpunit->showall();
$phpunit->assertEquals(array (
  0 => 
  array (
    0 => 'setup',
    1 => 'self',
  ),
  1 => 
  array (
    0 => 'saveas',
    1 => 'test-1.0.tgz',
  ),
  2 => 
  array (
    0 => 'start',
    1 => 
    array (
      0 => 'test-1.0.tgz',
      1 => '785',
    ),
  ),
  3 => 
  array (
    0 => 'bytesread',
    1 => 785,
  ),
  4 => 
  array (
    0 => 'done',
    1 => 785,
  ),
), $fakelog->getDownload(), 'download log');
echo 'tests done';
?>
--EXPECT--
tests done
