<?php
class FormatComponent extends Component {

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
		$date = DateTime::createFromFormat("F-d-Y", $timetochange);
		return $date->format($out_form);
    }

}
?>