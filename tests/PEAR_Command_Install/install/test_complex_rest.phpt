--TEST--
install command, complex test
--SKIPIF--
<?php
if (!getenv('PHP_PEAR_RUNTESTS')) {
    echo 'skip';
}
?>
--FILE--
<?php
error_reporting(1803);
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$ch = new PEAR_ChannelFile;
$ch->setName('smork');
$ch->setSummary('smork');
$ch->setBaseURL('REST1.0', 'http://smork/rest/');
$reg = &$config->getRegistry();
$phpunit->assertTrue($reg->addChannel($ch), 'smork setup');
$chan = &$reg->getChannel('pear.php.net');
$chan->setBaseURL('REST1.0', 'http://pear.php.net/rest/');
$reg->updateChannel($chan);
$pathtopackagexml = dirname(__FILE__)  . DIRECTORY_SEPARATOR .
    'packages'. DIRECTORY_SEPARATOR . 'package2.xml';
$pathtobarxml = dirname(__FILE__)  . DIRECTORY_SEPARATOR .
    'packages'. DIRECTORY_SEPARATOR . 'Bar-1.5.2.tgz';
$pathtofoobarxml = dirname(__FILE__)  . DIRECTORY_SEPARATOR .
    'packages'. DIRECTORY_SEPARATOR . 'Foobar-1.5.0a1.tgz';
