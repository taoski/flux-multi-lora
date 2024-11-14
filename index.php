<?php

// Enter your CivitAI and Replicate.com API keys here

$civitai = "xxxxxxxx";
$replicateAPI = "xxxxxxxx";

// Enter your array of LoRA to use.
// The can either be HF format such as User/LoraName
// Or the CivitAI URL
// Add a * followed by the text you want to show in the drop down selection list.
// An HTML select will be created for each item in the array, meaning you can pick as many LoRA as you have included, if you wish.

$lora = array(
"",
"User/LoraName*Lora Name",
"https://civitai.com/api/download/models/802810?type=Model&format=SafeTensor"."&token=".$civitai."*David BOWIE",
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AI2 Test Page</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body style="padding:10%;">

<form method="POST" action="#">
<div class="rendered-form">     
<div class="formbuilder-text form-group field-prompt">         
<label for="prompt" class="formbuilder-text-label">Prompt</label>         
<textarea class="form-control" name="prompt" access="false" id="prompt"><?php echo $_POST['prompt']; ?></textarea>     </div>     <div class="formbuilder-number form-group field-num">         <label for="num" class="formbuilder-number-label">Num</label>         <input type="number" class="form-control" name="num" access="false" value="4" id="num">     </div>  

<?php
$i = 1;
foreach($lora as $item)
{
   
echo '<div class="formbuilder-select form-group field-lora'.$i.'"><label for="lora'.$i.'" class="formbuilder-select-label">Lora'.$i.'</label><select class="form-control" name="lora'.$i.'" id="lora'.$i.'">';
foreach($lora as $items)
{
	$t = explode("*",$items);
echo '<option value="'.$t[0].'"';
if($_POST['lora'.$i] == $t[0]){echo ' selected';}
echo '>'.$t[1].'</option>';
}
echo '</select>';
$i++;
}
?>

<div class="formbuilder-text form-group field-weight">         
<label for="prompt" class="formbuilder-text-label">One off LoRA - copy and paste the LoRA download URL from CivitAI.</label>         
<input type="text" class="form-control" name="one" access="false" id="one" value="<?php echo $_POST['one']; ?>"></div></div>

<div class="formbuilder-text form-group field-weight">         
<label for="prompt" class="formbuilder-text-label">LoRA Weights - one per LoRA in CSV format - eg: 1,0.8,1</label>         
<input type="text" class="form-control" name="weight" access="false" id="weight" value="<?php echo $_POST['weight']; ?>">     </div>

<div class="formbuilder-text form-group field-weight">         
<label for="prompt" class="formbuilder-text-label">Seed (leave blank for a random seed)</label>         
<input type="text" class="form-control" name="seed" access="false" id="seed" value="<?php echo $_POST['seed']; ?>"></div></div>

 </div>     <div class="formbuilder-text form-group field-aspect">         <label for="aspect" class="formbuilder-text-label">Aspect Ratio</label>         <select class="form-control" name="aspect" access="false" id="aspect" >
<option value="1:1"<?php if($_POST['aspect'] == "1:1"){echo " selected";} ?>>1:1</option>
<option value="16:9"<?php if($_POST['aspect'] == "16:9"){echo " selected";} ?>>16:9</option>
<option value="21:9"<?php if($_POST['aspect'] == "21:9"){echo " selected";} ?>>21:9</option>
<option value="3:2"<?php if($_POST['aspect'] == "3:2"){echo " selected";} ?>>3:2</option>
<option value="2:3"<?php if($_POST['aspect'] == "2:3"){echo " selected";} ?>>2:3</option>
<option value="4:5"<?php if($_POST['aspect'] == "4:5"){echo " selected";} ?>>4:5</option>
<option value="5:4"<?php if($_POST['aspect'] == "5:4"){echo " selected";} ?>>5:4</option>
<option value="3:4"<?php if($_POST['aspect'] == "3:4"){echo " selected";} ?>>3:4</option>
<option value="4:3"<?php if($_POST['aspect'] == "4:3"){echo " selected";} ?>>4:3</option>
<option value="9:16"<?php if($_POST['aspect'] == "9:16"){echo " selected";} ?>>9:16</option>
<option value="9:21"<?php if($_POST['aspect'] == "9:21"){echo " selected";} ?>>9:21</option>
</select></br>
<input type="submit">  </div> </form></div>

</body>
</html>

<?php

if(!$_POST){die("No form data");}

$ch = curl_init();

$lorause = array();
if($_POST['lora1']){$lorause[] = $_POST['lora1'];}
if($_POST['lora2']){$lorause[] = $_POST['lora2'];}
if($_POST['lora3']){$lorause[] = $_POST['lora3'];}
if($_POST['lora4']){$lorause[] = $_POST['lora4'];}
if($_POST['lora5']){$lorause[] = $_POST['lora5'];}
if($_POST['lora6']){$lorause[] = $_POST['lora6'];}
if($_POST['lora7']){$lorause[] = $_POST['lora7'];}
if($_POST['lora8']){$lorause[] = $_POST['lora8'];}
if($_POST['lora9']){$lorause[] = $_POST['lora9'];}
if($_POST['one']){$lorause[] = $_POST['one']."&token=".$civitai;}

if($_POST['seed']){$seed = intval($_POST['seed']);}
if(!$_POST['seed']){$seed = intval(rand(1,9999999999));}

$lorascale = explode(",",$_POST['weight']);
foreach($lorascale as $loraitem)
{
	$lorascales[] = floatval($loraitem);
}

curl_setopt($ch, CURLOPT_URL, 'https://api.replicate.com/v1/predictions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$data = array(
   'version' => '2389224e115448d9a77c07d7d45672b3f0aa45acacf1c5bcf51857ac295e3aec', 
   'input' => array(
        'prompt' => $_POST['prompt'],
      "hf_loras" => $lorause,
      "lora_scales" => $lorascales,
      "num_outputs" => intval($_POST['num']),
      "aspect_ratio" => $_POST['aspect'],
      "output_format" => "png",
      "guidance_scale" => 3.5,
      "output_quality" => 80,
      "prompt_strength" => 0.7,
      "num_inference_steps" => 28,
      "disable_safety_checker" => True,
	  "seed" => $seed

    )
);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
$headers = array();
$headers[] = 'Authorization: Bearer '.$replicateAPI;
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output = curl_exec($ch);

// Remove the comments below to dump the submitted form data and API return data

// var_dump($data);
// var_dump($output);

?>
