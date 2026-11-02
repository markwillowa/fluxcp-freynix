<?php
function generateServersConfig($host, $port, $user, $pass, $db, $serverName = 'Freynix Ragnarok Online') {
    $portLine = !empty($port) && $port != 3306 ? "'Port'       => " . (int)$port . ",\n\t\t\t" : "";
    $code = <<<PHP
<?php
return array(
	// Ragnarok Online Server Configuration
	array(
		'ServerName'     => '{$serverName}',
		// Global database configuration (excludes logs database configuration).
		'DbConfig'       => array(
			{$portLine}'Convert'    => 'utf8',
			'Hostname'   => '{$host}',
			'Username'   => '{$user}',
			'Password'   => '{$pass}',
			'Database'   => '{$db}',
			'Persistent' => true,
			'Timezone'   => null
		),
		// Logs database configuration.
		'LogsDbConfig'   => array(
			{$portLine}'Convert'    => 'utf8',
			'Hostname'   => '{$host}',
			'Username'   => '{$user}',
			'Password'   => '{$pass}',
			'Database'   => '{$db}',
			'Persistent' => true,
			'Timezone'   => null
		),
		// Web database configuration.
		'WebDbConfig'    => array(
			{$portLine}'Hostname'   => '{$host}',
			'Username'   => '{$user}',
			'Password'   => '{$pass}',
			'Database'   => '{$db}',
			'Persistent' => true
		),
		// Login server configuration.
		'LoginServer'    => array(
			'Address'  => '{$host}',
			'Port'     => 6900,
			'UseMD5'   => false,
			'NoCase'   => true,
			'GroupID'  => 0
		),
		'CharMapServers' => array(
			array(
				'ServerName'      => '{$serverName}',
				'Renewal'         => false,
				'MaxCharSlots'    => 9,
				'DateTimezone'    => null,
				'ExpRates' => array(
					'Base'        => 1000,
					'Job'         => 1000,
					'Mvp'         => 1000
				),
				'DropRates' => array(
					'DropRateCap' => 9000,
					'Common'      => 100,
					'CommonBoss'  => 100,
					'CommonMVP'   => 100,
					'CommonMin'   => 1,
					'CommonMax'   => 10000,
					'Heal'        => 100,
					'HealBoss'    => 100,
					'HealMVP'     => 100,
					'HealMin'     => 1,
					'HealMax'     => 10000,
					'Useable'     => 100,
					'UseableBoss' => 100,
					'UseableMVP'  => 100,
					'UseableMin'  => 1,
					'UseableMax'  => 10000,
					'Equip'       => 100,
					'EquipBoss'   => 100,
					'EquipMVP'    => 100,
					'EquipMin'    => 1,
					'EquipMax'    => 10000,
					'Card'        => 100,
					'CardBoss'    => 100,
					'CardMVP'     => 100,
					'CardMin'     => 1,
					'CardMax'     => 10000,
					'MvpItem'     => 100,
					'MvpItemMin'  => 1,
					'MvpItemMax'  => 10000
				)
			)
		)
	)
);
PHP;
    return $code;
}

$sample = generateServersConfig('127.0.0.1', 3306, 'admin', 'Maki0913$', 'freynix', 'Freynix Ragnarok Online');
echo "Sample generated length: " . strlen($sample) . "\n";
file_put_contents(__DIR__ . '/test_servers_output.php', $sample);
$loaded = require __DIR__ . '/test_servers_output.php';
echo "Loaded successfully! ServerName: " . $loaded[0]['ServerName'] . ", DB: " . $loaded[0]['DbConfig']['Database'] . "\n";
