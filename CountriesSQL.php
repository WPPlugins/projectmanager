<?php
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'AFG'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('AFG', '%s', '%s', '%s', '%s')", "Afghanistan", "ME", "Middle East", "AF" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ALA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ALA', '%s', '%s', '%s', '%s')", "Åland Islands", "EU", "Europe", "AX" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ALB'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ALB', '%s', '%s', '%s', '%s')", "Albania", "EU", "Europe", "AL" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'DZA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('DZA', '%s', '%s', '%s', '%s')", "Algeria", "AF", "Africa", "DZ" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ASM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ASM', '%s', '%s', '%s', '%s')", "American Samoa", "OC", "Oceania", "AS" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'AND'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('AND', '%s', '%s', '%s', '%s')", "Andorra", "EU", "Europe", "AD" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'AGO'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('AGO', '%s', '%s', '%s', '%s')", "Angola", "AF", "Africa", "AO" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'AIA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('AIA', '%s', '%s', '%s', '%s')", "Anguilla", "SA", "South America", "AI" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ATG'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ATG', '%s', '%s', '%s', '%s')", "Antigua and Barbuda", "SA", "South America", "AG" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ARG'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ARG', '%s', '%s', '%s', '%s')", "Argentina", "SA", "South America", "AR" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ARM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ARM', '%s', '%s', '%s', '%s')", "Armenia", "EU", "Europe", "AM" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ABW'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ABW', '%s', '%s', '%s', '%s')", "Aruba", "SA", "South America", "AW" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'AUS'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('AUS', '%s', '%s', '%s', '%s')", "Australia", "OC", "Oceania", "AU" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'AUT'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('AUT', '%s', '%s', '%s', '%s')", "Austria", "EU", "Europe", "AT" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'AZE'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('AZE', '%s', '%s', '%s', '%s')", "Azerbaijan", "ME", "Middle East", "AZ" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BHS'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BHS', '%s', '%s', '%s', '%s')", "Bahamas", "SA", "South America", "BS" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BHR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BHR', '%s', '%s', '%s', '%s')", "Bahrain", "ME", "Middle East", "BH" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BGD'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BGD', '%s', '%s', '%s', '%s')", "Bangladesh", "SS", "South Asia", "BD" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BRB'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BRB', '%s', '%s', '%s', '%s')", "Barbados", "SA", "South America", "BB" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BLR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BLR', '%s', '%s', '%s', '%s')", "Belarus", "EU", "Europe", "BY" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BEL'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BEL', '%s', '%s', '%s', '%s')", "Belgium", "EU", "Europe", "BE" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BLZ'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BLZ', '%s', '%s', '%s', '%s')", "Belize", "SA", "South America", "BZ" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BEN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BEN', '%s', '%s', '%s', '%s')", "Benin", "AF", "Africa", "BJ" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BMU'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BMU', '%s', '%s', '%s', '%s')", "Bermuda", "NA", "North America", "BM" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BTN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BTN', '%s', '%s', '%s', '%s')", "Bhutan", "SS", "South Asia", "BT" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BOL'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BOL', '%s', '%s', '%s', '%s')", "Bolivia (Plurinational State of)", "SA", "South America", "BO" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BES'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BES', '%s', '%s', '%s', '%s')", "Bonaire, Sint Eustatius and Saba", "SA", "South America", "" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BIH'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BIH', '%s', '%s', '%s', '%s')", "Bosnia and Herzegovina", "EU", "Europe", "BA" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BWA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BWA', '%s', '%s', '%s', '%s')", "Botswana", "AF", "Africa", "BW" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BRA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BRA', '%s', '%s', '%s', '%s')", "Brazil", "SA", "South America", "BR" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'VGB'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('VGB', '%s', '%s', '%s', '%s')", "British Virgin Islands", "SA", "South America", "VG" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BRN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BRN', '%s', '%s', '%s', '%s')", "Brunei Darussalam", "OC", "Oceania", "BN" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BGR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BGR', '%s', '%s', '%s', '%s')", "Bulgaria", "EU", "Europe", "BG" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BFA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BFA', '%s', '%s', '%s', '%s')", "Burkina Faso", "AF", "Africa", "BF" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BDI'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BDI', '%s', '%s', '%s', '%s')", "Burundi", "AF", "Africa", "BI" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'CPV'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('CPV', '%s', '%s', '%s', '%s')", "Cabo Verde", "AF", "Africa", "CV" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'KHM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('KHM', '%s', '%s', '%s', '%s')", "Cambodia", "SS", "South Asia", "KH" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'CMR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('CMR', '%s', '%s', '%s', '%s')", "Cameroon", "AF", "Africa", "CM" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'CAN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('CAN', '%s', '%s', '%s', '%s')", "Canada", "NA", "North America", "CA" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'CYM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('CYM', '%s', '%s', '%s', '%s')", "Cayman Islands", "SA", "South America", "KY" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'CAF'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('CAF', '%s', '%s', '%s', '%s')", "Central African Republic", "AF", "Africa", "CF" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'TCD'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('TCD', '%s', '%s', '%s', '%s')", "Chad", "AF", "Africa", "TD" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'CHL'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('CHL', '%s', '%s', '%s', '%s')", "Chile", "SA", "South America", "CL" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'CHN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('CHN', '%s', '%s', '%s', '%s')", "China", "SS", "South Asia", "CN" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'HKG'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('HKG', '%s', '%s', '%s', '%s')", "China, Hong Kong Special Administrative Region", "SS", "South Asia", "HK" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MAC'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MAC', '%s', '%s', '%s', '%s')", "China, Macao Special Administrative Region", "SS", "South Asia", "MO" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'COL'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('COL', '%s', '%s', '%s', '%s')", "Colombia", "SA", "South America", "CO" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'COM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('COM', '%s', '%s', '%s', '%s')", "Comoros", "AF", "Africa", "KM" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'COG'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('COG', '%s', '%s', '%s', '%s')", "Congo", "AF", "Africa", "CG" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'COK'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('COK', '%s', '%s', '%s', '%s')", "Cook Islands", "OC", "Oceania", "CK" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'CRI'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('CRI', '%s', '%s', '%s', '%s')", "Costa Rica", "SA", "South America", "CR" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'CIV'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('CIV', '%s', '%s', '%s', '%s')", "Côte d'Ivoire", "AF", "Africa", "CI" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'HRV'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('HRV', '%s', '%s', '%s', '%s')", "Croatia", "EU", "Europe", "HR" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'CUB'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('CUB', '%s', '%s', '%s', '%s')", "Cuba", "SA", "South America", "CU" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'CUW'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('CUW', '%s', '%s', '%s', '%s')", "Curaçao", "SA", "South America", "CW" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'CYP'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('CYP', '%s', '%s', '%s', '%s')", "Cyprus", "EU", "Europe", "CY" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'CZE'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('CZE', '%s', '%s', '%s', '%s')", "Czech Republic", "EU", "Europe", "CZ" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'PRK'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('PRK', '%s', '%s', '%s', '%s')", "Democratic People's Republic of Korea", "SS", "South Asia", "KP" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'COD'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('COD', '%s', '%s', '%s', '%s')", "Democratic Republic of the Congo", "AF", "Africa", "CD" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'DNK'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('DNK', '%s', '%s', '%s', '%s')", "Denmark", "EU", "Europe", "DK" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'DJI'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('DJI', '%s', '%s', '%s', '%s')", "Djibouti", "AF", "Africa", "DJ" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'DMA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('DMA', '%s', '%s', '%s', '%s')", "Dominica", "SA", "South America", "DM" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'DOM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('DOM', '%s', '%s', '%s', '%s')", "Dominican Republic", "SA", "South America", "DO" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ECU'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ECU', '%s', '%s', '%s', '%s')", "Ecuador", "SA", "South America", "EC" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'EGY'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('EGY', '%s', '%s', '%s', '%s')", "Egypt", "AF", "Africa", "EG" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SLV'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SLV', '%s', '%s', '%s', '%s')", "El Salvador", "SA", "South America", "SV" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'GNQ'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('GNQ', '%s', '%s', '%s', '%s')", "Equatorial Guinea", "AF", "Africa", "GQ" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ERI'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ERI', '%s', '%s', '%s', '%s')", "Eritrea", "AF", "Africa", "ER" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'EST'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('EST', '%s', '%s', '%s', '%s')", "Estonia", "EU", "Europe", "EE" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ETH'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ETH', '%s', '%s', '%s', '%s')", "Ethiopia", "AF", "Africa", "ET" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'FRO'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('FRO', '%s', '%s', '%s', '%s')", "Faeroe Islands", "EU", "Europe", "FO" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'FLK'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('FLK', '%s', '%s', '%s', '%s')", "Falkland Islands (Malvinas)", "SA", "South America", "FK" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'FJI'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('FJI', '%s', '%s', '%s', '%s')", "Fiji", "OC", "Oceania", "FJ" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'FIN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('FIN', '%s', '%s', '%s', '%s')", "Finland", "EU", "Europe", "FI" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'FRA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('FRA', '%s', '%s', '%s', '%s')", "France", "EU", "Europe", "FR" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'GUF'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('GUF', '%s', '%s', '%s', '%s')", "French Guiana", "SA", "South America", "GF" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'PYF'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('PYF', '%s', '%s', '%s', '%s')", "French Polynesia", "OC", "Oceania", "PF" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'GAB'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('GAB', '%s', '%s', '%s', '%s')", "Gabon", "AF", "Africa", "GA" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'GMB'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('GMB', '%s', '%s', '%s', '%s')", "Gambia", "AF", "Africa", "GM" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'GEO'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('GEO', '%s', '%s', '%s', '%s')", "Georgia", "EU", "Europe", "GE" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'DEU'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('DEU', '%s', '%s', '%s', '%s')", "Germany", "EU", "Europe", "DE" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'GHA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('GHA', '%s', '%s', '%s', '%s')", "Ghana", "AF", "Africa", "GH" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'GIB'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('GIB', '%s', '%s', '%s', '%s')", "Gibraltar", "EU", "Europe", "GI" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'GRC'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('GRC', '%s', '%s', '%s', '%s')", "Greece", "EU", "Europe", "GR" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'GRL'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('GRL', '%s', '%s', '%s', '%s')", "Greenland", "NA", "North America", "GL" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'GRD'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('GRD', '%s', '%s', '%s', '%s')", "Grenada", "SA", "South America", "GD" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'GLP'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('GLP', '%s', '%s', '%s', '%s')", "Guadeloupe", "SA", "South America", "GP" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'GUM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('GUM', '%s', '%s', '%s', '%s')", "Guam", "OC", "Oceania", "GU" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'GTM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('GTM', '%s', '%s', '%s', '%s')", "Guatemala", "SA", "South America", "GT" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'GGY'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('GGY', '%s', '%s', '%s', '%s')", "Guernsey", "EU", "Europe", "GG" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'GIN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('GIN', '%s', '%s', '%s', '%s')", "Guinea", "AF", "Africa", "GN" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'GNB'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('GNB', '%s', '%s', '%s', '%s')", "Guinea-Bissau", "AF", "Africa", "GW" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'GUY'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('GUY', '%s', '%s', '%s', '%s')", "Guyana", "SA", "South America", "GY" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'HTI'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('HTI', '%s', '%s', '%s', '%s')", "Haiti", "SA", "South America", "HT" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'VAT'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('VAT', '%s', '%s', '%s', '%s')", "Holy See", "EU", "Europe", "VA" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'HND'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('HND', '%s', '%s', '%s', '%s')", "Honduras", "SA", "South America", "HN" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'HUN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('HUN', '%s', '%s', '%s', '%s')", "Hungary", "EU", "Europe", "HU" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ISL'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ISL', '%s', '%s', '%s', '%s')", "Iceland", "EU", "Europe", "IS" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'IND'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('IND', '%s', '%s', '%s', '%s')", "India", "SS", "South Asia", "IN" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'IDN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('IDN', '%s', '%s', '%s', '%s')", "Indonesia", "OC", "Oceania", "ID" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'IRN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('IRN', '%s', '%s', '%s', '%s')", "Iran (Islamic Republic of)", "ME", "Middle East", "IR" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'IRQ'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('IRQ', '%s', '%s', '%s', '%s')", "Iraq", "ME", "Middle East", "IQ" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'IRL'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('IRL', '%s', '%s', '%s', '%s')", "Ireland", "EU", "Europe", "IE" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'IMN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('IMN', '%s', '%s', '%s', '%s')", "Isle of Man", "EU", "Europe", "IM" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ISR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ISR', '%s', '%s', '%s', '%s')", "Israel", "ME", "Middle East", "IL" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ITA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ITA', '%s', '%s', '%s', '%s')", "Italy", "EU", "Europe", "IT" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'JAM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('JAM', '%s', '%s', '%s', '%s')", "Jamaica", "SA", "South America", "JM" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'JPN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('JPN', '%s', '%s', '%s', '%s')", "Japan", "SS", "South Asia", "JP" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'JEY'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('JEY', '%s', '%s', '%s', '%s')", "Jersey", "EU", "Europe", "JE" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'JOR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('JOR', '%s', '%s', '%s', '%s')", "Jordan", "ME", "Middle East", "JO" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'KAZ'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('KAZ', '%s', '%s', '%s', '%s')", "Kazakhstan", "NS", "North Asia", "KZ" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'KEN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('KEN', '%s', '%s', '%s', '%s')", "Kenya", "AF", "Africa", "KE" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'KIR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('KIR', '%s', '%s', '%s', '%s')", "Kiribati", "OC", "Oceania", "KI" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'KWT'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('KWT', '%s', '%s', '%s', '%s')", "Kuwait", "ME", "Middle East", "KW" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'KGZ'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('KGZ', '%s', '%s', '%s', '%s')", "Kyrgyzstan", "ME", "Middle East", "KG" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'LAO'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('LAO', '%s', '%s', '%s', '%s')", "Lao People's Democratic Republic", "SS", "South Asia", "LA" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'LVA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('LVA', '%s', '%s', '%s', '%s')", "Latvia", "EU", "Europe", "LV" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'LBN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('LBN', '%s', '%s', '%s', '%s')", "Lebanon", "ME", "Middle East", "LB" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'LSO'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('LSO', '%s', '%s', '%s', '%s')", "Lesotho", "AF", "Africa", "LS" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'LBR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('LBR', '%s', '%s', '%s', '%s')", "Liberia", "AF", "Africa", "LR" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'LBY'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('LBY', '%s', '%s', '%s', '%s')", "Libya", "AF", "Africa", "LY" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'LIE'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('LIE', '%s', '%s', '%s', '%s')", "Liechtenstein", "EU", "Europe", "LI" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'LTU'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('LTU', '%s', '%s', '%s', '%s')", "Lithuania", "EU", "Europe", "LT" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'LUX'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('LUX', '%s', '%s', '%s', '%s')", "Luxembourg", "EU", "Europe", "LU" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MDG'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MDG', '%s', '%s', '%s', '%s')", "Madagascar", "AF", "Africa", "MG" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MWI'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MWI', '%s', '%s', '%s', '%s')", "Malawi", "AF", "Africa", "MW" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MYS'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MYS', '%s', '%s', '%s', '%s')", "Malaysia", "OC", "Oceania", "MY" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MDV'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MDV', '%s', '%s', '%s', '%s')", "Maldives", "SS", "South Asia", "MV" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MLI'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MLI', '%s', '%s', '%s', '%s')", "Mali", "AF", "Africa", "ML" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MLT'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MLT', '%s', '%s', '%s', '%s')", "Malta", "EU", "Europe", "MT" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MHL'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MHL', '%s', '%s', '%s', '%s')", "Marshall Islands", "OC", "Oceania", "MH" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MTQ'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MTQ', '%s', '%s', '%s', '%s')", "Martinique", "SA", "South America", "MQ" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MRT'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MRT', '%s', '%s', '%s', '%s')", "Mauritania", "AF", "Africa", "MR" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MUS'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MUS', '%s', '%s', '%s', '%s')", "Mauritius", "AF", "Africa", "MU" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MYT'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MYT', '%s', '%s', '%s', '%s')", "Mayotte", "AF", "Africa", "YT" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MEX'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MEX', '%s', '%s', '%s', '%s')", "Mexico", "NA", "North America", "MX" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'FSM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('FSM', '%s', '%s', '%s', '%s')", "Micronesia (Federated States of)", "OC", "Oceania", "FM" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MCO'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MCO', '%s', '%s', '%s', '%s')", "Monaco", "EU", "Europe", "MC" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MNG'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MNG', '%s', '%s', '%s', '%s')", "Mongolia", "NS", "North Asia", "MN" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MNE'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MNE', '%s', '%s', '%s', '%s')", "Montenegro", "EU", "Europe", "ME" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MSR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MSR', '%s', '%s', '%s', '%s')", "Montserrat", "SA", "South America", "MS" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MAR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MAR', '%s', '%s', '%s', '%s')", "Morocco", "AF", "Africa", "MA" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MOZ'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MOZ', '%s', '%s', '%s', '%s')", "Mozambique", "AF", "Africa", "MZ" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MMR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MMR', '%s', '%s', '%s', '%s')", "Myanmar", "SS", "South Asia", "MM" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'NAM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('NAM', '%s', '%s', '%s', '%s')", "Namibia", "AF", "Africa", "NA" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'NRU'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('NRU', '%s', '%s', '%s', '%s')", "Nauru", "OC", "Oceania", "NR" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'NPL'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('NPL', '%s', '%s', '%s', '%s')", "Nepal", "SS", "South Asia", "NP" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'NLD'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('NLD', '%s', '%s', '%s', '%s')", "Netherlands", "EU", "Europe", "NL" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'NCL'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('NCL', '%s', '%s', '%s', '%s')", "New Caledonia", "OC", "Oceania", "NC" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'NZL'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('NZL', '%s', '%s', '%s', '%s')", "New Zealand", "OC", "Oceania", "NZ" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'NIC'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('NIC', '%s', '%s', '%s', '%s')", "Nicaragua", "SA", "South America", "NI" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'NER'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('NER', '%s', '%s', '%s', '%s')", "Niger", "AF", "Africa", "NE" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'NGA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('NGA', '%s', '%s', '%s', '%s')", "Nigeria", "AF", "Africa", "NG" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'NIU'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('NIU', '%s', '%s', '%s', '%s')", "Niue", "OC", "Oceania", "NU" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'NFK'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('NFK', '%s', '%s', '%s', '%s')", "Norfolk Island", "OC", "Oceania", "NF" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MNP'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MNP', '%s', '%s', '%s', '%s')", "Northern Mariana Islands", "OC", "Oceania", "MP" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'NOR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('NOR', '%s', '%s', '%s', '%s')", "Norway", "EU", "Europe", "NO" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'OMN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('OMN', '%s', '%s', '%s', '%s')", "Oman", "ME", "Middle East", "OM" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'PAK'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('PAK', '%s', '%s', '%s', '%s')", "Pakistan", "ME", "Middle East", "PK" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'PLW'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('PLW', '%s', '%s', '%s', '%s')", "Palau", "OC", "Oceania", "PW" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'PSE'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('PSE', '%s', '%s', '%s', '%s')", "Palestine", "ME", "Middle East", "PS" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'PAN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('PAN', '%s', '%s', '%s', '%s')", "Panama", "SA", "South America", "PA" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'PNG'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('PNG', '%s', '%s', '%s', '%s')", "Papua New Guinea", "OC", "Oceania", "PG" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'PRY'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('PRY', '%s', '%s', '%s', '%s')", "Paraguay", "SA", "South America", "PY" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'PER'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('PER', '%s', '%s', '%s', '%s')", "Peru", "SA", "South America", "PE" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'PHL'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('PHL', '%s', '%s', '%s', '%s')", "Philippines", "SS", "South Asia", "PH" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'PCN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('PCN', '%s', '%s', '%s', '%s')", "Pitcairn", "OC", "Oceania", "PN" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'POL'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('POL', '%s', '%s', '%s', '%s')", "Poland", "EU", "Europe", "PL" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'PRT'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('PRT', '%s', '%s', '%s', '%s')", "Portugal", "EU", "Europe", "PT" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'PRI'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('PRI', '%s', '%s', '%s', '%s')", "Puerto Rico", "SA", "South America", "PR" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'QAT'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('QAT', '%s', '%s', '%s', '%s')", "Qatar", "ME", "Middle East", "QA" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'KOR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('KOR', '%s', '%s', '%s', '%s')", "Republic of Korea", "SS", "South Asia", "KR" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MDA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MDA', '%s', '%s', '%s', '%s')", "Republic of Moldova", "EU", "Europe", "MD" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'REU'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('REU', '%s', '%s', '%s', '%s')", "Réunion", "AF", "Africa", "RE" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ROU'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ROU', '%s', '%s', '%s', '%s')", "Romania", "EU", "Europe", "RO" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'RUS'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('RUS', '%s', '%s', '%s', '%s')", "Russian Federation", "NS", "North Asia", "RU" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'RWA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('RWA', '%s', '%s', '%s', '%s')", "Rwanda", "AF", "Africa", "RW" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'BLM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('BLM', '%s', '%s', '%s', '%s')", "Saint Barthélemy", "SA", "South America", "BL" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SHN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SHN', '%s', '%s', '%s', '%s')", "Saint Helena", "AF", "Africa", "SH" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'KNA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('KNA', '%s', '%s', '%s', '%s')", "Saint Kitts and Nevis", "SA", "South America", "KN" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'LCA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('LCA', '%s', '%s', '%s', '%s')", "Saint Lucia", "SA", "South America", "LC" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MAF'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MAF', '%s', '%s', '%s', '%s')", "Saint Martin (French part)", "SA", "South America", "MF" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SPM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SPM', '%s', '%s', '%s', '%s')", "Saint Pierre and Miquelon", "NA", "North America", "PM" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'VCT'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('VCT', '%s', '%s', '%s', '%s')", "Saint Vincent and the Grenadines", "SA", "South America", "VC" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'WSM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('WSM', '%s', '%s', '%s', '%s')", "Samoa", "OC", "Oceania", "WS" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SMR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SMR', '%s', '%s', '%s', '%s')", "San Marino", "EU", "Europe", "SM" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'STP'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('STP', '%s', '%s', '%s', '%s')", "Sao Tome and Principe", "AF", "Africa", "ST" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SAU'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SAU', '%s', '%s', '%s', '%s')", "Saudi Arabia", "ME", "Middle East", "SA" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SEN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SEN', '%s', '%s', '%s', '%s')", "Senegal", "AF", "Africa", "SN" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SRB'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SRB', '%s', '%s', '%s', '%s')", "Serbia", "EU", "Europe", "RS" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SYC'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SYC', '%s', '%s', '%s', '%s')", "Seychelles", "AF", "Africa", "SC" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SLE'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SLE', '%s', '%s', '%s', '%s')", "Sierra Leone", "AF", "Africa", "SL" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SGP'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SGP', '%s', '%s', '%s', '%s')", "Singapore", "SS", "South Asia", "SG" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SXM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SXM', '%s', '%s', '%s', '%s')", "Sint Maarten (Dutch part)", "SA", "South America", "SX" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SVK'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SVK', '%s', '%s', '%s', '%s')", "Slovakia", "EU", "Europe", "SK" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SVN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SVN', '%s', '%s', '%s', '%s')", "Slovenia", "EU", "Europe", "SI" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SLB'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SLB', '%s', '%s', '%s', '%s')", "Solomon Islands", "OC", "Oceania", "SB" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SOM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SOM', '%s', '%s', '%s', '%s')", "Somalia", "AF", "Africa", "SO" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ZAF'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ZAF', '%s', '%s', '%s', '%s')", "South Africa", "AF", "Africa", "ZA" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SSD'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SSD', '%s', '%s', '%s', '%s')", "South Sudan", "AF", "Africa", "SS" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ESP'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ESP', '%s', '%s', '%s', '%s')", "Spain", "EU", "Europe", "ES" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'LKA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('LKA', '%s', '%s', '%s', '%s')", "Sri Lanka", "SS", "South Asia", "LK" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SDN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SDN', '%s', '%s', '%s', '%s')", "Sudan", "AF", "Africa", "SD" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SUR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SUR', '%s', '%s', '%s', '%s')", "Suriname", "SA", "South America", "SR" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SJM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SJM', '%s', '%s', '%s', '%s')", "Svalbard and Jan Mayen Islands", "EU", "Europe", "SJ" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SWZ'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SWZ', '%s', '%s', '%s', '%s')", "Swaziland", "AF", "Africa", "SZ" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SWE'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SWE', '%s', '%s', '%s', '%s')", "Sweden", "EU", "Europe", "SE" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'CHE'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('CHE', '%s', '%s', '%s', '%s')", "Switzerland", "EU", "Europe", "CH" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'SYR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('SYR', '%s', '%s', '%s', '%s')", "Syrian Arab Republic", "ME", "Middle East", "SY" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'TWN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('TWN', '%s', '%s', '%s', '%s')", "Taiwan", "SS", "South Asia", "TW" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'TJK'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('TJK', '%s', '%s', '%s', '%s')", "Tajikistan", "ME", "Middle East", "TJ" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'THA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('THA', '%s', '%s', '%s', '%s')", "Thailand", "SS", "South Asia", "TH" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'MKD'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('MKD', '%s', '%s', '%s', '%s')", "The former Yugoslav Republic of Macedonia", "EU", "Europe", "MK" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'TLS'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('TLS', '%s', '%s', '%s', '%s')", "Timor-Leste", "OC", "Oceania", "TL" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'TGO'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('TGO', '%s', '%s', '%s', '%s')", "Togo", "AF", "Africa", "TG" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'TKL'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('TKL', '%s', '%s', '%s', '%s')", "Tokelau", "OC", "Oceania", "TK" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'TON'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('TON', '%s', '%s', '%s', '%s')", "Tonga", "OC", "Oceania", "TO" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'TTO'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('TTO', '%s', '%s', '%s', '%s')", "Trinidad and Tobago", "SA", "South America", "TT" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'TUN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('TUN', '%s', '%s', '%s', '%s')", "Tunisia", "AF", "Africa", "TN" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'TUR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('TUR', '%s', '%s', '%s', '%s')", "Turkey", "EU", "Europe", "TR" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'TKM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('TKM', '%s', '%s', '%s', '%s')", "Turkmenistan", "ME", "Middle East", "TM" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'TCA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('TCA', '%s', '%s', '%s', '%s')", "Turks and Caicos Islands", "SA", "South America", "TC" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'TUV'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('TUV', '%s', '%s', '%s', '%s')", "Tuvalu", "OC", "Oceania", "TV" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'UGA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('UGA', '%s', '%s', '%s', '%s')", "Uganda", "AF", "Africa", "UG" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'UKR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('UKR', '%s', '%s', '%s', '%s')", "Ukraine", "EU", "Europe", "UA" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ARE'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ARE', '%s', '%s', '%s', '%s')", "United Arab Emirates", "ME", "Middle East", "AE" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'GBR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('GBR', '%s', '%s', '%s', '%s')", "United Kingdom of Great Britain and Northern Ireland", "EU", "Europe", "GB" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'TZA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('TZA', '%s', '%s', '%s', '%s')", "United Republic of Tanzania", "AF", "Africa", "TZ" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'USA'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('USA', '%s', '%s', '%s', '%s')", "United States of America", "NA", "North America", "US" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'VIR'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('VIR', '%s', '%s', '%s', '%s')", "United States Virgin Islands", "SA", "South America", "VI" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'URY'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('URY', '%s', '%s', '%s', '%s')", "Uruguay", "SA", "South America", "UY" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'UZB'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('UZB', '%s', '%s', '%s', '%s')", "Uzbekistan", "ME", "Middle East", "ZU" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'VUT'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('VUT', '%s', '%s', '%s', '%s')", "Vanuatu", "OC", "Oceania", "VU" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'VEN'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('VEN', '%s', '%s', '%s', '%s')", "Venezuela (Bolivarian Republic of)", "SA", "South America", "VE" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'VNM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('VNM', '%s', '%s', '%s', '%s')", "Viet Nam", "SS", "South Asia", "VN" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'WLF'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('WLF', '%s', '%s', '%s', '%s')", "Wallis and Futuna Islands", "OC", "Oceania", "WF" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ESH'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ESH', '%s', '%s', '%s', '%s')", "Western Sahara", "AF", "Africa", "EH" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'YEM'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('YEM', '%s', '%s', '%s', '%s')", "Yemen", "ME", "Middle East", "YE" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ZMB'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ZMB', '%s', '%s', '%s', '%s')", "Zambia", "AF", "Africa", "ZM" ));
}
if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'ZWE'") == 0) {
    $wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('ZWE', '%s', '%s', '%s', '%s')", "Zimbabwe", "AF", "Africa", "ZW" ));
}
?>