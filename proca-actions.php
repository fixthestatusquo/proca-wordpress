<?php
/*
$username : emailid of proca account
$password : account pass
*/
$username ="Add Email ID";
$password = 'Add Password';
$auth= base64_encode("$username:$password");
$service_url = "https://api.proca.app/api"; 

$query1 = <<<'GRAPHQL'
query GetCampaigns($name:String) {
  org(name:$name) {
    campaigns {
      name
      title
      externalId
    }
  }	
}
GRAPHQL;


$query2 = <<<'GRAPHQL'
Mutation change($orgName:String!,$campaignName:String!,$title:String!) {
  upsertCampaign(orgName:$orgName,input: {
    name:$campaignName,
    title:$title,
    actionPages:[
      {name:"beeeci/counter",locale:"en",extraSupporters:632154},
    ]
  }) 
  {
    id
  }
}
GRAPHQL;

function graphql_query(string $endpoint, string $query, array $variables = [], string $operationName, string $token = null): array
{

    $headers = ['Content-Type: application/json'];
	$data= array();
    if (null !== $token) {
        $headers[] = "Authorization: Basic $token";
    }
    if (false === $data = @file_get_contents($endpoint, false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => $headers,
            'content' => json_encode(['query' => $query, 'variables' => $variables, 'operationName'=>$operationName]),
        ]
    ]))) {
        $error = error_get_last();
        throw new \ErrorException($error['message'], $error['type']);
    }
   // var_dump($data);
    return json_decode($data, true);
}

$data =graphql_query($service_url, $query2, ["campaignName"=>'test',"title"=>'test',"orgName"=>'campax'],'change',$auth);
echo '<pre>';
print_r($data);
echo '</pre>';

 ?>