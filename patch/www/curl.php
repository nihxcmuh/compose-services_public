<?
/*
# get 
$url = 'https://covid-19.nchc.org.tw';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch); // 已經獲取到內容，沒有輸出到頁面上。
curl_close($ch);


$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_TIMEOUT, 500);
// 為保證第三方伺服器與微信伺服器之間數據傳輸的安全性，所有微信接口采用https方式調用，必須使用下面2行代碼打開ssl安全校驗。
// 如果在部署過程中代碼在此處驗證失敗，請到 http://curl.haxx.se/ca/cacert.pem 下載新的證書判別文件。
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl,CURLOPT_CAINFO,dirname(__FILE__).'/cacert.pem');//這是根據http://curl.haxx.se/ca/cacert.pem 下載的證書，添加這句話之後就運行正常瞭
$res = curl_exec($curl);
curl_close($curl);
print($res);

*/

/*
$url = 'https://covid-19.nchc.org.tw';
echo file_get_contents($url);
*/

/*
$url = 'https://covid-19.nchc.org.tw'; 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
//curl_setopt($curl,CURLOPT_CAINFO,dirname(__FILE__).'/cacert.pem');//這是根據http://curl.haxx.se/ca/cacert.pem 下載的證書，添加這句話之後就運行正常瞭
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$output = curl_exec($ch);
curl_close($ch);
echo $output;
*/

## post
/*
$url = 'https://google-gen3.biobank.org.tw/api/v0/submission/graphql/';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_COOKIE, '_ga=GA1.3.2062287654.1645285323; __gads=ID=ef1242aaa7c33e6c-222b1d54f3d100fb:T=1649881980:RT=1649881980:S=ALNI_Mb1Yqi7ohAdaYfB9HAdqCcdjOp7XQ; _gid=GA1.3.2048304303.1652584935; _gat=1; fence=eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6ImZlbmNlX2tleV8yMDIyLTA1LTExVDE0OjE4OjA2WiJ9.eyJwdXIiOiJzZXNzaW9uIiwiYXVkIjpbImZlbmNlIiwiaHR0cHM6Ly9nZW43LmJpb2Jhbmsub3JnLnR3L3VzZXIiXSwic3ViIjoiMSIsImlzcyI6Imh0dHBzOi8vZ2VuNy5iaW9iYW5rLm9yZy50dy91c2VyIiwiaWF0IjoxNjUyODM3MzU3LCJleHAiOjE2NTI4MzkxNTcsImp0aSI6IjY2ZWM2M2Y4LWEyNGMtNDI3MC1hNmIwLTZiZGM4ZjQ0ZmM4NiIsImNvbnRleHQiOnsic2Vzc2lvbl9zdGFydGVkIjoxNjUyODM2MTUzLCJyZWRpcmVjdCI6Imh0dHBzOi8vZ2VuNy5iaW9iYW5rLm9yZy50dy8iLCJ1c2VybmFtZSI6InN1bW1lcmhpbGwwMDFAZ21haWwuY29tIiwidXNlcl9pZCI6IjEiLCJwcm92aWRlciI6Imdvb2dsZSJ9fQ.bWJKJprzhVPKSVFWiGwLxa_DbpqTrS7UjphJurN-g5hwzd_a9Ak8NpnQAiWZnzOqKq1mO0juPZocRduucVGOvr9gvUpc_QqHKm0_JppBI7GjM8m-VjJIkgE38MSAgMWmMFFIcKaceBGUud8QEzRcpPn8zBaqTD5bRRq5I8v_aiEBp80yGA_MSLiDGlHzX1klijM6vBqaDAaQDPxdkWAIrWFEX8nCCXwEuAVezKTRG46amZk9HdT49N7tFrmESzlo-paDVczA9_HoEbJOh0FsOB5A2OiedbkbLVfb0-pRNB007QLYlAE7ZnX3L1LoClSWsF_s14sm0qmqPUQ-4TAHZw; access_token=eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6ImZlbmNlX2tleV8yMDIyLTA1LTExVDE0OjE4OjA2WiJ9.eyJwdXIiOiJhY2Nlc3MiLCJzdWIiOiIxIiwiaXNzIjoiaHR0cHM6Ly9nZW43LmJpb2Jhbmsub3JnLnR3L3VzZXIiLCJhdWQiOlsiaHR0cHM6Ly9nZW43LmJpb2Jhbmsub3JnLnR3L3VzZXIiLCJvcGVuaWQiLCJ1c2VyIiwiY3JlZGVudGlhbHMiLCJkYXRhIiwiYWRtaW4iLCJnb29nbGVfY3JlZGVudGlhbHMiLCJnb29nbGVfc2VydmljZV9hY2NvdW50IiwiZ29vZ2xlX2xpbmsiLCJnYTRnaF9wYXNzcG9ydF92MSJdLCJpYXQiOjE2NTI4MzczNTcsImV4cCI6MTY1MjgzODU1NywianRpIjoiZGVkMTZlYTAtZDc1ZS00MGFhLTlmNWQtMmVjMzE4NzQyMmMxIiwic2NvcGUiOlsib3BlbmlkIiwidXNlciIsImNyZWRlbnRpYWxzIiwiZGF0YSIsImFkbWluIiwiZ29vZ2xlX2NyZWRlbnRpYWxzIiwiZ29vZ2xlX3NlcnZpY2VfYWNjb3VudCIsImdvb2dsZV9saW5rIiwiZ2E0Z2hfcGFzc3BvcnRfdjEiXSwiY29udGV4dCI6eyJ1c2VyIjp7Im5hbWUiOiJzdW1tZXJoaWxsMDAxQGdtYWlsLmNvbSIsImlzX2FkbWluIjpmYWxzZSwiZ29vZ2xlIjp7InByb3h5X2dyb3VwIjpudWxsfX19LCJhenAiOiIifQ.pLf4h3BjHje4Rinoqd1V0Bm-avzHkgCcdkRBALEiZY02wjEvjso743x9wb2I6F7tQocDkEcUSpzTvZtL30joRHWT22-ZURE5AJclMtrYk4zNxubniM1PMA1uBObKkOhNgBmtTj0pfXMwmaRXYR9kn40XINStBjsKL_e8yzZ_9nwUkh50uwlyiV43rG7hAvlLSXv3RxeJ4MmJlb8zUmjRb2Hm2CsvGzx5x1CjGJBTOD5KCzYcCvnos2gp05rDyEOMl1s128XXE2QyJq8XlJEHARp1iS5QyvZHOfcEb2H9CT2TOEwZU_fr_06n41fo5y2M9rlred8ZlcNonxTwe-bAQg; csrftoken=6d910699f29515b385218694f0ff067d30720.0802022-05-18T01:29:17+00:00');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0');
#curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array("CK"=>"covid-19@nchc.org.tw", "querydata"=>"4048"))); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);

$output = curl_exec($ch); 
curl_close($ch);
echo $output;
?>
curl 'https://google-gen3.biobank.org.tw/api/v0/submission/graphql/' \
  -H 'Accept: application/json' \
  -H 'Accept-Language: zh-TW,zh;q=0.9,en-US;q=0.8,en;q=0.7,zh-CN;q=0.6' \
  -H 'Connection: keep-alive' \
  -H 'Content-Type: application/json' \
  -H 'Cookie: 
  
  ' \
  -H 'Origin: https://google-gen3.biobank.org.tw' \
  -H 'Referer: https://google-gen3.biobank.org.tw/query' \
  -H 'Sec-Fetch-Dest: empty' \
  -H 'Sec-Fetch-Mode: cors' \
  -H 'Sec-Fetch-Site: same-origin' \
  -H 'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1' \
  -H 'x-csrf-token: ' \
  --data-raw '{"query":"{slide_image {\n  id\n}}","variables":null}' \
  --compressed

*/

