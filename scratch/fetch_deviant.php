<?php
$deviantUrl = 'https://www.deviantart.com/outwardsandinwards/art/Lord-Knight-Ragnarok-Online-Render-332309712';
$oembedUrl = 'https://backend.deviantart.com/oembed?url=' . urlencode($deviantUrl);

$ch = curl_init($oembedUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
$data = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Code: $code\n";
echo "Data: $data\n";

