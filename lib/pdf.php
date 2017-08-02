<?php
/**
 * PDF API: PDF class
 *
 * @author Kolja Schleich
 * @package ProjectManager
 * @subpackage PDF
 */
 
/**
 * Class to implement PDF generation of FormFields or datasets
 *
 */
class PDF extends FPDF {
	/**
	 * page width
	 * 21cm - 3cm margins = 180mm
	 *
	 * @var int
	 */
	private $pagewidth = 180;
	

	/**
	 * current column
	 *
	 * @var int
	 */
	private $col = 0;
	

	/**
	 * column width
	 *
	 * @var int
	 */
	private $col_width;
	
		
	/**
	 * Ordinate of column start
	 *
	 * @var int
	 */
	private $y0;


	/**
	 * toggle page break
	 *
	 * @var boolean
	 */
	private $accept_page_break = false;
	
	
	/**
	 * project ID
	 *
	 * @var int
	 */
	private $project_id = 0;
	
	
	/**
	 * dataset ID
	 *
	 * @var int
	 */
	private $dataset_id = 0;
	
	
	/*
	 * current formfield
	 *
	 * @var object
	 */
	//private $formfield;
	
	
	/**
	 * set Project ID
	 *
	 * @param int $project_id
	 */
	public function setProjectID( $project_id ) {
		$this->project_id = intval($project_id);
		$this->project = get_project($this->project_id);
	}
	
	
	/**
	 * set Dataset ID
	 *
	 * @param int $dataset_id
	 */
	public function setDatasetID( $dataset_id ) {
		$this->dataset_id = intval($dataset_id);
	}
	
	
	/**
	 * Make PDF Header
	 */
	function Header() {
		if ( $this->dataset_id != 0 )
			$this->PrintDatasetHeader();
		
		if ( $this->project_id != 0 )
			$this->PrintFormHeader();
	}
	
	
	/**
	 * print Header for Dataset
	 */
	private function PrintDatasetHeader() {
		// Arial bold 18
		$this->SetFont('times', 'B', 15);
		$this->Cell(30,8, sprintf(__('Dataset Details - ID %d', 'projectmanager'), $this->dataset_id) , 0, 0, 'L');
		$this->Ln(8);
		//Save ordinate
		$this->y0 = $this->GetY();
	}
	
	
	/**
	 * print Header for Formular
	 */
	private function PrintFormHeader() {
		// Arial bold 18
		$this->SetFont('times', 'B', 18);
		$this->Cell(30,10, $this->project->title , 0, 0, 'L');
		$this->Ln(10);
		//Save ordinate
		$this->y0 = $this->GetY();
	}
	
	
	/**
	 * PDF Footer
	 */
	function Footer() {
	}
	

	/**
	 * set current column
	 *
	 * @param int $col
	 */
	private function SetCol($col) {
		//Set position at a given column
		$this->col = $col;
		$x = 10 + ($col-1)*$this->col_width;
		$this->SetLeftMargin($x);
		$this->SetX($x);
		$this->SetY($this->y0);
	}
	
	
	/**
	 * create new line
	 */
	private function NewLine() {
		/*if ( in_array($this->formfield->type, array('title', 'paragraph')) )
			$this->Ln(2);
			*/	
		$this->y0 = $this->GetY();
		$this->setCol(0);
	}
	

	/*	
	function AcceptPageBreak() {
		//Method accepting or not automatic page break
		if( $this->col < 2 ) {
			//Go to next column
			$this->SetCol( $this->col+1 );
			//Set ordinate to top
			$this->SetY($this->y0);
			//Keep on page
			return false;
		} else {
			//Go back to first column
			$this->SetCol(0);
			//Page break
			return true;
		}
	}
*/

