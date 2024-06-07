<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function getCleanText($data='')
	{
		return htmlentities($data);
	}

	function pr($data='', $is_exit=0)
	{
		echo "<pre>";
		if(is_array($data) || is_object($data))
		{
			print_r($data);
		}
		else
		{
			echo $data;
		}
		echo "</pre>";
		if($is_exit==1){exit;}
	}


if ( ! function_exists('getRFQType') || ! function_exists('calculateAge') || ! function_exists('timeAgo')) 
{
	function getRFQType() 
	{
		$object = new stdClass();
	   	$object->data[] = (object)array( "id"=> "1", "title"=> "Standard Quotation", "status"=> "1");
		$object->data[] = (object)array( "id"=> "2", "title"=> "Budgetry Quotation", "status"=> "1");
		$object->data[] = (object)array( "id"=> "3", "title"=> "Project Quotation", "status"=> "1");
		return $object;
	}
	
	function getRFQFor() 
	{
		$object = new stdClass();
	   	$object->data[] = (object)array( "id"=> "1", "title"=> "Commercial Quotation", "status"=> "1");
		$object->data[] = (object)array( "id"=> "2", "title"=> "Technical Quotation", "status"=> "1");
		$object->data[] = (object)array( "id"=> "3", "title"=> "Commercial & Technical", "status"=> "1");
		return $object;
	}
	
	function getQuoteFollowupDisable($all_status_id)
	{
		$status = true;
		$disabled_status = array(13);
		if(in_array($all_status_id , $disabled_status))
		{
			$status = false;
		}
		return $status;
	}
	
	function numberFormatPrecision($number, $precision = 2, $separator = '.')
	{
		$numberParts = explode($separator, $number);
		$response = $numberParts[0];
		$response = number_format($response);
		if (count($numberParts)>1 && $precision > 0) {
			$response .= $separator;
			$response .= substr($numberParts[1], 0, $precision);
		}
		return $response;
	}
	
	function productDescriptionAccordian($description, $word_count = 5)
	{
		$temp_desc = strip_tags($description);
		$show_data = '';
		$less_content = '';
		if(!empty($temp_desc))
		{
			$new_sentence_arr = explode(' ', $temp_desc);
			if(count($new_sentence_arr)>$word_count)
			{
				$acctual_count = count($new_sentence_arr);
				$loop_count = $word_count-1;
			}
			else
			{
				$acctual_count = count($new_sentence_arr);
				$loop_count = $acctual_count-1;
			}
			
			for($i=0 ; $i <= $loop_count ; $i++)
			{
				$less_content.=  $new_sentence_arr[$i].' ';
			}
				if($acctual_count>$word_count)
				{
			$show_data.='<div class="card collapsed-card"  >';
			  $show_data.='<div class="card-header" data-card-widget="collapse" >';
					//$show_data.='<span data-card-widget="collapse">';
					$show_data.=$less_content;
					//$show_data.='</span>';
						//$show_data.='<div class="card-tools">';
						//$show_data.='<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>';
						//$show_data.='<button type="button" class="btn btn-tool card_body_btn_acc"  data-card-widget="maximize"><i class="fas fa-expand"></i></button>';
						//$show_data.='</div>';
				
				$show_data.='</div>';
			  $show_data.='<div class="card-body card_body_des_acc" style="display: none;overflow-y: scroll;max-height: 300px">';
			  $show_data.=$description;
			  $show_data.='</div>';
			$show_data.='</div>';
			}
			else
			{
				$show_data = $less_content;
			}
		}
		
		return $show_data;
	}
	
	function displayAmountFormat($amount =0 , $decimal_length=2)
	{
		return number_format($amount , $decimal_length);
	}
	
	function displayDiscountAmount($amount =0 , $discount='' , $variable='' , $currency='')
	{
		$discount_amount=0;
		if($variable=='%' && !empty($discount))
		{
			$discount_amount = ($amount * $discount)/100;  
		}
		else if($variable=='&' && !empty($discount))
		{
			$discount_amount = $discount;
		}

		return number_format($discount_amount , 2);
	}
	
}

function convert_number($number) 
    {
        if (($number < 0) || ($number > 999999999)) 
        {
            throw new Exception("Number is out of range");
        }
        $giga = floor($number / 1000000);
        // Millions (giga)
        $number -= $giga * 1000000;
        $kilo = floor($number / 1000);
        // Thousands (kilo)
        $number -= $kilo * 1000;
        $hecto = floor($number / 100);
        // Hundreds (hecto)
        $number -= $hecto * 100;
        $deca = floor($number / 10);
        // Tens (deca)
        $n = $number % 10;
        // Ones
        $result = "";
        if ($giga) 
        {
            $result .= $this->convert_number($giga) .  "Million";
        }
        if ($kilo) 
        {
            $result .= (empty($result) ? "" : " ") .convert_number($kilo) . " Thousand";
        }
        if ($hecto) 
        {
            $result .= (empty($result) ? "" : " ") .convert_number($hecto) . " Hundred";
        }
        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
        if ($deca || $n) {
            if (!empty($result)) 
            {
                $result .= " and ";
            }
            if ($deca < 2) 
            {
                $result .= $ones[$deca * 10 + $n];
            } else {
                $result .= $tens[$deca];
                if ($n) 
                {
                    $result .= "-" . $ones[$n];
                }
            }
        }
        if (empty($result)) 
        {
            $result = "zero";
        }
        return $result;
    }

function getIndianCurrency( $number)
{

    $decimal = round($number - ($no = floor($number)), 2) * 100;

    $hundred = null;

    $digits_length = strlen($no);

    $i = 0;

    $str = array();

    $words = array(0 => '', 1 => 'one', 2 => 'two',

        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',

        7 => 'seven', 8 => 'eight', 9 => 'nine',

        10 => 'ten', 11 => 'eleven', 12 => 'twelve',

        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',

        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',

        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',

        40 => 'forty', 50 => 'fifty', 60 => 'sixty',

        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');

    $digits = array('', 'hundred','thousand','lakh', 'crore');

    while( $i < $digits_length ) {

        $divider = ($i == 2) ? 10 : 100;

        $number = floor($no % $divider);

        $no = floor($no / $divider);

        $i += $divider == 10 ? 1 : 2;

        if ($number) {

            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;

            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;

            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;

        } else $str[] = null;

    }

    $Rupees = implode('', array_reverse($str));

//    $paise = ($decimal) ? "and " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    	$paise = ($decimal) ? "and " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
		//$paise = ($decimal) ? "and " . ( $words[$decimal % 10]) . ' Paise' : '';

    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise ;

}


if ( ! function_exists('pr')) 
{
	function pr($data='', $is_exit = 0) 
	{
		echo "<pre>";
		if(is_array($data) || is_object($data))
		{
			print_r($data);
		}
		else
		{
			echo "<h4>".$data."</h4>";
		}
		echo "</pre>";
		if($is_exit ==1)
		{
			exit;
		}
	}
	
}