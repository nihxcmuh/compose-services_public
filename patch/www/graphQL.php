<?php
if (!isset($_SERVER["HTTP_COOKIE"])){
 echo "error\n";
 exit();
}
$HTTP_COOKIE=$_SERVER["HTTP_COOKIE"];
$url = "https://google-gen3.biobank.org.tw/api/v0/submission/graphql/";
//$json='{"query":"{program {name\n    projects {\n      project_id\n      name\n      experiments {\n        submitter_id\n        cases {\n          submitter_id\n          id\n          samples {\n            id\n            submitter_id\n            slides {\n              id\n              submitter_id\n              slide_counts {\n                id\n                submitter_id\n              }\n              slide_images {\n                id\n                submitter_id\n              }\n            }\n          }\n        }\n      }\n    }\n  }\n}\n","variables":null}';
$json='{"query":"{ case{ submitter_id samples{ submitter_id slides{ submitter_id slide_images{ submitter_id file_name } } } } }"}';

//post_data($url,$json,$HTTP_COOKIE);
abc();
function post_data($url,$json,$HTTP_COOKIE){
 $cmd="curl '".$url."' \
 -H 'Accept: application/json' \
 -H 'Content-Type: application/json' \
 -H 'Cookie: ".$HTTP_COOKIE."' \
 --data-raw '".$json."' \
 --compressed        
";
 
 echo "<pre>";
 //echo $json."\n";
 //echo $cmd."\n";
 $json=shell_exec($cmd);
 $arr=json_decode($json, true);
 print_r($arr);
}

