<?php
class PdfController extends Controller{
	public function GenerateListBoughtPdf($owner_email,$deal_id)
	{	
		$old_pdf = app_path().'/../public/pdf/'.md5($owner_email).'.pdf';
		unset($old_pdf);
		$pdf_options = [
			"source_type" => 'url',
			"source" => asset('ajax/pdf').'/'.$deal_id,
			"action" => 'save',
			"save_directory" => app_path().'/../public/pdf',
			"file_name" => md5($owner_email).'.pdf'
		];
		Phptopdf::phptopdf($pdf_options);
	}
	
}
?>