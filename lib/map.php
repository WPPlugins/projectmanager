<?php
/**
 * PM_MAP API: PM_MAP class
 *
 * @author Kolja Schleich
 * @package ProjectManager
 * @subpackage PM_MAP
 */
 
/**
 * Class to implement the PM_MAP object
 *
 * The map is generated using the Free World Continent Map from simplemaps.com
 * @link http://simplemaps.com/resources/free-continent-map
 *
 */
class PM_Map {
	/**
	 * project ID
	 *
	 * @var int
	 */
	private $project_id = 0;
	
	/** 
	 * country regions
	 *
	 * @var array
	 */
	public $regions = array();
	
	/**
	 * number of regions
	 *
	 * @var int
	 */
	public $num_regions = 0;
	
	/**
	 * countries
	 *
	 * @var array
	 */
	public $countries = array();
	
	/**
	 * number of countries
	 *
	 * @var int
	 */
	public $num_countries = 0;
	
	/**
	 * number of datasets by region
	 *
	 * @var array
	 */
	public $num_datasets_by_region = array();
	
	/**
	 * number of datasets by country
	 *
	 * @var array
	 */
	public $num_datasets_by_country = array();
	
	/**
	 * map data
	 *
	 * @var array
	 */
	private $settings = array();
	
	
	/**
	 * Constructor
	 *
	 * @param int $project_id Project ID
	 */
	public function __construct( $project_id ) {
		$this->project_id = intval($project_id);
		
		$project = get_project($this->project_id);
		$this->settings = $project->getSettings('map');
		
		$this->getRegions();
		$this->getCountries();
	}
	
	
	/**
	 * load country regions
	 *
	 */
	private function getRegions() {
		$regions = array(
			'SA' => __( 'South America', 'projectmanager' ),
			'NA' => __( 'North America', 'projectmanager' ),
			'EU' => __( 'Europe', 'projectmanager' ),
			'AF' => __( 'Africa', 'projectmanager' ),
			'NS' => __( 'North Asia', 'projectmanager' ),
			'SS' => __( 'South Asia', 'projectmanager' ),
			'ME' => __( 'Middle East', 'projectmanager' ),
			'OC' => __( 'Oceania', 'projectmanager')
		);
		$this->regions = $regions;
		$this->num_regions = count($regions);
	}
	
	
	/**
	 * load countries
	 *
	 */
	private function getCountries() {
		global $wpdb;
		
		$countries = $wpdb->get_results( "SELECT `code`, `name`, `region_code`, `region_name`, `code2`, `id` FROM {$wpdb->projectmanager_countries} ORDER BY `name` ASC" );
		
		/*
		* re-sort contries based on translated names
		*/
		$to_sort = array();
		foreach ($countries AS $country) {
			$to_sort[] = __(stripslashes($country->name), 'projectmanager');
		}
		$sorted = $this->sortArray($to_sort);
		
		$c = array();
		foreach ($sorted AS $key => $name) {
			$country = $countries[$key];
			$country->name = stripslashes($name);
			$country->code = htmlspecialchars($country->code);
			
			$c[] = get_object_vars($country);
		}
		
		$this->countries = $c;
		$this->num_countries = count($c);
	}
	
	
	/**
	 * sort array with umlaute
	 * 
	 * @param array $tArray
	 * @return array sorted array
	 */
	private function sortArray($tArray) {
		$aOriginal = $tArray;
		if (count($aOriginal) == 0) { return $aOriginal; }
		$aModified = array();
		$aReturn   = array();
		$aSearch   = array("Ä","ä","Ö","ö","Ü","ü","ß","-");
		$aReplace  = array("Ae","ae","Oe","oe","Ue","ue","ss"," ");
		foreach($aOriginal as $key => $val) {
			$aModified[$key] = str_replace($aSearch, $aReplace, $val);
		}
		natcasesort($aModified);
		foreach($aModified as $key => $val) {
			$aReturn[$key] = $aOriginal[$key];
		}
		return $aReturn;
	}
	
	
	/**
	 * get map data
	 *
	 * @return array
	 */
	public function getData() {
		return $this->settings['data'];
	}
	
	
	/**
	 * get country name based on three-letter code
	 *
	 * @param string $code
	 * @return string
	 */
	public function getCountryName($code) {
		$key = array_search($code, array_column($this->countries, "code"));
		if (!is_numeric($key)) return '';
		
		return __(stripslashes($this->countries[$key]['name']), 'projectmanager');
	}
	
	
	/**
	 * get country code based on name
	 *
	 * @param string $name
	 * @return string
	 */
	public function getCountryCode($name) {
		$key = array_search($name, array_column($this->countries, "name"));
		if (!is_numeric($key)) return '';
		
		return $this->countries[$key]['code'];
	}
	
		
	/**
	 * get countries by regions
	 *
	 * @return array
	 */
	private function getCountriesByRegion() {
		$countries = array();
		foreach ( $this->regions AS $code => $name ) {
			$countries[$code] = array();
			
			$keys = array_keys(array_column($this->countries, "region_code"), $code);
			foreach ($keys AS $key)
				$countries[$code][] = $this->countries[$key];
		}
		
		return $countries;
	}
	
	
	/**
	 * get number of datasets by country region
	 *
	 * @param int $formfield_id the country formfield ID
	 * @return array indexed country region code
	 */
	private function getNumDatasetsByRegion( $formfield_id ) {
		global $wpdb;
		
		$results = $this->num_datasets_by_region;
		
		// Use cached object
		if ( count($results) > 0 ) return $results;
		
		// get countries
		foreach ( $this->getCountriesByRegion() AS $r_code => $countries ) {
			$sql = "SELECT COUNT(ID) FROM {$wpdb->projectmanager_datasetmeta} WHERE form_id = '%d' AND value IN ('".implode("','", array_column($countries, "code"))."')";
			$results[$r_code] = $wpdb->get_var($wpdb->prepare($sql, $formfield_id));
		}
		
		$this->num_datasets_by_region = $results;
		
		return $results;
	}
		
		
	/**
	 * get number of datasets by country
	 *
	 * @param int $formfield_id the country formfield ID
	 * @return array indexed country code
	 */
	private function getNumDatasetsByCountry( $formfield_id ) {
		global $wpdb;
		
		$results = $this->num_datasets_by_country;
		
		// Use cached object
		if ( count($results) > 0 ) return $results;
		
		// get countries
		foreach ( $this->countries AS $country ) {
			$sql = "SELECT COUNT(ID) FROM {$wpdb->projectmanager_datasetmeta} WHERE form_id = '%d' AND value = '%s'";
			$results[$country['code']] = $wpdb->get_var($wpdb->prepare($sql, $formfield_id, $country['code']));
		}
			
		$this->num_datasets_by_country = $results;
		
		return $results;
	}
	
	
	/**
	 * update map data
	 *
	 * @return array
	 */
	public function updateData() {
		global $wpdb;
		
		$project = get_project($this->project_id);
		$settings = $project->getSettings();
		
		// get number of datasets by region
		$num_datasets_by_region = $this->getNumDatasetsByRegion( $this->settings['field'] );
		
		// get number of datasets by country
		$num_datasets_by_country = $this->getNumDatasetsByCountry( $this->settings['field'] );
		
		$list_num_datasets_regions = array();
		foreach ( $this->getCountriesByRegion() AS $code => $countries ) {
			$num_datasets_regions[$code] = array();
			// get number of datasets for each country indexed by region
			foreach ( $countries AS $country ) {
				$num_datasets = $num_datasets_by_country[$country['code']];
				if ( $num_datasets > 0 ) {
					$num_datasets_regions[$code][] = sprintf("%s: %d %s", $country['name'], $num_datasets, $this->settings['dataset_label']);
				}
			}
		}
		
		$mapdata = array(
			'last_updated' => current_time('timestamp'),
			'num_datasets_by_country' => $num_datasets_by_country,
			'num_datasets_by_region' => $num_datasets_by_region,
			'num_datasets_regions' => $num_datasets_regions
		);
		$settings['map']['data'] = $mapdata;
		
		$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->projectmanager_projects} SET `settings` = '%s' WHERE `id` = '%d'", maybe_serialize($settings), $this->project_id ) );
		$this->settings['data'] = $mapdata;
		
		return $mapdata;
	}
	
	
	/**
	 * display map
	 *
	 */
	public function display() {
		// maybe update map data
		if ( $this->settings['update_schedule'] == 'on-load' ) $this->updateData();
		$data = $this->getData();
		
		$out = "<div class='projectmanager_map'>";
		$out .= "<script type='text/javascript'>\n";
		foreach ( $this->regions AS $r_code => $r_name ) {
			$out .= sprintf("var %s_name = \"%s\"", $r_code, $r_name) . "\n";
			$out .= sprintf("var %s_description = \"<strong>%d %s</strong><ul class='num_datasets_countries'><li>%s</li></ul>\"", $r_code, $data['num_datasets_by_region'][$r_code], $this->settings['dataset_label'], implode("</li><li>", $data['num_datasets_regions'][$r_code])) . "\n";
		}
		$out .= "</script>\n";

		// include map javascript
		$out .= '<script type="text/javascript" src="'. PROJECTMANAGER_URL . '/js/continentmap/mapdata.js' .'"></script><script type="text/javascript" src="'.PROJECTMANAGER_URL . '/js/continentmap/continentmap.js'.'"></script>';
		$out .= '<div id="map"></div>';
		$out .= '</div>';
		
		return $out;
	}
}
?>