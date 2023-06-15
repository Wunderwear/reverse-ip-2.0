<?php
if (!isset($argv[1])) exit("Command : php reverse.php list.txt");
if (!is_dir('result')) {
    mkdir('result');
}
$list = file_get_contents($argv[1]);
$expld = explode("\n", $list);

foreach ($expld as $hihi) {
    $willow = trim($hihi);
    $url = "https://api.webscan.cc/query/$willow";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
        "authority: api.webscan.cc",
        "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,/;q=0.8,application/signed-exchange;v=b3;q=0.7",
        "accept-language: en-US,en;q=0.9",
        "cache-control: no-cache",
        "dnt: 1",
        "pragma: no-cache",
        "sec-ch-ua: \"Not.A/Brand\";v=\"8\", \"Chromium\";v=\"114\", \"Google Chrome\";v=\"114\"",
        "sec-ch-ua-mobile: ?0",
        "sec-ch-ua-platform: \"Windows\"",
        "sec-fetch-dest: document",
        "sec-fetch-mode: navigate",
        "sec-fetch-site: none",
        "sec-fetch-user: ?1",
        "sec-gpc: 1",
        "upgrade-insecure-requests: 1",
        "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);


    if ($gagal = curl_error($curl)) {
        echo $gagal;
    } else {
        $decoded = json_decode($resp, true);
    }
    if (is_null($decoded)) continue;
    foreach ($decoded as $value) {
        file_put_contents('result/' . $willow . '.txt', "{$value["domain"]}\n", FILE_APPEND | LOCK_EX);
        print($value["domain"] . "\n");
    }

    curl_close($curl);
}
