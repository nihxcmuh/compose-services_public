<?php
// ??????token
#$url_token = "https://google-gen3.biobank.org.tw/user/credentials/cdis/access_token";
#$key_id="f8884b37-126b-498f-b314-4487adc0f06a";
#$api_key="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6ImZlbmNlX2tleV8yMDIyLTA1LTExVDE0OjE4OjA2WiJ9.eyJwdXIiOiJhcGlfa2V5Iiwic3ViIjoiMSIsImlzcyI6Imh0dHBzOi8vZ2VuNy5iaW9iYW5rLm9yZy50dy91c2VyIiwiYXVkIjpbImh0dHBzOi8vZ2VuNy5iaW9iYW5rLm9yZy50dy91c2VyIl0sImlhdCI6MTY1MjMxNzU3MiwiZXhwIjoxNjU0OTA5NTcyLCJqdGkiOiJmODg4NGIzNy0xMjZiLTQ5OGYtYjMxNC00NDg3YWRjMGYwNmEiLCJhenAiOiIiLCJzY29wZSI6WyJvcGVuaWQiLCJnb29nbGVfY3JlZGVudGlhbHMiLCJkYXRhIiwiZ29vZ2xlX3NlcnZpY2VfYWNjb3VudCIsImdhNGdoX3Bhc3Nwb3J0X3YxIiwiZmVuY2UiLCJnb29nbGVfbGluayIsImFkbWluIiwidXNlciJdfQ.ZaezXXNR8XUa3mvOhL80S0W3AUyts7rTnEB60x_8Ai5DDutrBU6peNBu13BBKh2lhbLbhIUs7DGGr0puP41pXSCTasbvgqba-HF_GrFMhbWtNwg0I912-ojszhPy0vC5EbRSfQdNsPvMjAYc6X6nm6Ow0GRCKTfOMXSF4mARXCF69my2ZMbdeojiXmLGKPqGxKqbUTqUhp681VdmBROvzPdZpkxX0woSG9QA6BBR7t4vhBW26FmxAHn7hu4TMIOmobLr_QVxjXhpsZD8l9YQPTHdf9vF9Zm-aXJtX8lg0QkrcsTD1Y7uLp-rtcNDAp3TYNw9A0fl6B25wYv8po9UGQ";
#$token = get_token($url_token,$key_id,$api_key);
// submit
$token=$_REQUEST["access_token"];

$url_post = "https://google-gen3.biobank.org.tw/api/v0/submission/jnkns/jenkins/";
$json='[
    {
        "biomarker_signal": 86.02983998029391,
        "cell_count": 36,
        "cell_identifier": "b07b6455ee",
        "cell_type": "685d99a310",
        "ck_signal": 42.232466129508474,
        "er_localization": null,
        "frame_identifier": "25e8b9772c",
        "relative_cytokeratin_intensity": 56.14521016856724,
        "relative_er_intensity": 36.05723265397274,
        "relative_nuclear_intensity": 73.42452643693997,
        "relative_nuclear_size": 29.58906181179447,
        "run_name": "2ab0992f2a",
        "slides": {
            "submitter_id": "slide_d3642bcad2"
        },
        "submitter_id": "slide_count_16acffe700",
        "type": "slide_count"
    }
]';
//$json=str_replace("\n","",$json);
post_data($url_post,$json,$token);

function get_token($url,$key_id,$api_key){
        $data = json_encode(["key_id" => $key_id, "api_key" => $api_key]);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $tmp=curl_exec($curl);
        curl_close($curl);
        $arr=explode('"',$tmp);
        $access_token=$arr[3];
        return  $access_token;
}

function post_data($url,$json,$token){
        $cmd="curl 'https://google-gen3.biobank.org.tw/api/v0/submission/jnkns/jenkins/' \
-X 'PUT' \
-H 'Connection: keep-alive' \
-H 'sec-ch-ua: \" Not A;Brand\";v=\"99\", \"Chromium\";v=\"98\", \"Google Chrome\";v=\"98\"' \
-H 'Accept: application/json' \
-H 'Content-Type: application/json' \
-H 'x-csrf-token: ' \
-H 'sec-ch-ua-mobile: ?1' \
-H 'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Mobile Safari/537.36' \
-H 'sec-ch-ua-platform: \"Android\"' \
-H 'Origin: https://google-gen3.biobank.org.tw' \
-H 'Sec-Fetch-Site: same-origin' \
-H 'Sec-Fetch-Mode: cors' \
-H 'Sec-Fetch-Dest: empty' \
-H 'Referer: https://google-gen3.biobank.org.tw/jnkns-jenkins' \
-H 'Accept-Language: zh-TW,zh;q=0.9,en-US;q=0.8,en;q=0.7,zh-CN;q=0.6' \
-H 'Cookie: _ga=GA1.3.2062287654.1645285323; _gid=GA1.3.1321658377.1645285323; access_token=".$token."' \
--data-raw '".$json."' \
--compressed
";
 echo $cmd;
 exec($cmd);
}