$GLOBALS['pearweb']->addHtmlConfig('http://www.example.com/Bar-1.5.2.tgz', $pathtobarxml);
$GLOBALS['pearweb']->addHtmlConfig('http://www.example.com/Foobar-1.5.0a1.tgz', $pathtofoobarxml);
$pearweb->addRESTConfig("http://pear.php.net/rest/r/bar/allreleases.xml", '<?xml version="1.0"?>
<a xmlns="http://pear.php.net/dtd/rest.allreleases"
    xsi:schemaLocation="http://pear.php.net/dtd/rest.allreleases
    http://pear.php.net/dtd/rest.allreleases.xsd">
 <p>Bar</p>
 <c>pear.php.net</c>
 <r><v>1.5.2</v><s>stable</s></r>
</a>', 'text/xml');
$pearweb->addRESTConfig("http://pear.php.net/rest/r/bar/deps.1.5.2.txt", 'a:1:{s:8:"required";a:3:{s:3:"php";a:2:{s:3:"min";s:5:"4.3.6";s:3:"max";s:5:"6.0.0";}s:13:"pearinstaller";a:1:{s:3:"min";s:7:"1.4.0a1";}s:7:"package";a:2:{s:4:"name";s:6:"Foobar";s:7:"channel";s:5:"smork";}}}', 'text/plain');
$pearweb->addRESTConfig("http://pear.php.net/rest/r/bar/1.5.2.xml", '<?xml version="1.0"?>
<r xmlns="http://pear.php.net/dtd/rest.release"
    xsi:schemaLocation="http://pear.php.net/dtd/rest.release
    http://pear.php.net/dtd/rest.release.xsd">
 <p xlink:href="/rest/p/bar">Bar</p>
 <c>pear.php.net</c>
 <v>1.5.2</v>
 <st>stable</st>
 <l>PHP License</l>
 <m>cellog</m>
 <s>PEAR Base System</s>
 <d>The PEAR package contains:
 * the PEAR installer, for creating, distributing
   and installing packages
 * the alpha-quality PEAR_Exception PHP5 error handling mechanism
 * the beta-quality PEAR_ErrorStack advanced error handling mechanism
 * the PEAR_Error error handling mechanism
 * the OS_Guess class for retrieving info about the OS
   where PHP is running on
 * the System class for quick handling of common operations
   with files and directories
 * the PEAR base class</d>
 <da>2005-04-17 18:40:51</da>
 <n>Release notes</n>
 <f>252733</f>
 <g>http://www.example.com/Bar-1.5.2</g>
 <x xlink:href="package.1.5.2.xml"/>

</r>', 'text/xml');
$pearweb->addRESTConfig("http://smork/rest/r/foobar/allreleases.xml", '<?xml version="1.0"?>
<a xmlns="http://pear.php.net/dtd/rest.allreleases"
    xsi:schemaLocation="http://pear.php.net/dtd/rest.allreleases
    http://pear.php.net/dtd/rest.allreleases.xsd">
 <p>Foobar</p>
 <c>smork</c>
 <r><v>1.5.0a1</v><s>stable</s></r>
</a>', 'text/xml');
$pearweb->addRESTConfig("http://smork/rest/r/foobar/deps.1.5.0a1.txt", 'a:1:{s:8:"required";a:2:{s:3:"php";a:2:{s:3:"min";s:5:"4.3.6";s:3:"max";s:5:"6.0.0";}s:13:"pearinstaller";a:1:{s:3:"min";s:7:"1.4.0a1";}}}', 'text/plain');
$pearweb->addRESTConfig("http://smork/rest/r/foobar/1.5.0a1.xml", '<?xml version="1.0"?>
<r xmlns="http://pear.php.net/dtd/rest.release"
    xsi:schemaLocation="http://pear.php.net/dtd/rest.release
    http://pear.php.net/dtd/rest.release.xsd">
 <p xlink:href="/rest/p/foobar">Foobar</p>
 <c>smork</c>
 <v>1.5.0a1</v>
 <st>alpha</st>
 <l>PHP License</l>
 <m>cellog</m>
 <s>PEAR Base System</s>
 <d>The PEAR package contains:
 * the PEAR installer, for creating, distributing
   and installing packages
 * the alpha-quality PEAR_Exception PHP5 error handling mechanism
 * the beta-quality PEAR_ErrorStack advanced error handling mechanism
 * the PEAR_Error error handling mechanism
 * the OS_Guess class for retrieving info about the OS
   where PHP is running on
 * the System class for quick handling of common operations
   with files and directories
 * the PEAR base class</d>
 <da>2005-04-17 18:40:51</da>
 <n>Release notes</n>
 <f>252733</f>
 <g>http://www.example.com/Foobar-1.5.0a1</g>
 <x xlink:href="package.1.5.0a1.xml"/>

</r>', 'text/xml');
$pearweb->addRESTConfig("http://pear.php.net/rest/p/bar/info.xml", '<?xml version="1.0" encoding="UTF-8" ?>
<p xmlns="http://pear.php.net/dtd/rest.package"    xsi:schemaLocation="http://pear.php.net/dtd/rest.package    http://pear.php.net/dtd/rest.package.xsd">
 <n>bar</n>
 <c>pear.php.net</c>
 <ca xlink:href="/rest/c/PEAR">PEAR</ca>
 <l>PHP License 3.0</l>
 <s>PEAR_PackageFileManager takes an existing package.xml file and updates it with a new filelist and changelog</s>
 <d>This package revolutionizes the maintenance of PEAR packages.  With a few parameters,
the entire package.xml is automatically updated with a listing of all files in a package.
Features include
 - manages the new package.xml 2.0 format in PEAR 1.4.0
 - can detect PHP and extension dependencies using PHP_CompatInfo
 - reads in an existing package.xml file, and only changes the release/changelog
 - a plugin system for retrieving files in a directory.  Currently two plugins
   exist, one for standard recursive directory content listing, and one that
   reads the CVS/Entries files and generates a file listing based on the contents
   of a checked out CVS repository
 - incredibly flexible options for assigning install roles to files/directories
 - ability to ignore any file based on a * ? wildcard-enabled string(s)
 - ability to include only files that match a * ? wildcard-enabled string(s)
 - ability to manage dependencies
 - can output the package.xml in any directory, and read in the package.xml
   file from any directory.
 - can specify a different name for the package.xml file

PEAR_PackageFileManager is fully unit tested.
The new PEAR_PackageFileManager2 class is not.</d>
 <r xlink:href="/rest/r/pear_packagefilemanager"/>
</p>', 'text/xml');
$pearweb->addRESTConfig("http://pear.php.net/rest/p/foobar/info.xml", '<?xml version="1.0" encoding="UTF-8" ?>
<p xmlns="http://pear.php.net/dtd/rest.package"    xsi:schemaLocation="http://pear.php.net/dtd/rest.package    http://pear.php.net/dtd/rest.package.xsd">
 <n>foobar</n>
 <c>pear.php.net</c>
 <ca xlink:href="/rest/c/PEAR">PEAR</ca>
 <l>PHP License 3.0</l>
 <s>PEAR_PackageFileManager takes an existing package.xml file and updates it with a new filelist and changelog</s>
 <d>This package revolutionizes the maintenance of PEAR packages.  With a few parameters,
the entire package.xml is automatically updated with a listing of all files in a package.
Features include
 - manages the new package.xml 2.0 format in PEAR 1.4.0
 - can detect PHP and extension dependencies using PHP_CompatInfo
 - reads in an existing package.xml file, and only changes the release/changelog
 - a plugin system for retrieving files in a directory.  Currently two plugins
   exist, one for standard recursive directory content listing, and one that
   reads the CVS/Entries files and generates a file listing based on the contents
   of a checked out CVS repository
 - incredibly flexible options for assigning install roles to files/directories
 - ability to ignore any file based on a * ? wildcard-enabled string(s)
 - ability to include only files that match a * ? wildcard-enabled string(s)
 - ability to manage dependencies
 - can output the package.xml in any directory, and read in the package.xml
   file from any directory.
 - can specify a different name for the package.xml file

PEAR_PackageFileManager is fully unit tested.
The new PEAR_PackageFileManager2 class is not.</d>
 <r xlink:href="/rest/r/pear_packagefilemanager"/>
</p>', 'text/xml');
$pearweb->addRESTConfig("http://smork/rest/p/foobar/info.xml", '<?xml version="1.0" encoding="UTF-8" ?>
<p xmlns="http://pear.php.net/dtd/rest.package"    xsi:schemaLocation="http://pear.php.net/dtd/rest.package    http://pear.php.net/dtd/rest.package.xsd">
 <n>foobar</n>
 <c>smork</c>
 <ca xlink:href="/rest/c/PEAR">PEAR</ca>
 <l>PHP License 3.0</l>
 <s>PEAR_PackageFileManager takes an existing package.xml file and updates it with a new filelist and changelog</s>
 <d>This package revolutionizes the maintenance of PEAR packages.  With a few parameters,
the entire package.xml is automatically updated with a listing of all files in a package.
Features include
 - manages the new package.xml 2.0 format in PEAR 1.4.0
 - can detect PHP and extension dependencies using PHP_CompatInfo
 - reads in an existing package.xml file, and only changes the release/changelog
 - a plugin system for retrieving files in a directory.  Currently two plugins
   exist, one for standard recursive directory content listing, and one that
   reads the CVS/Entries files and generates a file listing based on the contents
   of a checked out CVS repository
 - incredibly flexible options for assigning install roles to files/directories
 - ability to ignore any file based on a * ? wildcard-enabled string(s)
 - ability to include only files that match a * ? wildcard-enabled string(s)
 - ability to manage dependencies
 - can output the package.xml in any directory, and read in the package.xml
   file from any directory.
 - can specify a different name for the package.xml file

PEAR_PackageFileManager is fully unit tested.
The new PEAR_PackageFileManager2 class is not.</d>
 <r xlink:href="/rest/r/pear_packagefilemanager"/>
</p>', 'text/xml');
$_test_dep->setPHPVersion('4.3.11');
$_test_dep->setPEARVersion('1.4.0a1');
$config->set('preferred_state', 'alpha');
$res = $command->run('install', array(), array($pathtopackagexml));
$phpunit->assertNoErrors('after install');
$phpunit->assertTrue($res, 'result');
$dl = &$command->getDownloader(1, array());
if (OS_WINDOWS) {
    $phpunit->assertEquals(array (
  array (
    0 => 3,
    1 => 'Downloading "http://www.example.com/Bar-1.5.2.tgz"',
  ),
  array (
    0 => 1,
    1 => 'downloading Bar-1.5.2.tgz ...',
  ),
  array (
    0 => 1,
    1 => 'Starting to download Bar-1.5.2.tgz (2,213 bytes)',
  ),
  array (
    0 => 1,
    1 => '.',
  ),
  array (
    0 => 1,
    1 => '...done: 2,213 bytes',
  ),
  array (
    0 => 3,
    1 => 'Downloading "http://www.example.com/Foobar-1.5.0a1.tgz"',
  ),
  array (
    0 => 1,
    1 => 'downloading Foobar-1.5.0a1.tgz ...',
  ),
  array (
    0 => 1,
    1 => 'Starting to download Foobar-1.5.0a1.tgz (2,208 bytes)',
  ),
  array (
    0 => 1,
    1 => '...done: 2,208 bytes',
  ),
  array (
    0 => 3,
    1 => '+ cp ' . str_replace('\\\\', '\\', $dl->getDownloadDir()) . DIRECTORY_SEPARATOR . 'Foobar-1.5.0a1'  . DIRECTORY_SEPARATOR . 'foo12.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo12.php',
  ),
  array (
    0 => 2,
    1 => 'md5sum ok: ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo12.php',
  ),
  array (
    0 => 3,
    1 => 'adding to transaction: rename ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo12.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo12.php ',
  ),
  array (
    0 => 3,
    1 => 'adding to transaction: installed_as foo12.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo12.php ' . $temp_path . '\\php \\',
  ),
  array (
    0 => 2,
    1 => 'about to commit 2 file operations',
  ),
  array (
    0 => 3,
    1 => '+ mv ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo12.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo12.php',
  ),
  array (
    0 => 2,
    1 => 'successfully committed 2 file operations',
  ),
  array (
    'info' => 
    array (
      'data' => 'install ok: channel://smork/Foobar-1.5.0a1',
    ),
    'cmd' => 'install',
  ),
  array (
    0 => 3,
    1 => '+ cp ' . str_replace('\\\\', '\\', $dl->getDownloadDir()) . ''  . DIRECTORY_SEPARATOR . 'Bar-1.5.2'  . DIRECTORY_SEPARATOR . 'foo1.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo1.php',
  ),
  array (
    0 => 2,
    1 => 'md5sum ok: ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo1.php',
  ),
  array (
    0 => 3,
    1 => 'adding to transaction: rename ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo1.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo1.php ',
  ),
  array (
    0 => 3,
    1 => 'adding to transaction: installed_as foo1.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo1.php ' . $temp_path . '\\php \\',
  ),
  array (
    0 => 2,
    1 => 'about to commit 2 file operations',
  ),
  array (
    0 => 3,
    1 => '+ mv ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo1.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo1.php',
  ),
  array (
    0 => 2,
    1 => 'successfully committed 2 file operations',
  ),
  array (
    'info' => 
    array (
      'data' => 'install ok: channel://pear.php.net/Bar-1.5.2',
    ),
    'cmd' => 'install',
  ),
  array (
    0 => 3,
    1 => '+ cp ' . dirname(__FILE__) . '\\packages\\foo.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo.php',
  ),
  array (
    0 => 3,
    1 => 'adding to transaction: rename ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo.php ',
  ),
  array (
    0 => 3,
    1 => 'adding to transaction: installed_as foo.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo.php ' . $temp_path . '\\php \\',
  ),
  array (
    0 => 2,
    1 => 'about to commit 2 file operations',
  ),
  array (
    0 => 3,
    1 => '+ mv ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo.php',
  ),
  array (
    0 => 2,
    1 => 'successfully committed 2 file operations',
  ),
  array (
    'info' => 
    array (
      'data' => 'install ok: channel://pear.php.net/PEAR1-1.5.0a1',
    ),
    'cmd' => 'install',
  ),
), $fakelog->getLog(), 'log messages');
} else {
    // Don't forget umask ! permission of new file is 0666
    $umask = decoct(0666 & ( 0777 - umask()));
    $phpunit->assertEquals(array (
      array (
        0 => 3,
        1 => 'Downloading "http://www.example.com/Bar-1.5.2.tgz"',
      ),
      array (
        0 => 1,
        1 => 'downloading Bar-1.5.2.tgz ...',
      ),
      array (
        0 => 1,
        1 => 'Starting to download Bar-1.5.2.tgz (2,213 bytes)',
      ),
      array (
        0 => 1,
        1 => '.',
      ),
      array (
        0 => 1,
        1 => '...done: 2,213 bytes',
      ),
      array (
        0 => 3,
        1 => 'Downloading "http://www.example.com/Foobar-1.5.0a1.tgz"',
      ),
      array (
        0 => 1,
        1 => 'downloading Foobar-1.5.0a1.tgz ...',
      ),
      array (
        0 => 1,
        1 => 'Starting to download Foobar-1.5.0a1.tgz (2,208 bytes)',
      ),
      array (
        0 => 1,
        1 => '...done: 2,208 bytes',
      ),
      array (
        0 => 3,
        1 => '+ cp ' . str_replace('\\\\', '\\', $dl->getDownloadDir()) . DIRECTORY_SEPARATOR . 'Foobar-1.5.0a1'  . DIRECTORY_SEPARATOR . 'foo12.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo12.php',
      ),
      array (
        0 => 2,
        1 => 'md5sum ok: ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo12.php',
      ),
      array (
        0 => 3,
        1 => 'adding to transaction: chmod '.$umask.' ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo12.php',
      ),
      array (
        0 => 3,
        1 => 'adding to transaction: rename ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo12.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo12.php ',
      ),
      array (
        0 => 3,
        1 => 'adding to transaction: installed_as foo12.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo12.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php '  . DIRECTORY_SEPARATOR . '',
      ),
      array (
        0 => 2,
        1 => 'about to commit 3 file operations',
      ),
      array (
        0 => 3,
        1 => '+ chmod '.$umask.' ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo12.php',
      ),
      array (
        0 => 3,
        1 => '+ mv ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo12.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo12.php',
      ),
      array (
        0 => 2,
        1 => 'successfully committed 3 file operations',
      ),
      array (
        'info' => 
        array (
          'data' => 'install ok: channel://smork/Foobar-1.5.0a1',
        ),
        'cmd' => 'install',
      ),
      array (
        0 => 3,
        1 => '+ cp ' . str_replace('\\\\', '\\', $dl->getDownloadDir()) . ''  . DIRECTORY_SEPARATOR . 'Bar-1.5.2'  . DIRECTORY_SEPARATOR . 'foo1.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo1.php',
      ),
      array (
        0 => 2,
        1 => 'md5sum ok: ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo1.php',
      ),
      array (
        0 => 3,
        1 => 'adding to transaction: chmod '.$umask.' ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo1.php',
      ),
      array (
        0 => 3,
        1 => 'adding to transaction: rename ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo1.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo1.php ',
      ),
      array (
        0 => 3,
        1 => 'adding to transaction: installed_as foo1.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo1.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php '  . DIRECTORY_SEPARATOR . '',
      ),
      array (
        0 => 2,
        1 => 'about to commit 3 file operations',
      ),
      array (
        0 => 3,
        1 => '+ chmod '.$umask.' ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo1.php',
      ),
      array (
        0 => 3,
        1 => '+ mv ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo1.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo1.php',
      ),
      array (
        0 => 2,
        1 => 'successfully committed 3 file operations',
      ),
      array (
        'info' => 
        array (
          'data' => 'install ok: channel://pear.php.net/Bar-1.5.2',
        ),
        'cmd' => 'install',
      ),
      array (
        0 => 3,
        1 => '+ cp ' . dirname(__FILE__) . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'foo.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo.php',
      ),
      array (
        0 => 3,
        1 => 'adding to transaction: chmod '.$umask.' ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo.php',
      ),
      array (
        0 => 3,
        1 => 'adding to transaction: rename ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo.php ',
      ),
      array (
        0 => 3,
        1 => 'adding to transaction: installed_as foo.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php '  . DIRECTORY_SEPARATOR . '',
      ),
      array (
        0 => 2,
        1 => 'about to commit 3 file operations',
      ),
      array (
        0 => 3,
        1 => '+ chmod '.$umask.' ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo.php',
      ),
      array (
        0 => 3,
        1 => '+ mv ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . '.tmpfoo.php ' . $temp_path . DIRECTORY_SEPARATOR . 'php'  . DIRECTORY_SEPARATOR . 'foo.php',
      ),
      array (
        0 => 2,
        1 => 'successfully committed 3 file operations',
      ),
      array (
        'info' => 
        array (
          'data' => 'install ok: channel://pear.php.net/PEAR1-1.5.0a1',
        ),
        'cmd' => 'install',
      ),
    ), $fakelog->getLog(), 'log messages');
}
$phpunit->assertEquals(array (
  array (
    0 => 'http://pear.php.net/rest/r/bar/allreleases.xml',
    1 => '200',
  ),
  array (
    0 => 'http://pear.php.net/rest/p/bar/info.xml',
    1 => '200',
  ),
  array (
    0 => 'http://pear.php.net/rest/r/bar/1.5.2.xml',
    1 => '200',
  ),
  array (
    0 => 'http://pear.php.net/rest/r/bar/deps.1.5.2.txt',
    1 => '200',
  ),
  array (
    0 => 'http://smork/rest/r/foobar/allreleases.xml',
    1 => '200',
  ),
  array (
    0 => 'http://smork/rest/p/foobar/info.xml',
    1 => '200',
  ),
  array (
    0 => 'http://smork/rest/r/foobar/1.5.0a1.xml',
    1 => '200',
  ),
  array (
    0 => 'http://smork/rest/r/foobar/deps.1.5.0a1.txt',
    1 => '200',
  ),
), $pearweb->getRESTCalls(), 'rest');
echo 'tests done';
?>
--CLEAN--
<?php
require_once dirname(dirname(__FILE__)) . '/teardown.php.inc';
?>
--EXPECT--
tests done
