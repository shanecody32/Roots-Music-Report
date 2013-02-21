<?php
/* 
 * Author: Shane Cody
 * Company: Crooked Comma Designs - crookedcomma.com
 */
class FormatHelper extends AppHelper {

    var $helpers = array('Html', 'Form');

    function date($timetochange, $format = 'band'){
		switch($format){
			case 'band':
				$out_form = "D M j, Y";
				break;
			case 'radio_start':
				$out_form = "M Y";
				break;
			case 'standard':
				$out_form = "M j, Y";
				break;
			case 'full':
				$out_form = "F j, Y";
				break;
			case 'javascript':
				$out_form = "Y, m-1, d";
				break;
			case 'chart-start':
				$out_form = "Y, m-1, d-1";
				break;
			case 'chart-end':
				$out_form = "Y, m-1, d+1";
				break;
			case 'link':
				$out_form = "F-d-Y";
				break;
			case 'mysql':
				$out_form = "Y-m-d";
				break;
		}
		return date($out_form, strtotime($timetochange));
    }

    function phone($to_format,$country){
	   $num = ereg_replace('[^0-9]', '', $to_format);

	   $code = ereg_replace('[^0-9]', '', $country['phone_code']);
	   $num = $this->remove_leading($num,$code);

	   if($country['id'] == '224' || $country['id'] == '104'){
		  return $country['phone_code'].' '.$this->format_odd($num);
	   } elseif($country['id'] == '81' || $country['id'] == '13'){
		  $num = $this->remove_leading($num,0);
	   }
	   if(!$country['phone_reg_exp'] || !$country['phone_code'] || !$country['phone_format']){
		  $country['phone_reg_exp'] = '([0-9]{3})([0-9]{3})([0-9]{4})';
		  $country['phone_format'] = '($1) $2-$3';
		  $country['phone_code'] = '1';
	   }
	   $code = ereg_replace('[^0-9]', '', $country['phone_code']);
	   $code_count = strlen($code);
	   $check = substr($to_format, 0, $code_count);
	   if($check == $code){
		  $num = substr($to_format, $code_count);
	   }
	   $num = preg_replace('/'.$country['phone_reg_exp'].'/', $country['phone_code']. ' ' . $country['phone_format'], $num);
	   return $num;
    }

    function address($to_format){
	   $address = $to_format['Country']['address_format'];
				if(!$address){
					$address = "%A %B %D %c,_%S_%P %C";
				}
	   if(!$to_format['address_2']){
		  $address = str_replace('%B ', '', $address);
	   }
	   if(!$to_format['address_3']){
		  $address = str_replace('%D ', '', $address);
	   }
	   $address = str_replace(' ', '<br />', $address);
	   $address = str_replace('_', ' ', $address);
	   $address = str_replace('%A', strtoupper($to_format['address_1']), $address);
	   $address = str_replace('%B', strtoupper($to_format['address_2']), $address);
	   $address = str_replace('%D', strtoupper($to_format['address_3']), $address);
	   $address = str_replace('%P', strtoupper($to_format['PostalCode']['code']), $address);
	   $address = str_replace('%c', strtoupper($to_format['City']['name']), $address);
	if(!empty($to_format['State']['abbrv']))
		  $address = str_replace('%S', strtoupper($to_format['State']['abbrv']), $address);
	   elseif(!empty($to_format['State']['name']))
		  $address = str_replace('%S', strtoupper($to_format['State']['name']), $address);
	   else
		  $address = str_replace('%S', '', $address);
	   $address = str_replace('%C', strtoupper($to_format['Country']['name']), $address);
	   return $address;
    }

    function address_form($to_format, $model){
	   $address = $to_format;

	   $address = str_replace(' %C', '', $address);
	   $address = str_replace('_', ' ', $address);
	   $address = str_replace(',', '', $address);
	   
	   $address = str_replace('%A', $this->Form->input($model.'.address_1', array('label'=>'Address (only first field required unless additional fields nessasary to mail in your area)')), $address);
	   $address = str_replace('%B', $this->Form->input($model.'.address_2', array('label'=>'')), $address);
	   $address = str_replace('%D', $this->Form->input($model.'.address_3', array('label'=>'')), $address);
	   $address = str_replace('%P', $this->Form->input($model.'.zip', array('label'=>'Zip or Postal Code')), $address);
	   $address = str_replace('%c', $this->Form->input($model.'.city', array('label'=>'City')), $address);
	   $address = str_replace('%S', $this->Form->input($model.'.state', array('type'=>'text', 'label'=>'State or Provence (Required if US or other country that requires State/Provence for mailing purposes)')), $address);

	   return $address;
    }

    function format_odd ($number) {
	   // http://james.cridland.net/code/format_uk_phonenumbers.html
	   // v2: worked on by Olly Benson to make it look better and work faster!
	   // v2.1: removal of a bugette
	   $telephoneFormat = array ('169774' => "5,4",'169737' => "4,6",'169772' => "5,4",'169773' => "5,4",'13873' => "5,5",'15242' => "5,5",
			 '15394' => "5,5",'15395' => "5,5",'15396' => "5,5",'16973' => "5,5",'16974' => "5,5",'17683' => "5,5",'17684' => "5,5",
			 '17687' => "5,5",'19467' => "5,5",'121' => "3,3,4",'131' => "3,3,4",'141' => "3,3,4",'151' => "3,3,4",'161' => "3,3,4",
			 '191' => "3,3,4",'500' => "3,6",'11' => "3,3,4",'2' => "2,4,4",'3' => "3,3,4",'5' => "4,6",'7' => "4,6",'8' => "3,3,4",
			 '9' => "3,3,4",'1' => "4,6"
			 );
	   // Turn number into array based on Telephone Format
	   $numberArray = $this->splitNumber($number,explode(",",$this->getTelephoneFormat($number, $telephoneFormat)));

	   // Add brackets around first split of numbers if number starts with 01 or 02
	   if (substr($number,0,2)=="1" || substr($number,0,2)=="2") $numberArray[0]="(".$numberArray[0].")";

	   // Convert array back into string, split by spaces
	   $formattedNumber = implode(" ",$numberArray);

	   return $formattedNumber;
    }

    function getTelephoneFormat($number, $telephoneFormat) {

	   foreach ($telephoneFormat AS $key=>$value) {
		  if (substr($number,0,strlen($key)) == $key) break;
		  };
	   return $value;
    }

    function splitNumber($number,$split) {
	   $start=0;
	   $array = array();
	   foreach($split AS $value) {
		  $array[] = substr($number,$start,$value);
		  $start = $start+$value;
		  }
	   return $array;
	   }

    function remove_leading($phone_num,$num_to_remove){
	   $num = $phone_num;
	   $code_count = strlen($num_to_remove);
	   $check = substr($phone_num, 0, $code_count);
	   if($check == $num_to_remove){
		  $num = substr($phone_num, $code_count);
	   }
	   return $num;
    }


}
?>