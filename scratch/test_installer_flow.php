<?php
$cookieFile = __DIR__ . '/installer_cookie.txt';
if (file_exists($cookieFile)) @unlink($cookieFile);

// Step 1: Request ?module=install
$ch = curl_init('http://127.0.0.1/?module=install');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
$html = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Step 1 (Unauth Installer) HTTP Code: $code\n";
echo "Has Requirements Check: " . (strpos($html, 'SYSTEM ENVIRONMENT VERIFICATION') !== false ? 'YES' : 'NO') . "\n";
echo "Has Password Input: " . (strpos($html, 'installer_password') !== false ? 'YES' : 'NO') . "\n";

// Step 2: Authenticate with installer password
$pw = 'secretpassword';

$ch = curl_init('http://127.0.0.1/?module=install');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'installer_password' => $pw
]));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$htmlAuth = curl_exec($ch);
$codeAuth = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "\nStep 2 (Auth Installer) HTTP Code: $codeAuth\n";
echo "Has MySQL Config Card: " . (strpos($htmlAuth, 'MYSQL DATABASE CREDENTIALS (CONFIG/SERVERS.PHP)') !== false ? 'YES' : 'NO') . "\n";
echo "Has Server Brand Card: " . (strpos($htmlAuth, 'SERVER BRAND &amp; IDENTITY') !== false ? 'YES' : 'NO') . "\n";
echo "Has Gameplay Mechanics Card: " . (strpos($htmlAuth, 'GAMEPLAY MECHANICS &amp; RATES') !== false ? 'YES' : 'NO') . "\n";
echo "Has Hero Banner Card: " . (strpos($htmlAuth, 'HOMEPAGE HERO SECTION') !== false ? 'YES' : 'NO') . "\n";
echo "Has Client Downloads Card: " . (strpos($htmlAuth, 'CLIENT DOWNLOAD PACKAGES') !== false ? 'YES' : 'NO') . "\n";
echo "Has Community Links Card: " . (strpos($htmlAuth, 'COMMUNITY &amp; SUPPORT CHANNELS') !== false ? 'YES' : 'NO') . "\n";
echo "Has Save & Launch Button: " . (strpos($htmlAuth, 'Save Configuration &amp; Launch Website') !== false ? 'YES' : 'NO') . "\n";

file_put_contents(__DIR__ . '/installer_auth_output.html', $htmlAuth);

// Step 3: Test Reinstall page with Admin cookie
$adminCookie = __DIR__ . '/cookie.txt';
$ch = curl_init('http://127.0.0.1/?module=install&action=reinstall');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, $adminCookie);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$htmlReinstall = curl_exec($ch);
$codeReinstall = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "\nStep 3 (Reinstall Page with Admin Session) HTTP Code: $codeReinstall\n";
echo "Has Reinstall Title: " . (strpos($htmlReinstall, 'RE-INSTALL &amp; DATABASE RESET') !== false ? 'YES' : 'NO') . "\n";
echo "Has Reset Button: " . (strpos($htmlReinstall, 'Reset &amp; Launch Installation Wizard') !== false ? 'YES' : 'NO') . "\n";

file_put_contents(__DIR__ . '/reinstall_output.html', $htmlReinstall);
