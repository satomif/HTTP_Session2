--TEST--
HTTP_Session2 testing session write and read
--FILE--
<?php
$_tmp = dirname(__FILE__) . '/tmp';
$_id  = 1234;

require_once 'HTTP/Session2.php';

if (!file_exists($_tmp)) {
    mkdir($_tmp);
}
ini_set('session.save_path', $_tmp);

HTTP_Session2::useCookies(false);
HTTP_Session2::start('testSession');
HTTP_Session2::id($_id);

$nCount = 0;
while(++$nCount <= 2) {
    $_var = HTTP_Session2::get('test', 'bar');
    if ($_var == 'bar') {
        var_dump("Setting..");
        HTTP_Session2::set('test', 'foobar');
    } else {
        var_dump("Retrieving..");
        var_dump(HTTP_Session2::get('test'));
    }
}
--CLEAN--
<?php
$_tmp = dirname(__FILE__) . '/tmp';
$_id  = 1234;

unlink($_tmp . '/' . 'sess_' . $_id);
rmdir($_tmp);
--EXPECT--
string(9) "Setting.."
string(12) "Retrieving.."
string(6) "foobar"