function abc(){
curl 'https://google-gen3.biobank.org.tw/guppy/graphql' \
  -H 'Accept: application/json' \
  -H 'Accept-Language: zh-TW,zh;q=0.9,en-US;q=0.8,en;q=0.7,zh-CN;q=0.6' \
  -H 'Connection: keep-alive' \
  -H 'Content-Type: application/json' \
  -H 'Cookie: _ga=GA1.3.2062287654.1645285323; __gads=ID=ef1242aaa7c33e6c-222b1d54f3d100fb:T=1649881980:RT=1649881980:S=ALNI_Mb1Yqi7ohAdaYfB9HAdqCcdjOp7XQ; _gid=GA1.3.2048304303.1652584935; _gat=1; access_token=eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6ImZlbmNlX2tleV8yMDIyLTA1LTExVDE0OjE4OjA2WiJ9.eyJwdXIiOiJhY2Nlc3MiLCJzdWIiOiIxIiwiaXNzIjoiaHR0cHM6Ly9nZW43LmJpb2Jhbmsub3JnLnR3L3VzZXIiLCJhdWQiOlsiaHR0cHM6Ly9nZW43LmJpb2Jhbmsub3JnLnR3L3VzZXIiLCJvcGVuaWQiLCJ1c2VyIiwiY3JlZGVudGlhbHMiLCJkYXRhIiwiYWRtaW4iLCJnb29nbGVfY3JlZGVudGlhbHMiLCJnb29nbGVfc2VydmljZV9hY2NvdW50IiwiZ29vZ2xlX2xpbmsiLCJnYTRnaF9wYXNzcG9ydF92MSJdLCJpYXQiOjE2NTI4MDIzODQsImV4cCI6MTY1MjgwMzU4NCwianRpIjoiNDc0ODRmZDMtNjE4Mi00YmNhLTliNjUtZWY5MWU5OGU4ODQzIiwic2NvcGUiOlsib3BlbmlkIiwidXNlciIsImNyZWRlbnRpYWxzIiwiZGF0YSIsImFkbWluIiwiZ29vZ2xlX2NyZWRlbnRpYWxzIiwiZ29vZ2xlX3NlcnZpY2VfYWNjb3VudCIsImdvb2dsZV9saW5rIiwiZ2E0Z2hfcGFzc3BvcnRfdjEiXSwiY29udGV4dCI6eyJ1c2VyIjp7Im5hbWUiOiJzdW1tZXJoaWxsMDAxQGdtYWlsLmNvbSIsImlzX2FkbWluIjpmYWxzZSwiZ29vZ2xlIjp7InByb3h5X2dyb3VwIjpudWxsfX19LCJhenAiOiIifQ.BW4cy3EA7Oa1EbFr0A81l-ITKytAK9EdFKStoOGQvEe0Fn0MIVcwSvZiFAaESK5rnRfIIjbHvkEsMWjGl_leMQ-rWdrFNlDV3_Z27VWTlNtMCJaALtbAYrsQqibtt5HK4qTFI9Q1-6jmhbGl3KVh4C5hDixQlV0GBu2n9UbMAc_XlIqN-2iFYQcpJxJ15dfVYKrP-KkcqNbrVyQLCuTYfEJMACtIzgi2-O32SFNkhvAMnKawXOGHuv5TEpCmB_WyhQqDvx8p-p6D7QfqWB-TjRO2nac6DrmeiDQLke5gCg81MpnAAlKIYgXtrjM-nGPpS3fdPcDWSwk_dqNc-NziJw; fence=eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6ImZlbmNlX2tleV8yMDIyLTA1LTExVDE0OjE4OjA2WiJ9.eyJwdXIiOiJzZXNzaW9uIiwiYXVkIjpbImZlbmNlIiwiaHR0cHM6Ly9nZW43LmJpb2Jhbmsub3JnLnR3L3VzZXIiXSwic3ViIjoiMSIsImlzcyI6Imh0dHBzOi8vZ2VuNy5iaW9iYW5rLm9yZy50dy91c2VyIiwiaWF0IjoxNjUyODAyMzg2LCJleHAiOjE2NTI4MDQxODYsImp0aSI6ImJkYTBiYTgxLWIwY2EtNDg1NC1iN2NmLTQ1ZTg4YTA5ZjcwYiIsImNvbnRleHQiOnsic2Vzc2lvbl9zdGFydGVkIjoxNjUyODAyMzgxLCJyZWRpcmVjdCI6Imh0dHBzOi8vZ2VuNy5iaW9iYW5rLm9yZy50dy9xdWVyeSIsInVzZXJuYW1lIjoic3VtbWVyaGlsbDAwMUBnbWFpbC5jb20iLCJ1c2VyX2lkIjoiMSIsInByb3ZpZGVyIjoiZ29vZ2xlIn19.s1ZxqFNRbmYVvfXmxiM1XoUtknV6gGTMgrmW8Sshf1M_ZkD1Uy0RPKWlzyIWxiStVXAPi1WkwE4al5lnQPbrG9tlr7T1vy7xRYAHEj6yOR3uz0T5NmJCcTqAhZjkD9nMD25EwK_pYFiCQY6iaaijpHnUvNMrm8UhFggg3bNNIMxRTqevpdOf99xyBmn90vtTlPPqYtWUZ4V6wwQRICMOkzqQlsaV0xWxGmVElmI4rMLBDMGCXMdrmmqCG6Nm27_QMCOy3muu6C6NKSs8ESi4OE88heH8tUDFMJeigshxisRmWuKgMe2SACy3lXUL2CWz8rspNoR0JrhGxqOEtKY0aQ; csrftoken=ff96d43d8014b02ef8f4b92c0e518bdf29750.0682022-05-17T15:46:27+00:00' \
  -H 'Origin: https://google-gen3.biobank.org.tw' \
  -H 'Referer: https://google-gen3.biobank.org.tw/query' \
  -H 'Sec-Fetch-Dest: empty' \
  -H 'Sec-Fetch-Mode: cors' \
  -H 'Sec-Fetch-Site: same-origin' \
  -H 'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1' \
  -H 'x-csrf-token: ' \
  --data-raw '{"query":"{\n  file {\n    _file_id\n    source_node\n    auth_resource_path\n    data_format\n    data_type\n    file_name\n    file_size\n    md5sum\n    object_id\n    project_id\n    state\n  }\n}\n","variables":null}' \
  --compressed	
	
	
$cmd="curl 'https://google-gen3.biobank.org.tw/guppy/graphql' \
  -H 'Accept: application/json' \
  -H 'Accept-Language: zh-TW,zh;q=0.9,en-US;q=0.8,en;q=0.7,zh-CN;q=0.6' \
  -H 'Connection: keep-alive' \
  -H 'Content-Type: application/json' \
  -H 'Cookie: _ga=GA1.3.2062287654.1645285323; __gads=ID=ef1242aaa7c33e6c-222b1d54f3d100fb:T=1649881980:RT=1649881980:S=ALNI_Mb1Yqi7ohAdaYfB9HAdqCcdjOp7XQ; _gid=GA1.3.2048304303.1652584935; _gat=1; access_token=eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6ImZlbmNlX2tleV8yMDIyLTA1LTExVDE0OjE4OjA2WiJ9.eyJwdXIiOiJhY2Nlc3MiLCJzdWIiOiIxIiwiaXNzIjoiaHR0cHM6Ly9nZW43LmJpb2Jhbmsub3JnLnR3L3VzZXIiLCJhdWQiOlsiaHR0cHM6Ly9nZW43LmJpb2Jhbmsub3JnLnR3L3VzZXIiLCJvcGVuaWQiLCJ1c2VyIiwiY3JlZGVudGlhbHMiLCJkYXRhIiwiYWRtaW4iLCJnb29nbGVfY3JlZGVudGlhbHMiLCJnb29nbGVfc2VydmljZV9hY2NvdW50IiwiZ29vZ2xlX2xpbmsiLCJnYTRnaF9wYXNzcG9ydF92MSJdLCJpYXQiOjE2NTI4MDIzODQsImV4cCI6MTY1MjgwMzU4NCwianRpIjoiNDc0ODRmZDMtNjE4Mi00YmNhLTliNjUtZWY5MWU5OGU4ODQzIiwic2NvcGUiOlsib3BlbmlkIiwidXNlciIsImNyZWRlbnRpYWxzIiwiZGF0YSIsImFkbWluIiwiZ29vZ2xlX2NyZWRlbnRpYWxzIiwiZ29vZ2xlX3NlcnZpY2VfYWNjb3VudCIsImdvb2dsZV9saW5rIiwiZ2E0Z2hfcGFzc3BvcnRfdjEiXSwiY29udGV4dCI6eyJ1c2VyIjp7Im5hbWUiOiJzdW1tZXJoaWxsMDAxQGdtYWlsLmNvbSIsImlzX2FkbWluIjpmYWxzZSwiZ29vZ2xlIjp7InByb3h5X2dyb3VwIjpudWxsfX19LCJhenAiOiIifQ.BW4cy3EA7Oa1EbFr0A81l-ITKytAK9EdFKStoOGQvEe0Fn0MIVcwSvZiFAaESK5rnRfIIjbHvkEsMWjGl_leMQ-rWdrFNlDV3_Z27VWTlNtMCJaALtbAYrsQqibtt5HK4qTFI9Q1-6jmhbGl3KVh4C5hDixQlV0GBu2n9UbMAc_XlIqN-2iFYQcpJxJ15dfVYKrP-KkcqNbrVyQLCuTYfEJMACtIzgi2-O32SFNkhvAMnKawXOGHuv5TEpCmB_WyhQqDvx8p-p6D7QfqWB-TjRO2nac6DrmeiDQLke5gCg81MpnAAlKIYgXtrjM-nGPpS3fdPcDWSwk_dqNc-NziJw; fence=eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6ImZlbmNlX2tleV8yMDIyLTA1LTExVDE0OjE4OjA2WiJ9.eyJwdXIiOiJzZXNzaW9uIiwiYXVkIjpbImZlbmNlIiwiaHR0cHM6Ly9nZW43LmJpb2Jhbmsub3JnLnR3L3VzZXIiXSwic3ViIjoiMSIsImlzcyI6Imh0dHBzOi8vZ2VuNy5iaW9iYW5rLm9yZy50dy91c2VyIiwiaWF0IjoxNjUyODAyMzg2LCJleHAiOjE2NTI4MDQxODYsImp0aSI6ImJkYTBiYTgxLWIwY2EtNDg1NC1iN2NmLTQ1ZTg4YTA5ZjcwYiIsImNvbnRleHQiOnsic2Vzc2lvbl9zdGFydGVkIjoxNjUyODAyMzgxLCJyZWRpcmVjdCI6Imh0dHBzOi8vZ2VuNy5iaW9iYW5rLm9yZy50dy9xdWVyeSIsInVzZXJuYW1lIjoic3VtbWVyaGlsbDAwMUBnbWFpbC5jb20iLCJ1c2VyX2lkIjoiMSIsInByb3ZpZGVyIjoiZ29vZ2xlIn19.s1ZxqFNRbmYVvfXmxiM1XoUtknV6gGTMgrmW8Sshf1M_ZkD1Uy0RPKWlzyIWxiStVXAPi1WkwE4al5lnQPbrG9tlr7T1vy7xRYAHEj6yOR3uz0T5NmJCcTqAhZjkD9nMD25EwK_pYFiCQY6iaaijpHnUvNMrm8UhFggg3bNNIMxRTqevpdOf99xyBmn90vtTlPPqYtWUZ4V6wwQRICMOkzqQlsaV0xWxGmVElmI4rMLBDMGCXMdrmmqCG6Nm27_QMCOy3muu6C6NKSs8ESi4OE88heH8tUDFMJeigshxisRmWuKgMe2SACy3lXUL2CWz8rspNoR0JrhGxqOEtKY0aQ; csrftoken=ff96d43d8014b02ef8f4b92c0e518bdf29750.0682022-05-17T15:46:27+00:00' \
  -H 'Origin: https://google-gen3.biobank.org.tw' \
  -H 'Referer: https://google-gen3.biobank.org.tw/query' \
  -H 'Sec-Fetch-Dest: empty' \
  -H 'Sec-Fetch-Mode: cors' \
  -H 'Sec-Fetch-Site: same-origin' \
  -H 'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1' \
  -H 'x-csrf-token: ' \
  --data-raw '{\"query\":\"{\n  file {\n    _file_id\n    source_node\n    auth_resource_path\n    data_format\n    data_type\n    file_name\n    file_size\n    md5sum\n    object_id\n    project_id\n    state\n  }\n}\n\",\"variables\":null}' \
  --compressed";
 // echo $cmd."\n";
 $json=shell_exec($cmd);
 echo $json;
 $arr=json_decode($json, true);
 print_r($arr);
}