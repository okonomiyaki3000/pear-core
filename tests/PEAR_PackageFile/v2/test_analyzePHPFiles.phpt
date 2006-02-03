--TEST--
PEAR_PackageFile_v2_Validator->analyzeSourceCode test
--SKIPIF--
<?php
if (!getenv('PHP_PEAR_RUNTESTS')) {
    echo 'skip';
}
if (!function_exists('token_get_all')) {
    echo 'skip';
}
?>
--FILE--
<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$pathtopackagexml = dirname(__FILE__)  . DIRECTORY_SEPARATOR .
    'Parser'. DIRECTORY_SEPARATOR .
    'test_basicparse'. DIRECTORY_SEPARATOR . 'package2.xml';
$pf = &$parser->parse(implode('', file($pathtopackagexml)), $pathtopackagexml);
$pf->flattenFilelist();
require_once 'PEAR/PackageFile/v2/Validator.php';
$val = new PEAR_PackageFile_v2_Validator;
$val->validate($pf); // setup purposes only
$phpunit->assertNoErrors('setup');

$x = $val->analyzeSourceCode('=+"\\//452');
echo "first test: returns false with non-existing filename? ";
echo $x ? "no\n" : "yes\n";

$testdir = $statedir;
@mkdir($testdir);

$test1 = '
<?php
::error();
?>
';
$fp = fopen($testdir . DIRECTORY_SEPARATOR . 'test1.php', 'w');
fwrite($fp, $test1);
fclose($fp);

$ret = $val->analyzeSourceCode($testdir . DIRECTORY_SEPARATOR . 'test1.php');
echo "second test: returns false with invalid PHP? ";
echo $ret ? "no\n" : "yes\n";
unlink($testdir . DIRECTORY_SEPARATOR . 'test1.php');

$test3 = '
<?php
class test
{
    class test2 {
    }
}
?>
';
$fp = fopen($testdir . DIRECTORY_SEPARATOR . 'test3.php', 'w');
fwrite($fp, $test3);
fclose($fp);

$ret = $val->analyzeSourceCode($testdir . DIRECTORY_SEPARATOR . 'test3.php');
echo "fourth test: returns false with invalid PHP? ";
echo $ret ? "no\n" : "yes\n";
unlink($testdir . DIRECTORY_SEPARATOR . 'test3.php');

$test4 = '
<?php
function test()
{
    class test2 {
    }
}
?>
';
$fp = fopen($testdir . DIRECTORY_SEPARATOR . 'test4.php', 'w');
fwrite($fp, $test4);
fclose($fp);

$ret = $val->analyzeSourceCode($testdir . DIRECTORY_SEPARATOR . 'test4.php');
echo "fifth test: returns false with invalid PHP? ";
echo $ret ? "no\n" : "yes\n";
unlink($testdir . DIRECTORY_SEPARATOR . 'test4.php');

$test5 = '
<?php
function test()
{
}

if (trytofool) {
    function fool()
    {
    }
}
class test2 {
    function test2() {
        parent::unused();
        Greg::classes();
        $a = new Pierre;
    }
}

class blah extends test2 {
    /**
     * @nodep Stig
     */
    function blah() 
    {
        Stig::rules();
    }
}
?>
';
$fp = fopen($testdir . DIRECTORY_SEPARATOR . 'test5.php', 'w');
fwrite($fp, $test5);
fclose($fp);

$ret = $val->analyzeSourceCode($testdir . DIRECTORY_SEPARATOR . 'test5.php');
echo "sixth test: returns false with valid PHP? ";
echo $ret ? "no\n" : "yes\n";
$ret['source_file'] = str_replace(array(dirname(__FILE__),DIRECTORY_SEPARATOR), array('', '/'), $ret['source_file']);
$phpunit->assertErrors(array(
    array('package' => 'PEAR_PackageFile_v2', 'message' => 'Parser error: invalid PHP found in file "' .
     $temp_path . DIRECTORY_SEPARATOR . 'test1.php"'),
    array('package' => 'PEAR_PackageFile_v2', 'message' => 'Parser error: invalid PHP found in file "' .
     $temp_path . DIRECTORY_SEPARATOR . 'test3.php"'),
    array('package' => 'PEAR_PackageFile_v2', 'message' => 'Parser error: invalid PHP found in file "' .
     $temp_path . DIRECTORY_SEPARATOR . 'test4.php"'),
), 'pre-errors');
$phpunit->assertEquals(array (
  'source_file' => '/testinstallertemp/test5.php',
  'declared_classes' => 
  array (
    0 => 'test2',
    1 => 'blah',
  ),
  'declared_interfaces' => 
  array (
  ),
  'declared_methods' => 
  array (
    'test2' => 
    array (
      0 => 'test2',
    ),
    'blah' => 
    array (
      0 => 'blah',
    ),
  ),
  'declared_functions' => 
  array (
    0 => 'test',
    1 => 'fool',
  ),
  'used_classes' => 
  array (
    0 => 'Greg',
    1 => 'Pierre',
  ),
  'inheritance' => 
  array (
    'blah' => 'test2',
  ),
  'implements' => 
  array (
  ),
), $ret, 'ret');

?>
--CLEAN--
<?php
require_once dirname(__FILE__) . '/teardown.php.inc';
?>
--EXPECT--
first test: returns false with non-existing filename? yes
second test: returns false with invalid PHP? yes
fourth test: returns false with invalid PHP? yes
fifth test: returns false with invalid PHP? yes
sixth test: returns false with valid PHP? no