	/**
	 * print Dataset formula
	 */
	public function printForm() {
		$project = get_project($this->project_id);
		
		//$this->PrintFormHeader();

		foreach ( $project->getFormFields() AS $i => $formfield ) {
			$this->col_width = $formfield->width/100 * $this->pagewidth;
			$this->SetCol($this->col+1);
			
			$label = stripslashes($formfield->label);
			$label = str_replace("€", "EURO", $label);
			
			if ( $formfield->type == 'paragraph' )
				$this->setFont('times', '', 11);
			elseif ( $formfield->type == 'title' )
				$this->setFont('times', 'B', 14);
			else
				$this->SetFont('times', 'B', 11);
			
			$options = explode(";", $formfield->options);
			if ( in_array($formfield->type, array('checkbox', 'project')) ) {
				if ( count(array_filter($options)) > 1 )
					$label .= " (".__('Multiple selections possible', 'projectmanager').")";
			}
			
			if ( $formfield->mandatory == 1 ) $label .= "*";
			
			$justification = ( $formfield->type == 'paragraph' ) ? 'J' : 'L';
			$this->MultiCell($this->col_width, 4.5, utf8_decode($label), 0, $justification);
			
			if ( !in_array($formfield->type, array('paragraph', 'title')) ) {
				if ( in_array($formfield->type, array('checkbox', 'radio', 'select')) ) {
					$this->Cell(2);
					foreach ( $options AS $option ) {
						if ( !empty($option) ) {
							$option = str_replace("€", "EURO", $option);
							$option = preg_replace('/([a-zA-z0-9,\.])EURO/', '$1 EURO', $option);
							
							if ( $this->GetX() > 150 ) {
								$this->Ln(5);
								$this->Cell(2);
							}
							
							$this->Rect($this->GetX(), $this->GetY()+1, 2, 2);
							$this->Cell(2);
							
							$this->Write(4.5, utf8_decode(__($option, 'projectmanager')));
							if ( $option == 'Other' ) {
								$this->Cell(2);
								$this->Line($this->GetX(), $this->GetY()+4.5, $this->GetX() + 20, $this->GetY()+4.5);
							}
							$this->Cell(3);
						}
					}
					$this->Ln(5);
				} else {
					$this->Ln(4);
			
					$sub = ( $formfield->newline == 1 ) ? 0 : 10;
					$this->Line($this->GetX(), $this->GetY(), $this->GetX() + $this->col_width - $sub, $this->GetY());
					$this->Ln(2);
				}
			} else {
				$this->Ln(3);
			}
			
			if ( $formfield->newline == 1 )
				$this->NewLine();
		}
	}
	
	
	/**
	 * print Dataset content
	 */
	public function printDatasetContent() {
		$dataset = get_dataset($this->dataset_id);
		$project = get_project($dataset->project_id);
		
		$data = array();
		foreach ( $dataset->getData() AS $meta ) {
			$data[$meta->form_field_id] = $meta->value;
		}
		
		//$this->PrintDatasetHeader();
		
		foreach ( $project->getFormFields() AS $i => $formfield ) {
			//$this->formfield = $formfield;
			
			$this->col_width = $formfield->width/100 * $this->pagewidth;
			$this->SetCol($this->col+1);
				
			$label = stripslashes($formfield->label);
			$label = str_replace("€", "EURO", $label);
			$label = utf8_decode($label);
			
			$value = isset($data[$formfield->id]) ? $data[$formfield->id] : '';
			if ( is_string($value) ) {
				$value = stripslashes(strip_tags(strip_shortcodes($value)));
			}
			
			if ( is_array($value) ) {
				$value = implode(", ", $value);
			}

			// save translated country name with country code
			if ( $formfield->type == 'country' ) {
				$map = new PM_Map($this->project_id);
				$value = $map->getCountryName($value) . " (".$value.")";
			}
			
			if ( 'date' == $formfield->type ) {
				$value = ( $value == '0000-00-00' ) ? '' : $value;
				$value = ( $value != '') ? mysql2date(get_option('date_format'), $value, true ) : $value;
			}
			
			$value = str_replace("€", " EURO", $value);
			$value = utf8_decode($value);
			
			//$value = preg_replace("(\d+)EURO", "$1 EURO", $value);
			
			if ( $formfield->type == 'paragraph' )
				$this->setFont('times', '', 11);
			elseif ( $formfield->type == 'title' )
				$this->setFont('times', 'B', 14);
			else
				$this->SetFont('times', 'B', 11);
			
			$justification = ( $formfield->type == 'paragraph' ) ? 'J' : 'L';
			$this->MultiCell($this->col_width, 4, $label, 0, $justification);
			
			$this->SetFont('times', '', 11);
			if ( $formfield->type == "signature" ) {
				$this->Ln(7);
				$sub = ( $formfield->newline == 1 ) ? 0 : 10;
				$this->Line($this->GetX(), $this->GetY(), $this->GetX() + $this->col_width - $sub, $this->GetY());
				$this->Ln(3);
			} else {
				$this->Cell(10);
				if ( in_array($formfield->type, array('image', 'dataset-image')) ) {
					// Current Image is dataset Image - Exchange with default image if empty
					if ( $dataset->has['image'] == $formfield->id && $value == '' ) {
						$value = $project->default_image;
					}
							
					$image = $dataset->getFilePath($value);
					if ( !empty($value) && file_exists($image) ) {
						$this->Image($image, null, null, -300, -300, $dataset->getFileType($value));
						$this->Ln(4);
					} else {
						$this->MultiCell($this->col_width, 4, $value, 0, 'L');
					}
				} else {
					$justification = ( $formfield->type == 'paragraph' ) ? 'J' : 'L';
					$this->MultiCell($this->col_width-5, 4, $value, 0, $justification);
				}
			}
			
			if ( $formfield->newline == 1 )
				$this->NewLine();
			
			$i++;
		}
	}
}
?>