$ch = curl_init();
$headers  = [
            'x-api-key: XXXXXX',
            'Content-Type: text/plain'
        ];
$postData = [
    'data1' => 'value1',
    'data2' => 'value2'
];
curl_setopt($ch, CURLOPT_URL,"XXXXXX");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));           
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result     = curl_exec ($ch);
$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


fetch("https://google-gen3.biobank.org.tw/api/v0/submission/graphql/", {
  "headers": {
    "accept": "application/json",
    "accept-language": "zh-TW,zh;q=0.9,en-US;q=0.8,en;q=0.7,zh-CN;q=0.6",
    "content-type": "application/json",
    "sec-fetch-dest": "empty",
    "sec-fetch-mode": "cors",
    "sec-fetch-site": "same-origin",
    "x-csrf-token": ""
  },
  "referrer": "https://google-gen3.biobank.org.tw/query",
  "referrerPolicy": "strict-origin-when-cross-origin",
  "body": "{\"query\":\"{slide_image {\\n  id\\n}}\",\"variables\":null}",
  "method": "POST",
  "mode": "cors",
  "credentials": "include"
});


curl 'https://google-gen3.biobank.org.tw/api/v0/submission/graphql/' \
  -H 'Accept: application/json' \
  -H 'Accept-Language: zh-TW,zh;q=0.9,en-US;q=0.8,en;q=0.7,zh-CN;q=0.6' \
  -H 'Connection: keep-alive' \
  -H 'Content-Type: application/json' \
  -H 'Cookie: _ga=GA1.3.2062287654.1645285323; __gads=ID=ef1242aaa7c33e6c-222b1d54f3d100fb:T=1649881980:RT=1649881980:S=ALNI_Mb1Yqi7ohAdaYfB9HAdqCcdjOp7XQ; _gid=GA1.3.2048304303.1652584935; _gat=1; fence=eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6ImZlbmNlX2tleV8yMDIyLTA1LTExVDE0OjE4OjA2WiJ9.eyJwdXIiOiJzZXNzaW9uIiwiYXVkIjpbImZlbmNlIiwiaHR0cHM6Ly9nZW43LmJpb2Jhbmsub3JnLnR3L3VzZXIiXSwic3ViIjoiMSIsImlzcyI6Imh0dHBzOi8vZ2VuNy5iaW9iYW5rLm9yZy50dy91c2VyIiwiaWF0IjoxNjUyODM3MzU3LCJleHAiOjE2NTI4MzkxNTcsImp0aSI6IjY2ZWM2M2Y4LWEyNGMtNDI3MC1hNmIwLTZiZGM4ZjQ0ZmM4NiIsImNvbnRleHQiOnsic2Vzc2lvbl9zdGFydGVkIjoxNjUyODM2MTUzLCJyZWRpcmVjdCI6Imh0dHBzOi8vZ2VuNy5iaW9iYW5rLm9yZy50dy8iLCJ1c2VybmFtZSI6InN1bW1lcmhpbGwwMDFAZ21haWwuY29tIiwidXNlcl9pZCI6IjEiLCJwcm92aWRlciI6Imdvb2dsZSJ9fQ.bWJKJprzhVPKSVFWiGwLxa_DbpqTrS7UjphJurN-g5hwzd_a9Ak8NpnQAiWZnzOqKq1mO0juPZocRduucVGOvr9gvUpc_QqHKm0_JppBI7GjM8m-VjJIkgE38MSAgMWmMFFIcKaceBGUud8QEzRcpPn8zBaqTD5bRRq5I8v_aiEBp80yGA_MSLiDGlHzX1klijM6vBqaDAaQDPxdkWAIrWFEX8nCCXwEuAVezKTRG46amZk9HdT49N7tFrmESzlo-paDVczA9_HoEbJOh0FsOB5A2OiedbkbLVfb0-pRNB007QLYlAE7ZnX3L1LoClSWsF_s14sm0qmqPUQ-4TAHZw; access_token=eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6ImZlbmNlX2tleV8yMDIyLTA1LTExVDE0OjE4OjA2WiJ9.eyJwdXIiOiJhY2Nlc3MiLCJzdWIiOiIxIiwiaXNzIjoiaHR0cHM6Ly9nZW43LmJpb2Jhbmsub3JnLnR3L3VzZXIiLCJhdWQiOlsiaHR0cHM6Ly9nZW43LmJpb2Jhbmsub3JnLnR3L3VzZXIiLCJvcGVuaWQiLCJ1c2VyIiwiY3JlZGVudGlhbHMiLCJkYXRhIiwiYWRtaW4iLCJnb29nbGVfY3JlZGVudGlhbHMiLCJnb29nbGVfc2VydmljZV9hY2NvdW50IiwiZ29vZ2xlX2xpbmsiLCJnYTRnaF9wYXNzcG9ydF92MSJdLCJpYXQiOjE2NTI4MzczNTcsImV4cCI6MTY1MjgzODU1NywianRpIjoiZGVkMTZlYTAtZDc1ZS00MGFhLTlmNWQtMmVjMzE4NzQyMmMxIiwic2NvcGUiOlsib3BlbmlkIiwidXNlciIsImNyZWRlbnRpYWxzIiwiZGF0YSIsImFkbWluIiwiZ29vZ2xlX2NyZWRlbnRpYWxzIiwiZ29vZ2xlX3NlcnZpY2VfYWNjb3VudCIsImdvb2dsZV9saW5rIiwiZ2E0Z2hfcGFzc3BvcnRfdjEiXSwiY29udGV4dCI6eyJ1c2VyIjp7Im5hbWUiOiJzdW1tZXJoaWxsMDAxQGdtYWlsLmNvbSIsImlzX2FkbWluIjpmYWxzZSwiZ29vZ2xlIjp7InByb3h5X2dyb3VwIjpudWxsfX19LCJhenAiOiIifQ.pLf4h3BjHje4Rinoqd1V0Bm-avzHkgCcdkRBALEiZY02wjEvjso743x9wb2I6F7tQocDkEcUSpzTvZtL30joRHWT22-ZURE5AJclMtrYk4zNxubniM1PMA1uBObKkOhNgBmtTj0pfXMwmaRXYR9kn40XINStBjsKL_e8yzZ_9nwUkh50uwlyiV43rG7hAvlLSXv3RxeJ4MmJlb8zUmjRb2Hm2CsvGzx5x1CjGJBTOD5KCzYcCvnos2gp05rDyEOMl1s128XXE2QyJq8XlJEHARp1iS5QyvZHOfcEb2H9CT2TOEwZU_fr_06n41fo5y2M9rlred8ZlcNonxTwe-bAQg; csrftoken=6d910699f29515b385218694f0ff067d30720.0802022-05-18T01:29:17+00:00' \
  -H 'Origin: https://google-gen3.biobank.org.tw' \
  -H 'Referer: https://google-gen3.biobank.org.tw/query' \
  -H 'Sec-Fetch-Dest: empty' \
  -H 'Sec-Fetch-Mode: cors' \
  -H 'Sec-Fetch-Site: same-origin' \
  -H 'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1' \
  -H 'x-csrf-token: ' \
  --data-raw '{"query":"{slide_image {\n  id\n}}","variables":null}' \
  --compressed