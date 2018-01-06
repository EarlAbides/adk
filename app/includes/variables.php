<?php
	
	function select_state($default){
		if(!$default) $default = 'NY';
		$states = array('AK', 'AL', 'AR', 'AZ', 'CA', 'CO', 'CT', 'DC', 'DE', 'FL', 'GA', 'HI', 'IA', 'ID', 
		'IL', 'IN', 'KS', 'KY', 'LA', 'MA', 'MD', 'ME', 'MI', 'MN', 'MO', 'MS', 'MT', 'NC', 'ND', 'NE', 
		'NH', 'NJ', 'NM', 'NV', 'NY', 'OH', 'OK', 'OR', 'PA', 'PR', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 
		'VA', 'VT', 'WA', 'WI', 'WV', 'WY');
		
		$select_state = '<select id="select_state" name="state" class="form-control form-control-sm" placeholder="State" required>';
		
		for($i = 0; $i < count($states); $i++){
			if($states[$i] == $default) $select_state .= '<option value="'.$states[$i].'" selected>'.$states[$i].'</option>';
			else $select_state .= '<option value="'.$states[$i].'">'.$states[$i].'</option>';
		}
		$select_state .= '</select>';
		
		return $select_state;
	}
	
	function select_state_ca($default){
		if(!$default) $default = 'ON';
		$states = array('AB', 'BC', 'MB', 'NB', 'NL', 'NS', 'NT', 'NU', 'ON', 'PE', 'QC', 'SK', 'YT');
		
		$select_state = '<select id="select_state" name="state" class="form-control form-control-sm" placeholder="State" required>';
		
		for($i = 0; $i < count($states); $i++){
			if($states[$i] == $default) $select_state .= '<option value="'.$states[$i].'" selected>'.$states[$i].'</option>';
			else $select_state .= '<option value="'.$states[$i].'">'.$states[$i].'</option>';
		}
		$select_state .= '</select>';
		
		return $select_state;
	}
	
	function textbox_stateregion($default){
		if(!$default) $default = '';
		return '<input type="text" id="select_state" name="state" class="form-control form-control-sm" value="'.$default.'" placeholder="State or Region" maxlength="2" required>';
	}
	
	function select_country($default){
		if(!$default) $default = 'United States';
		$countries = array('Afghanistan', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 
		'Anguilla', 'Antigua &amp; Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 
		'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 
		'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bonaire', 'Bosnia &amp; Herzegovina', 'Botswana', 
		'Brazil', 'British Indian Ocean Ter', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia', 
		'Cameroon', 'Canada', 'Canary Islands', 'Cape Verde', 'Cayman Islands', 'Central African Republic', 
		'Chad', 'Channel Islands', 'Chile', 'China', 'Christmas Island', 'Cocos Island', 'Colombia', 
		'Comoros', 'Congo', 'Cook Islands', 'Costa Rica', 'Cote D\'Ivoire', 'Croatia', 'Cuba', 'Curacao', 
		'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'East Timor', 
		'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 
		'Falkland Islands', 'Faroe Islands', 'Fiji', 'Finland', 'France', 'French Guiana', 'French Polynesia', 
		'French Southern Ter', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Great Britain', 
		'Greece', 'Greenland', 'Grenada', 'Guadeloupe', 'Guam', 'Guatemala', 'Guinea', 'Guyana', 'Haiti', 
		'Hawaii', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 
		'Isle of Man', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 
		'Korea North', 'Korea South', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 
		'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia', 'Madagascar', 
		'Malaysia', 'Malawi', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Martinique', 'Mauritania', 
		'Mauritius', 'Mayotte', 'Mexico', 'Midway Islands', 'Moldova', 'Monaco', 'Mongolia', 'Montserrat', 
		'Morocco', 'Mozambique', 'Myanmar', 'Nambia', 'Nauru', 'Nepal', 'Netherland Antilles', 
		'Netherlands (Holland, Europe)', 'Nevis', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 
		'Nigeria', 'Niue', 'Norfolk Island', 'Norway', 'Oman', 'Pakistan', 'Palau Island', 'Palestine', 
		'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Pitcairn Island', 'Poland', 
		'Portugal', 'Puerto Rico', 'Qatar', 'Republic of Montenegro', 'Republic of Serbia', 'Reunion', 
		'Romania', 'Russia', 'Rwanda', 'St Barthelemy', 'St Eustatius', 'St Helena', 'St Kitts-Nevis', 
		'St Lucia', 'St Maarten', 'St Pierre &amp; Miquelon', 'St Vincent &amp; Grenadines', 'Saipan', 
		'Samoa', 'Samoa American', 'San Marino', 'Sao Tome &amp; Principe', 'Saudi Arabia', 'Senegal', 
		'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands', 
		'Somalia', 'South Africa', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Swaziland', 'Sweden', 
		'Switzerland', 'Syria', 'Tahiti', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Togo', 
		'Tokelau', 'Tonga', 'Trinidad &amp; Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 
		'Turks &amp; Caicos Is', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 
		'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City State', 'Venezuela', 'Vietnam', 
		'Virgin Islands (Brit)', 'Virgin Islands (USA)', 'Wake Island', 'Wallis &amp; Futana Is', 
		'Yemen', 'Zaire', 'Zambia', 'Zimbabwe');
		
		$select_country = '<select id="select_country" name="country" class="form-control form-control-sm" placeholder="Country" required>';
		$select_country .= '<option></option>';
		
		for($i = 0; $i < count($countries); $i++){
			if($countries[$i] == $default) $select_country .= '<option value="'.$countries[$i].'" selected>'.$countries[$i].'</option>';
			else $select_country .= '<option value="'.$countries[$i].'">'.$countries[$i].'</option>';
		}
		$select_country .= '</select>';
		
		
		return $select_country;
	}
	
	
	
	$select_peak = '<option></option>';
	$select_peak .= '<option value="Marcy">Marcy</option>';
	$select_peak .= '<option value="Algonquin">Algonquin</option>';
	$select_peak .= '<option value="Haystack">Haystack</option>';
	$select_peak .= '<option value="Skylight">Skylight</option>';
	$select_peak .= '<option value="Whiteface">Whiteface</option>';
	$select_peak .= '<option value="Dix">Dix</option>';
	$select_peak .= '<option value="Gray">Gray</option>';
	$select_peak .= '<option value="Iroquois">Iroquois</option>';
	$select_peak .= '<option value="Basin">Basin</option>';
	$select_peak .= '<option value="Gothics">Gothics</option>';
	$select_peak .= '<option value="Colden">Colden</option>';
	$select_peak .= '<option value="Giant">Giant</option>';
	$select_peak .= '<option value="Nippletop">Nippletop</option>';
	$select_peak .= '<option value="Santanoni">Santanoni</option>';
	$select_peak .= '<option value="Redfield">Redfield</option>';
	$select_peak .= '<option value="Wright">Wright</option>';
	$select_peak .= '<option value="Saddleback">Saddleback</option>';
	$select_peak .= '<option value="Panther">Panther</option>';
	$select_peak .= '<option value="Tabletop">Tabletop</option>';
	$select_peak .= '<option value="Rocky Peak Ridge">Rocky Peak Ridge</option>';
	$select_peak .= '<option value="Macomb">Macomb</option>';
	$select_peak .= '<option value="Armstrong">Armstrong</option>';
	$select_peak .= '<option value="Hough">Hough</option>';
	$select_peak .= '<option value="Seward">Seward</option>';
	$select_peak .= '<option value="Marshall">Marshall</option>';
	$select_peak .= '<option value="Allen">Allen</option>';
	$select_peak .= '<option value="Big Slide">Big Slide</option>';
	$select_peak .= '<option value="Esther">Esther</option>';
	$select_peak .= '<option value="Upper Wolf Jaw">Upper Wolf Jaw</option>';
	$select_peak .= '<option value="Lower Wolf Jaw">Lower Wolf Jaw</option>';
	$select_peak .= '<option value="Street">Street</option>';//
	$select_peak .= '<option value="Phelps">Phelps</option>';
	$select_peak .= '<option value="Donaldson">Donaldson</option>';
	$select_peak .= '<option value="Seymour">Seymour</option>';
	$select_peak .= '<option value="Sawteeth">Sawteeth</option>';
	$select_peak .= '<option value="Cascade">Cascade</option>';
	$select_peak .= '<option value="South Dix">South Dix</option>';
	$select_peak .= '<option value="Porter">Porter</option>';
	$select_peak .= '<option value="Colvin">Colvin</option>';
	$select_peak .= '<option value="Emmons">Emmons</option>';
	$select_peak .= '<option value="Dial">Dial</option>';
	$select_peak .= '<option value="East Dix">East Dix</option>';
	$select_peak .= '<option value="Blake">Blake</option>';
	$select_peak .= '<option value="Cliff">Cliff</option>';
	$select_peak .= '<option value="Nye">Nye</option>';
	$select_peak .= '<option value="Couchsachraga">Couchsachraga</option>';
	$select_peak .= '</select>';
	
	$select_firstpeak = '<select id="select_firstpeak" name="select_firstpeak" placeholder="First peak">'.$select_peak;
	$select_lastpeak = '<select id="select_lastpeak" name="select_lastpeak" placeholder="Last peak">'.$select_peak;
	
?>
