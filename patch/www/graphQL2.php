<?php
if (!isset($_SERVER["HTTP_COOKIE"])){
 echo "HTTP_COOKIE error\n";
 exit();
}
$HTTP_COOKIE=$_SERVER["HTTP_COOKIE"];
$url = "https://google-gen3.biobank.org.tw/api/v0/submission/graphql/";
$json_query='{ slide_image { id type project_id submitter_id data_category data_type experimental_strategy file_name file_size }}';
$record=graphQL($url,$HTTP_COOKIE,$json_query);
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">
<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" class="init">
	$(document).ready(function () {
	$('#example').DataTable();
});
</script>

<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Serial</th>
                <th>ID</th>
                <th>Type</th>
                <th>Project id</th>
                <th>Submitter id</th>
                <th>Data category</th>
                <th>Data type</th>
                <th>Experimental strategy</th>
                <th>File name</th>
                <th>File size</th>
            </tr>
        </thead>
        <tbody>
			<?=$record;?>
        </tbody>
        <tfoot>
            <tr>
                <th>Serial</th>
                <th>ID</th>
                <th>Type</th>
                <th>Project id</th>
                <th>Submitter id</th>
                <th>Data category</th>
                <th>Data type</th>
                <th>Experimental strategy</th>
                <th>File name</th>
                <th>File size</th>
            </tr>
        </tfoot>
</table>	
<?php
function graphQL($url,$HTTP_COOKIE,$json){
 $json='{"query":"'.$json.'","variables":null}';
 //$json=str_replace('\n',"",$json); $json=str_replace("\n","",$json); $json=str_replace("\n","",$json); $json=str_replace("\n","",$json); $json=str_replace("\n","",$json);
 $arr=post_data($url,$json,$HTTP_COOKIE);
 $record="";
 foreach ($arr as $key => $arr1) {
  foreach ($arr1 as $key1 => $arr2) {
   foreach ($arr2 as $key2 => $arr3) {
    $serial=$key2;
    $id=$arr3["id"];
    $type=$arr3["type"];
    $project_id=$arr3["project_id"];
    $submitter_id=$arr3["submitter_id"];
    $data_category=$arr3["data_category"];
    $data_type=$arr3["data_type"];
    $experimental_strategy=$arr3["experimental_strategy"];
    $file_name=$arr3["file_name"];
    $file_size =$arr3["file_size"];
    $record.="<tr><td>$serial</td><td>$id</td><td>$type</td><td>$project_id</td><td>$submitter_id</td><td>$data_category</td><td>$data_type</td><td>$experimental_strategy</td><td>$file_name</td><td>$file_size</td></tr>\n";
   }
  }
 }
 return $record;
}
function post_data($url,$json,$HTTP_COOKIE){
 $cmd="curl '".$url."' \
 -H 'Accept: application/json' \
 -H 'Content-Type: application/json' \
 -H 'Cookie: ".$HTTP_COOKIE."' \
 --data-raw '".$json."' \
 --compressed        
";
 $json=shell_exec($cmd);
 $arr=json_decode($json, true);
 return $arr;
}