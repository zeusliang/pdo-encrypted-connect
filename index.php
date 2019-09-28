<?php
/** 使用 pdo 加密连接 mysql  **/
echo "pdo 加密连接 MySQL 测试代码<br>";
$dbname = 'mysql';
$dbname = '';
$host = '172.17.0.4';
$dsn = "mysql:dbname=$dbname;host=$host";
echo 'dsn信息:'.$dsn.'<br>';
$user = 'root';
$password = '1@2019aj-k';

try {
	// 设置MySQL安全连接(ssl)选项
	/*ssl-ca=/var/lib/mysql/ca.pem
	ssl-cert=/var/lib/mysql/server-cert.pem
	ssl-key=/var/lib/mysql/server-key.pem*/
	$ssl_cnf = array(
    	PDO::MYSQL_ATTR_SSL_KEY  => ' /var/www/html/wx/test/public/client-key.pem',
		PDO::MYSQL_ATTR_SSL_CERT => ' /var/www/html/wx/test/public/client-cert.pem',
		PDO::MYSQL_ATTR_SSL_CA   => ' /var/www/html/wx/test/public/ca.pem',
		// 开启ssl 证书检测 
		PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false 
    );
    echo 'pdo 加密连接 ssl 相关配置<br>';
    var_dump($ssl_cnf);

    $dbh = new PDO($dsn, $user, $password,$ssl_cnf);
    //$dbh = new PDO($dsn, $user, $password);
    // 查询当前连接状态(若字段"Ssl_cipher"不为空，则表示为加密连接)
    $query_stmt = 'SHOW SESSION STATUS LIKE "Ssl_cipher"';
    $pdo_stmt_obj = $dbh->query($query_stmt);
    $qrs = $pdo_stmt_obj->fetchAll();
   echo '<br>查看当前连接状态:<br>';
   var_dump($qrs);

   if ($qrs[0]['Value']) {
   	# code...
   	echo '<br>当前为加密连接<br>';
   	echo "<br>当前连接类型：".$qrs[0]['Value'];
   }
   
    // 获取数据库连接属性
    /*
    $attributes = array(
	    "AUTOCOMMIT", "ERRMODE", "CASE", "CLIENT_VERSION", "dbhECTION_STATUS",
	    "ORACLE_NULLS", "PERSISTENT", "PREFETCH", "SERVER_INFO", "SERVER_VERSION",
	    "TIMEOUT"
	);

	foreach ($attributes as $val) {
	    echo "PDO::ATTR_$val: ";
	    echo $dbh->getAttribute(constant("PDO::ATTR_$val")) . "\n";
	}
	*/
    
} catch (PDOException $e) {
    echo 'dbhection failed: ' . $e->getMessage();
}
?>