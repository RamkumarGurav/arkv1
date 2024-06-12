<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class FiscalYear
{
	private $CI;
	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->load->library('session');

		$this->sess_company_profile_id = $this->CI->session->userdata('sess_company_profile_id');
	}

	function setFiscalYear()
	{
		$fiscal_year = $this->getFiscalYear();
		$temp = $this->getData(array("select" => "*", "from" => "fiscal_year", "where" => "financial_year = '$fiscal_year->financial_year'"));
		if (!empty($temp)) {
			return $temp[0];
		} else {
			$add_data['start'] = $fiscal_year->start;
			$add_data['end'] = $fiscal_year->end;
			$add_data['short_start'] = $fiscal_year->short_start;
			$add_data['short_end'] = $fiscal_year->short_end;
			$add_data['financial_year'] = $fiscal_year->financial_year;
			$add_data['short_financial_year'] = $fiscal_year->short_financial_year;
			$this->add_operation(array("table" => "fiscal_year", "data" => $add_data));

			$where = "financial_year = '$fiscal_year->financial_year'";
			$temp = $this->getData(array("select" => "*", "from" => "fiscal_year", "where" => $where));
			if (empty($temp)) {
				$this->setFiscalYear();
			} else {
				return $temp[0];
			}
		}

	}

	function getFiscalRequestForQuotationNumber()
	{
		$fiscal_year = $this->getFiscalYear();
		$temp = $this->getData(array("select" => "*", "from" => "fiscal_year", "where" => "financial_year = '$fiscal_year->financial_year'"));
		$fiscal_year_data = $temp[0];
		$total_count = $this->getData(array('select' => 'quotation_enquiry_number', 'from' => 'quotation_enquiry', 'where' => "(fiscal_year_id = $fiscal_year_data->fiscal_year_id and quotation_enquiry_number != '')", 'order_by' => 'quotation_enquiry_id DESC', 'limit' => 1));

		if (!empty($total_count)) {
			$last_quotation_enquiry_number = $total_count[0]->quotation_enquiry_number;
			$last_quotation_enquiry_number_count_arr = explode("/", $last_quotation_enquiry_number);
			$temp_num = $last_quotation_enquiry_number_count_arr[0];
			$temp_num = str_replace('QT', '', $temp_num);
			$temp_num_n = $temp_num - 100000;
			if ($temp_num_n <= 0) {
				$temp_num_n = $temp_num;
			}
			$new_quotation_enquiry_number_count = ($temp_num_n + 1);

		} else {
			$new_quotation_enquiry_number_count = 1;
		}

		//$quotation_enquiry_number = "RFQ/$fiscal_year_data->financial_year/00".$new_quotation_enquiry_number_count;
		//RFQ
		$new_quotation_enquiry_number_count = 100000 + $new_quotation_enquiry_number_count;
		$quotation_enquiry_number = "QT$new_quotation_enquiry_number_count/" . date('m') . "/" . date('y');

		//$quotation_number = "QT00$new_quotation_number_count/".date('m')."/".date('y');

		return array("quotation_enquiry_number" => $quotation_enquiry_number, "fiscal_year_id" => $fiscal_year_data->fiscal_year_id);

	}

	function getFiscalQuotationNumber()
	{
		$fiscal_year = $this->getFiscalYear();
		$temp = $this->getData(array("select" => "*", "from" => "fiscal_year", "where" => "financial_year = '$fiscal_year->financial_year'"));
		$fiscal_year_data = $temp[0];
		$total_count = $this->getData(array('select' => 'quotation_number', 'from' => 'quotation', 'where' => "(fiscal_year_id = $fiscal_year_data->fiscal_year_id and quotation_number != '')", 'order_by' => 'quotation_id DESC', 'limit' => 1));

		if (!empty($total_count)) {
			$last_quotation_number = $total_count[0]->quotation_number;
			$last_quotation_number_count_arr = explode("/", $last_quotation_number);

			$temp_num = $last_quotation_number_count_arr[0];
			$temp_num = str_replace('QT', '', $temp_num);
			$temp_num_n = $temp_num - 100000;
			if ($temp_num_n <= 0) {
				$temp_num_n = $temp_num;
			}

			$new_quotation_number_count = ($temp_num_n + 1);

		} else {
			$new_quotation_number_count = 1;
		}

		//$quotation_number = "QT/$fiscal_year_data->financial_year/00".$new_quotation_number_count;
		$new_quotation_number_count = 100000 + $new_quotation_number_count;
		$quotation_number = "QT00$new_quotation_number_count/" . date('m') . "/" . date('y');

		return array("quotation_number" => $quotation_number, "fiscal_year_id" => $fiscal_year_data->fiscal_year_id);

	}

	function getFiscalProformaInvoiceNumber()
	{
		$fiscal_year = $this->getFiscalYear();
		$temp = $this->getData(array("select" => "*", "from" => "fiscal_year", "where" => "financial_year = '$fiscal_year->financial_year'"));
		$fiscal_year_data = $temp[0];
		$total_count = $this->getData(array('select' => 'proforma_invoice_number', 'from' => 'proforma_invoice', 'where' => "(status!=0 and fiscal_year_id = $fiscal_year_data->fiscal_year_id and proforma_invoice_number != '')", 'order_by' => 'proforma_invoice_id DESC', 'limit' => 1));

		if (!empty($total_count)) {
			$last_number = $total_count[0]->proforma_invoice_number;
			$last_number_count_arr = explode("/", $last_number);
			$new_number_count = ($last_number_count_arr[2] + 1);
		} else {
			$new_number_count = 1;
		}

		$final_number = "PI/$fiscal_year_data->financial_year/00" . $new_number_count;

		return array("proforma_invoice_number" => $final_number, "fiscal_year_id" => $fiscal_year_data->fiscal_year_id);

	}

	function getFiscalInvoiceNumber()
	{
		$fiscal_year = $this->getFiscalYear();
		$temp = $this->getData(array("select" => "*", "from" => "fiscal_year", "where" => "financial_year = '$fiscal_year->financial_year'"));
		$fiscal_year_data = $temp[0];
		$total_count = $this->getData(array('select' => 'invoice_number', 'from' => 'invoice', 'where' => "(fiscal_year_id = $fiscal_year_data->fiscal_year_id and invoice_number != '')", 'order_by' => 'invoice_id DESC', 'limit' => 1));

		if (!empty($total_count)) {
			$last_number = $total_count[0]->invoice_number;
			$last_number_count_arr = explode("/", $last_number);
			$new_number_count = ($last_number_count_arr[2] + 1);
		} else {
			$new_number_count = 1;
		}

		$final_number = "INV/$fiscal_year_data->financial_year/00" . $new_number_count;

		return array("invoice_number" => $final_number, "fiscal_year_id" => $fiscal_year_data->fiscal_year_id);

	}

	function getFiscalDeliveryNoteNumber()
	{
		$fiscal_year = $this->getFiscalYear();
		$temp = $this->getData(array("select" => "*", "from" => "fiscal_year", "where" => "financial_year = '$fiscal_year->financial_year'"));
		$fiscal_year_data = $temp[0];
		$total_count = $this->getData(array('select' => 'reff_invoice_delivery_note_number', 'from' => 'invoice_delivery_note', 'where' => "(fiscal_year_id = $fiscal_year_data->fiscal_year_id and reff_invoice_delivery_note_number != '')", 'order_by' => 'invoice_delivery_note_id DESC', 'limit' => 1));

		if (!empty($total_count)) {
			$last_number = $total_count[0]->reff_invoice_delivery_note_number;
			$last_number_count_arr = explode("/", $last_number);
			$new_number_count = ($last_number_count_arr[2] + 1);
		} else {
			$new_number_count = 1;
		}

		$final_number = "DN/$fiscal_year_data->financial_year/00" . $new_number_count;

		return array("invoice_delivery_note_number" => $final_number, "fiscal_year_id" => $fiscal_year_data->fiscal_year_id);

	}

	function getFiscalPurchaseOrderNumber()
	{
		$fiscal_year = $this->getFiscalYear();
		$temp = $this->getData(array("select" => "*", "from" => "fiscal_year", "where" => "financial_year = '$fiscal_year->financial_year'"));
		$fiscal_year_data = $temp[0];
		$total_count = $this->getData(array('select' => 'purchase_order_number', 'from' => 'purchase_order', 'where' => "(fiscal_year_id = $fiscal_year_data->fiscal_year_id and purchase_order_number != '')", 'order_by' => 'purchase_order_id DESC', 'limit' => 1));

		if (!empty($total_count)) {
			$last_number = $total_count[0]->purchase_order_number;
			$last_number_count_arr = explode("/", $last_number);
			$new_number_count = ($last_number_count_arr[2] + 1);
		} else {
			$new_number_count = 1;
		}

		$final_number = "PO/$fiscal_year_data->financial_year/00" . $new_number_count;

		return array("purchase_order_number" => $final_number, "fiscal_year_id" => $fiscal_year_data->fiscal_year_id);

	}

	function getData($params = array())
	{
		$this->CI->db->select($params['select']);
		$this->CI->db->from($params['from']);
		$this->CI->db->where("($params[where])");
		if (!empty($params['limit'])) {
			$this->CI->db->limit($params['limit']);
		}
		if (!empty($params['order_by'])) {
			$this->CI->db->order_by($params['order_by']);
		}
		$query_get_list = $this->CI->db->get();
		return $query_get_list->result();
	}

	function add_operation($params = array())
	{
		if (empty($params))
			return false;
		$status = $this->CI->db->insert($params['table'], $params['data']);
		if ($status) {
			$status = $status = $this->CI->db->insert_id();
		}
		return $status;
	}

	public function getFiscalYear()
	{
		$result = array();
		$start = '';
		$end = '';
		$s_start = '';
		$s_end = '';
		if (date('m') < 4) {//Upto march 
			$start = date('Y') - 1;
			$end = date('Y');
			$s_start = date('y') - 1;
			$s_end = date('y');
			//$financial_year = (date('Y')-1) . '-' . date('Y');
		} else {//form April 
			$start = date('Y');
			$end = date('Y') + 1;
			$s_start = date('y');
			$s_end = date('y') + 1;
			//$financial_year = date('Y') . '-' . (date('Y') + 1);
		}
		$work_year = date('Y');
		$result['work_year'] = $work_year;
		$result['start'] = $start;
		$result['end'] = $end;
		$result['short_start'] = $s_start;
		$result['short_end'] = $s_end;
		$result['financial_year'] = $work_year;
		//$result['financial_year'] = $start.'-'.$end;
		$result['short_financial_year'] = $s_start . '-' . $s_end;
		return (object) $result;
	}


}
