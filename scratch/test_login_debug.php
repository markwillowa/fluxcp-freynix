<?php
$ch = curl_init('http://localhost/?module=account&action=login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'server' => 'Freynix Ragnarok Online',
    'username' => 'malda009',
    'password' => 'Maki0913$'
]));
curl_setopt($ch, CURLOPT_HEADER, true);
$res = curl_exec($ch);
echo $res;

