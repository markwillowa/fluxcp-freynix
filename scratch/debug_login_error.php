<?php
$ch = curl_init('https://localhost/?module=account&action=login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'server' => 'Freynix Ragnarok Online',
    'username' => 'malda009',
    'password' => 'Maki0913$'
]));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$res = curl_exec($ch);
echo "Result length: " . strlen($res) . "\n";
if (preg_match('/class="(?:message|error)[^"]*"[^>]*>(.*?)<\/p>/is', $res, $m)) {
    echo "Message: " . strip_tags($m[0]) . "\n";
} else {
    echo substr(strip_tags($res), 0, 500);
}

