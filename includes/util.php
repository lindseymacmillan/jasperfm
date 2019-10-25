<?php
/**
 * Useful functions.
 *
 * @package JasperFM
 */

namespace JasperFM;

defined( 'ABSPATH' ) || exit;

function acf_get_fields_in_group( $group_id ) {
    $acf_meta = get_post_custom( $group_id );
    $acf_fields = array();

    foreach ( $acf_meta as $key => $val ) {
        if ( preg_match( "/^field_/", $key ) ) {
            $acf_fields[$key] = $val;
        }
    }

    return $acf_fields;
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 *
 * @param string|array $var Data to sanitize.
 * @return string|array
 */
function jasperfm_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'jasperfm_clean', $var );
	} else {
		return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
	}
}

/**
 * Converts a string (e.g. 'yes' or 'no') to a bool.
 *
 * @param string $string String to convert.
 * @return bool
 */
function jasperfm_string_to_bool( $string ) {
	return is_bool( $string ) ? $string : ( 'yes' === $string || 1 === $string || 'true' === $string || '1' === $string );
}

/**
 * Activate the JasperFM theme (installing it if necessary).
 *
 * @return bool | WP_Error True on success. WP_Error on failure.
 */
function jasperfm_install_activate_theme() {
	$theme_slug = 'jasperfm-theme';
	$theme_url  = 'https://github.com/Automattic/jasperfm-theme/releases/latest/download/jasperfm-theme.zip';

	$theme_object = wp_get_theme( $theme_slug );
	if ( ! $theme_object->exists() ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		include_once ABSPATH . 'wp-admin/includes/theme.php';
		WP_Filesystem();

		$skin     = new \Automatic_Upgrader_Skin();
		$upgrader = new \Theme_Upgrader( $skin );
		$success  = $upgrader->install( $theme_url );

		if ( is_wp_error( $success ) ) {
			return $success;
		} else if ( $success ) {
			// Make sure `-master` or `-1.0.1` etc. are not in the theme folder name.
			// We just want the folder name to be the theme slug.
			$theme_object    = $upgrader->theme_info();
			$theme_folder    = $theme_object->get_template_directory();
			$expected_folder = $theme_object->get_theme_root() . '/' . $theme_slug;
			if ( $theme_folder !== $expected_folder ) {
				rename( $theme_folder, $expected_folder );
			}
		} else {
			return new \WP_Error(
				'jasperfm_theme_failed_install',
				__( 'JasperFM theme installation failed.', 'jasperfm' )
			);
		}
	}

	switch_theme( $theme_slug );
	return true;
}

/**
 * Get full list of currency codes. Copied from https://github.com/woocommerce/woocommerce/blob/master/includes/wc-core-functions.php
 *
 * @return array
 */
function jasperfm_currencies() {
	$currencies = array(
		'AED' => __( 'United Arab Emirates dirham', 'jasperfm' ),
		'AFN' => __( 'Afghan afghani', 'jasperfm' ),
		'ALL' => __( 'Albanian lek', 'jasperfm' ),
		'AMD' => __( 'Armenian dram', 'jasperfm' ),
		'ANG' => __( 'Netherlands Antillean guilder', 'jasperfm' ),
		'AOA' => __( 'Angolan kwanza', 'jasperfm' ),
		'ARS' => __( 'Argentine peso', 'jasperfm' ),
		'AUD' => __( 'Australian dollar', 'jasperfm' ),
		'AWG' => __( 'Aruban florin', 'jasperfm' ),
		'AZN' => __( 'Azerbaijani manat', 'jasperfm' ),
		'BAM' => __( 'Bosnia and Herzegovina convertible mark', 'jasperfm' ),
		'BBD' => __( 'Barbadian dollar', 'jasperfm' ),
		'BDT' => __( 'Bangladeshi taka', 'jasperfm' ),
		'BGN' => __( 'Bulgarian lev', 'jasperfm' ),
		'BHD' => __( 'Bahraini dinar', 'jasperfm' ),
		'BIF' => __( 'Burundian franc', 'jasperfm' ),
		'BMD' => __( 'Bermudian dollar', 'jasperfm' ),
		'BND' => __( 'Brunei dollar', 'jasperfm' ),
		'BOB' => __( 'Bolivian boliviano', 'jasperfm' ),
		'BRL' => __( 'Brazilian real', 'jasperfm' ),
		'BSD' => __( 'Bahamian dollar', 'jasperfm' ),
		'BTC' => __( 'Bitcoin', 'jasperfm' ),
		'BTN' => __( 'Bhutanese ngultrum', 'jasperfm' ),
		'BWP' => __( 'Botswana pula', 'jasperfm' ),
		'BYR' => __( 'Belarusian ruble (old)', 'jasperfm' ),
		'BYN' => __( 'Belarusian ruble', 'jasperfm' ),
		'BZD' => __( 'Belize dollar', 'jasperfm' ),
		'CAD' => __( 'Canadian dollar', 'jasperfm' ),
		'CDF' => __( 'Congolese franc', 'jasperfm' ),
		'CHF' => __( 'Swiss franc', 'jasperfm' ),
		'CLP' => __( 'Chilean peso', 'jasperfm' ),
		'CNY' => __( 'Chinese yuan', 'jasperfm' ),
		'COP' => __( 'Colombian peso', 'jasperfm' ),
		'CRC' => __( 'Costa Rican col&oacute;n', 'jasperfm' ),
		'CUC' => __( 'Cuban convertible peso', 'jasperfm' ),
		'CUP' => __( 'Cuban peso', 'jasperfm' ),
		'CVE' => __( 'Cape Verdean escudo', 'jasperfm' ),
		'CZK' => __( 'Czech koruna', 'jasperfm' ),
		'DJF' => __( 'Djiboutian franc', 'jasperfm' ),
		'DKK' => __( 'Danish krone', 'jasperfm' ),
		'DOP' => __( 'Dominican peso', 'jasperfm' ),
		'DZD' => __( 'Algerian dinar', 'jasperfm' ),
		'EGP' => __( 'Egyptian pound', 'jasperfm' ),
		'ERN' => __( 'Eritrean nakfa', 'jasperfm' ),
		'ETB' => __( 'Ethiopian birr', 'jasperfm' ),
		'EUR' => __( 'Euro', 'jasperfm' ),
		'FJD' => __( 'Fijian dollar', 'jasperfm' ),
		'FKP' => __( 'Falkland Islands pound', 'jasperfm' ),
		'GBP' => __( 'Pound sterling', 'jasperfm' ),
		'GEL' => __( 'Georgian lari', 'jasperfm' ),
		'GGP' => __( 'Guernsey pound', 'jasperfm' ),
		'GHS' => __( 'Ghana cedi', 'jasperfm' ),
		'GIP' => __( 'Gibraltar pound', 'jasperfm' ),
		'GMD' => __( 'Gambian dalasi', 'jasperfm' ),
		'GNF' => __( 'Guinean franc', 'jasperfm' ),
		'GTQ' => __( 'Guatemalan quetzal', 'jasperfm' ),
		'GYD' => __( 'Guyanese dollar', 'jasperfm' ),
		'HKD' => __( 'Hong Kong dollar', 'jasperfm' ),
		'HNL' => __( 'Honduran lempira', 'jasperfm' ),
		'HRK' => __( 'Croatian kuna', 'jasperfm' ),
		'HTG' => __( 'Haitian gourde', 'jasperfm' ),
		'HUF' => __( 'Hungarian forint', 'jasperfm' ),
		'IDR' => __( 'Indonesian rupiah', 'jasperfm' ),
		'ILS' => __( 'Israeli new shekel', 'jasperfm' ),
		'IMP' => __( 'Manx pound', 'jasperfm' ),
		'INR' => __( 'Indian rupee', 'jasperfm' ),
		'IQD' => __( 'Iraqi dinar', 'jasperfm' ),
		'IRR' => __( 'Iranian rial', 'jasperfm' ),
		'IRT' => __( 'Iranian toman', 'jasperfm' ),
		'ISK' => __( 'Icelandic kr&oacute;na', 'jasperfm' ),
		'JEP' => __( 'Jersey pound', 'jasperfm' ),
		'JMD' => __( 'Jamaican dollar', 'jasperfm' ),
		'JOD' => __( 'Jordanian dinar', 'jasperfm' ),
		'JPY' => __( 'Japanese yen', 'jasperfm' ),
		'KES' => __( 'Kenyan shilling', 'jasperfm' ),
		'KGS' => __( 'Kyrgyzstani som', 'jasperfm' ),
		'KHR' => __( 'Cambodian riel', 'jasperfm' ),
		'KMF' => __( 'Comorian franc', 'jasperfm' ),
		'KPW' => __( 'North Korean won', 'jasperfm' ),
		'KRW' => __( 'South Korean won', 'jasperfm' ),
		'KWD' => __( 'Kuwaiti dinar', 'jasperfm' ),
		'KYD' => __( 'Cayman Islands dollar', 'jasperfm' ),
		'KZT' => __( 'Kazakhstani tenge', 'jasperfm' ),
		'LAK' => __( 'Lao kip', 'jasperfm' ),
		'LBP' => __( 'Lebanese pound', 'jasperfm' ),
		'LKR' => __( 'Sri Lankan rupee', 'jasperfm' ),
		'LRD' => __( 'Liberian dollar', 'jasperfm' ),
		'LSL' => __( 'Lesotho loti', 'jasperfm' ),
		'LYD' => __( 'Libyan dinar', 'jasperfm' ),
		'MAD' => __( 'Moroccan dirham', 'jasperfm' ),
		'MDL' => __( 'Moldovan leu', 'jasperfm' ),
		'MGA' => __( 'Malagasy ariary', 'jasperfm' ),
		'MKD' => __( 'Macedonian denar', 'jasperfm' ),
		'MMK' => __( 'Burmese kyat', 'jasperfm' ),
		'MNT' => __( 'Mongolian t&ouml;gr&ouml;g', 'jasperfm' ),
		'MOP' => __( 'Macanese pataca', 'jasperfm' ),
		'MRO' => __( 'Mauritanian ouguiya', 'jasperfm' ),
		'MUR' => __( 'Mauritian rupee', 'jasperfm' ),
		'MVR' => __( 'Maldivian rufiyaa', 'jasperfm' ),
		'MWK' => __( 'Malawian kwacha', 'jasperfm' ),
		'MXN' => __( 'Mexican peso', 'jasperfm' ),
		'MYR' => __( 'Malaysian ringgit', 'jasperfm' ),
		'MZN' => __( 'Mozambican metical', 'jasperfm' ),
		'NAD' => __( 'Namibian dollar', 'jasperfm' ),
		'NGN' => __( 'Nigerian naira', 'jasperfm' ),
		'NIO' => __( 'Nicaraguan c&oacute;rdoba', 'jasperfm' ),
		'NOK' => __( 'Norwegian krone', 'jasperfm' ),
		'NPR' => __( 'Nepalese rupee', 'jasperfm' ),
		'NZD' => __( 'New Zealand dollar', 'jasperfm' ),
		'OMR' => __( 'Omani rial', 'jasperfm' ),
		'PAB' => __( 'Panamanian balboa', 'jasperfm' ),
		'PEN' => __( 'Sol', 'jasperfm' ),
		'PGK' => __( 'Papua New Guinean kina', 'jasperfm' ),
		'PHP' => __( 'Philippine peso', 'jasperfm' ),
		'PKR' => __( 'Pakistani rupee', 'jasperfm' ),
		'PLN' => __( 'Polish z&#x142;oty', 'jasperfm' ),
		'PRB' => __( 'Transnistrian ruble', 'jasperfm' ),
		'PYG' => __( 'Paraguayan guaran&iacute;', 'jasperfm' ),
		'QAR' => __( 'Qatari riyal', 'jasperfm' ),
		'RON' => __( 'Romanian leu', 'jasperfm' ),
		'RSD' => __( 'Serbian dinar', 'jasperfm' ),
		'RUB' => __( 'Russian ruble', 'jasperfm' ),
		'RWF' => __( 'Rwandan franc', 'jasperfm' ),
		'SAR' => __( 'Saudi riyal', 'jasperfm' ),
		'SBD' => __( 'Solomon Islands dollar', 'jasperfm' ),
		'SCR' => __( 'Seychellois rupee', 'jasperfm' ),
		'SDG' => __( 'Sudanese pound', 'jasperfm' ),
		'SEK' => __( 'Swedish krona', 'jasperfm' ),
		'SGD' => __( 'Singapore dollar', 'jasperfm' ),
		'SHP' => __( 'Saint Helena pound', 'jasperfm' ),
		'SLL' => __( 'Sierra Leonean leone', 'jasperfm' ),
		'SOS' => __( 'Somali shilling', 'jasperfm' ),
		'SRD' => __( 'Surinamese dollar', 'jasperfm' ),
		'SSP' => __( 'South Sudanese pound', 'jasperfm' ),
		'STD' => __( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe dobra', 'jasperfm' ),
		'SYP' => __( 'Syrian pound', 'jasperfm' ),
		'SZL' => __( 'Swazi lilangeni', 'jasperfm' ),
		'THB' => __( 'Thai baht', 'jasperfm' ),
		'TJS' => __( 'Tajikistani somoni', 'jasperfm' ),
		'TMT' => __( 'Turkmenistan manat', 'jasperfm' ),
		'TND' => __( 'Tunisian dinar', 'jasperfm' ),
		'TOP' => __( 'Tongan pa&#x2bb;anga', 'jasperfm' ),
		'TRY' => __( 'Turkish lira', 'jasperfm' ),
		'TTD' => __( 'Trinidad and Tobago dollar', 'jasperfm' ),
		'TWD' => __( 'New Taiwan dollar', 'jasperfm' ),
		'TZS' => __( 'Tanzanian shilling', 'jasperfm' ),
		'UAH' => __( 'Ukrainian hryvnia', 'jasperfm' ),
		'UGX' => __( 'Ugandan shilling', 'jasperfm' ),
		'USD' => __( 'United States (US) dollar', 'jasperfm' ),
		'UYU' => __( 'Uruguayan peso', 'jasperfm' ),
		'UZS' => __( 'Uzbekistani som', 'jasperfm' ),
		'VEF' => __( 'Venezuelan bol&iacute;var', 'jasperfm' ),
		'VES' => __( 'Bol&iacute;var soberano', 'jasperfm' ),
		'VND' => __( 'Vietnamese &#x111;&#x1ed3;ng', 'jasperfm' ),
		'VUV' => __( 'Vanuatu vatu', 'jasperfm' ),
		'WST' => __( 'Samoan t&#x101;l&#x101;', 'jasperfm' ),
		'XAF' => __( 'Central African CFA franc', 'jasperfm' ),
		'XCD' => __( 'East Caribbean dollar', 'jasperfm' ),
		'XOF' => __( 'West African CFA franc', 'jasperfm' ),
		'XPF' => __( 'CFP franc', 'jasperfm' ),
		'YER' => __( 'Yemeni rial', 'jasperfm' ),
		'ZAR' => __( 'South African rand', 'jasperfm' ),
		'ZMW' => __( 'Zambian kwacha', 'jasperfm' ),
	);
	return $currencies;
}

/**
 * Get full list of country codes. Copied from https://github.com/woocommerce/woocommerce/blob/master/includes/class-wc-countries.php
 *
 * @return array
 */
function jasperfm_countries() {
	$countries = array(
		'AF' => __( 'Afghanistan', 'jasperfm' ),
		'AX' => __( '&#197;land Islands', 'jasperfm' ),
		'AL' => __( 'Albania', 'jasperfm' ),
		'DZ' => __( 'Algeria', 'jasperfm' ),
		'AS' => __( 'American Samoa', 'jasperfm' ),
		'AD' => __( 'Andorra', 'jasperfm' ),
		'AO' => __( 'Angola', 'jasperfm' ),
		'AI' => __( 'Anguilla', 'jasperfm' ),
		'AQ' => __( 'Antarctica', 'jasperfm' ),
		'AG' => __( 'Antigua and Barbuda', 'jasperfm' ),
		'AR' => __( 'Argentina', 'jasperfm' ),
		'AM' => __( 'Armenia', 'jasperfm' ),
		'AW' => __( 'Aruba', 'jasperfm' ),
		'AU' => __( 'Australia', 'jasperfm' ),
		'AT' => __( 'Austria', 'jasperfm' ),
		'AZ' => __( 'Azerbaijan', 'jasperfm' ),
		'BS' => __( 'Bahamas', 'jasperfm' ),
		'BH' => __( 'Bahrain', 'jasperfm' ),
		'BD' => __( 'Bangladesh', 'jasperfm' ),
		'BB' => __( 'Barbados', 'jasperfm' ),
		'BY' => __( 'Belarus', 'jasperfm' ),
		'BE' => __( 'Belgium', 'jasperfm' ),
		'PW' => __( 'Belau', 'jasperfm' ),
		'BZ' => __( 'Belize', 'jasperfm' ),
		'BJ' => __( 'Benin', 'jasperfm' ),
		'BM' => __( 'Bermuda', 'jasperfm' ),
		'BT' => __( 'Bhutan', 'jasperfm' ),
		'BO' => __( 'Bolivia', 'jasperfm' ),
		'BQ' => __( 'Bonaire, Saint Eustatius and Saba', 'jasperfm' ),
		'BA' => __( 'Bosnia and Herzegovina', 'jasperfm' ),
		'BW' => __( 'Botswana', 'jasperfm' ),
		'BV' => __( 'Bouvet Island', 'jasperfm' ),
		'BR' => __( 'Brazil', 'jasperfm' ),
		'IO' => __( 'British Indian Ocean Territory', 'jasperfm' ),
		'BN' => __( 'Brunei', 'jasperfm' ),
		'BG' => __( 'Bulgaria', 'jasperfm' ),
		'BF' => __( 'Burkina Faso', 'jasperfm' ),
		'BI' => __( 'Burundi', 'jasperfm' ),
		'KH' => __( 'Cambodia', 'jasperfm' ),
		'CM' => __( 'Cameroon', 'jasperfm' ),
		'CA' => __( 'Canada', 'jasperfm' ),
		'CV' => __( 'Cape Verde', 'jasperfm' ),
		'KY' => __( 'Cayman Islands', 'jasperfm' ),
		'CF' => __( 'Central African Republic', 'jasperfm' ),
		'TD' => __( 'Chad', 'jasperfm' ),
		'CL' => __( 'Chile', 'jasperfm' ),
		'CN' => __( 'China', 'jasperfm' ),
		'CX' => __( 'Christmas Island', 'jasperfm' ),
		'CC' => __( 'Cocos (Keeling) Islands', 'jasperfm' ),
		'CO' => __( 'Colombia', 'jasperfm' ),
		'KM' => __( 'Comoros', 'jasperfm' ),
		'CG' => __( 'Congo (Brazzaville)', 'jasperfm' ),
		'CD' => __( 'Congo (Kinshasa)', 'jasperfm' ),
		'CK' => __( 'Cook Islands', 'jasperfm' ),
		'CR' => __( 'Costa Rica', 'jasperfm' ),
		'HR' => __( 'Croatia', 'jasperfm' ),
		'CU' => __( 'Cuba', 'jasperfm' ),
		'CW' => __( 'Cura&ccedil;ao', 'jasperfm' ),
		'CY' => __( 'Cyprus', 'jasperfm' ),
		'CZ' => __( 'Czech Republic', 'jasperfm' ),
		'DK' => __( 'Denmark', 'jasperfm' ),
		'DJ' => __( 'Djibouti', 'jasperfm' ),
		'DM' => __( 'Dominica', 'jasperfm' ),
		'DO' => __( 'Dominican Republic', 'jasperfm' ),
		'EC' => __( 'Ecuador', 'jasperfm' ),
		'EG' => __( 'Egypt', 'jasperfm' ),
		'SV' => __( 'El Salvador', 'jasperfm' ),
		'GQ' => __( 'Equatorial Guinea', 'jasperfm' ),
		'ER' => __( 'Eritrea', 'jasperfm' ),
		'EE' => __( 'Estonia', 'jasperfm' ),
		'ET' => __( 'Ethiopia', 'jasperfm' ),
		'FK' => __( 'Falkland Islands', 'jasperfm' ),
		'FO' => __( 'Faroe Islands', 'jasperfm' ),
		'FJ' => __( 'Fiji', 'jasperfm' ),
		'FI' => __( 'Finland', 'jasperfm' ),
		'FR' => __( 'France', 'jasperfm' ),
		'GF' => __( 'French Guiana', 'jasperfm' ),
		'PF' => __( 'French Polynesia', 'jasperfm' ),
		'TF' => __( 'French Southern Territories', 'jasperfm' ),
		'GA' => __( 'Gabon', 'jasperfm' ),
		'GM' => __( 'Gambia', 'jasperfm' ),
		'GE' => __( 'Georgia', 'jasperfm' ),
		'DE' => __( 'Germany', 'jasperfm' ),
		'GH' => __( 'Ghana', 'jasperfm' ),
		'GI' => __( 'Gibraltar', 'jasperfm' ),
		'GR' => __( 'Greece', 'jasperfm' ),
		'GL' => __( 'Greenland', 'jasperfm' ),
		'GD' => __( 'Grenada', 'jasperfm' ),
		'GP' => __( 'Guadeloupe', 'jasperfm' ),
		'GU' => __( 'Guam', 'jasperfm' ),
		'GT' => __( 'Guatemala', 'jasperfm' ),
		'GG' => __( 'Guernsey', 'jasperfm' ),
		'GN' => __( 'Guinea', 'jasperfm' ),
		'GW' => __( 'Guinea-Bissau', 'jasperfm' ),
		'GY' => __( 'Guyana', 'jasperfm' ),
		'HT' => __( 'Haiti', 'jasperfm' ),
		'HM' => __( 'Heard Island and McDonald Islands', 'jasperfm' ),
		'HN' => __( 'Honduras', 'jasperfm' ),
		'HK' => __( 'Hong Kong', 'jasperfm' ),
		'HU' => __( 'Hungary', 'jasperfm' ),
		'IS' => __( 'Iceland', 'jasperfm' ),
		'IN' => __( 'India', 'jasperfm' ),
		'ID' => __( 'Indonesia', 'jasperfm' ),
		'IR' => __( 'Iran', 'jasperfm' ),
		'IQ' => __( 'Iraq', 'jasperfm' ),
		'IE' => __( 'Ireland', 'jasperfm' ),
		'IM' => __( 'Isle of Man', 'jasperfm' ),
		'IL' => __( 'Israel', 'jasperfm' ),
		'IT' => __( 'Italy', 'jasperfm' ),
		'CI' => __( 'Ivory Coast', 'jasperfm' ),
		'JM' => __( 'Jamaica', 'jasperfm' ),
		'JP' => __( 'Japan', 'jasperfm' ),
		'JE' => __( 'Jersey', 'jasperfm' ),
		'JO' => __( 'Jordan', 'jasperfm' ),
		'KZ' => __( 'Kazakhstan', 'jasperfm' ),
		'KE' => __( 'Kenya', 'jasperfm' ),
		'KI' => __( 'Kiribati', 'jasperfm' ),
		'KW' => __( 'Kuwait', 'jasperfm' ),
		'KG' => __( 'Kyrgyzstan', 'jasperfm' ),
		'LA' => __( 'Laos', 'jasperfm' ),
		'LV' => __( 'Latvia', 'jasperfm' ),
		'LB' => __( 'Lebanon', 'jasperfm' ),
		'LS' => __( 'Lesotho', 'jasperfm' ),
		'LR' => __( 'Liberia', 'jasperfm' ),
		'LY' => __( 'Libya', 'jasperfm' ),
		'LI' => __( 'Liechtenstein', 'jasperfm' ),
		'LT' => __( 'Lithuania', 'jasperfm' ),
		'LU' => __( 'Luxembourg', 'jasperfm' ),
		'MO' => __( 'Macao S.A.R., China', 'jasperfm' ),
		'MK' => __( 'North Macedonia', 'jasperfm' ),
		'MG' => __( 'Madagascar', 'jasperfm' ),
		'MW' => __( 'Malawi', 'jasperfm' ),
		'MY' => __( 'Malaysia', 'jasperfm' ),
		'MV' => __( 'Maldives', 'jasperfm' ),
		'ML' => __( 'Mali', 'jasperfm' ),
		'MT' => __( 'Malta', 'jasperfm' ),
		'MH' => __( 'Marshall Islands', 'jasperfm' ),
		'MQ' => __( 'Martinique', 'jasperfm' ),
		'MR' => __( 'Mauritania', 'jasperfm' ),
		'MU' => __( 'Mauritius', 'jasperfm' ),
		'YT' => __( 'Mayotte', 'jasperfm' ),
		'MX' => __( 'Mexico', 'jasperfm' ),
		'FM' => __( 'Micronesia', 'jasperfm' ),
		'MD' => __( 'Moldova', 'jasperfm' ),
		'MC' => __( 'Monaco', 'jasperfm' ),
		'MN' => __( 'Mongolia', 'jasperfm' ),
		'ME' => __( 'Montenegro', 'jasperfm' ),
		'MS' => __( 'Montserrat', 'jasperfm' ),
		'MA' => __( 'Morocco', 'jasperfm' ),
		'MZ' => __( 'Mozambique', 'jasperfm' ),
		'MM' => __( 'Myanmar', 'jasperfm' ),
		'NA' => __( 'Namibia', 'jasperfm' ),
		'NR' => __( 'Nauru', 'jasperfm' ),
		'NP' => __( 'Nepal', 'jasperfm' ),
		'NL' => __( 'Netherlands', 'jasperfm' ),
		'NC' => __( 'New Caledonia', 'jasperfm' ),
		'NZ' => __( 'New Zealand', 'jasperfm' ),
		'NI' => __( 'Nicaragua', 'jasperfm' ),
		'NE' => __( 'Niger', 'jasperfm' ),
		'NG' => __( 'Nigeria', 'jasperfm' ),
		'NU' => __( 'Niue', 'jasperfm' ),
		'NF' => __( 'Norfolk Island', 'jasperfm' ),
		'MP' => __( 'Northern Mariana Islands', 'jasperfm' ),
		'KP' => __( 'North Korea', 'jasperfm' ),
		'NO' => __( 'Norway', 'jasperfm' ),
		'OM' => __( 'Oman', 'jasperfm' ),
		'PK' => __( 'Pakistan', 'jasperfm' ),
		'PS' => __( 'Palestinian Territory', 'jasperfm' ),
		'PA' => __( 'Panama', 'jasperfm' ),
		'PG' => __( 'Papua New Guinea', 'jasperfm' ),
		'PY' => __( 'Paraguay', 'jasperfm' ),
		'PE' => __( 'Peru', 'jasperfm' ),
		'PH' => __( 'Philippines', 'jasperfm' ),
		'PN' => __( 'Pitcairn', 'jasperfm' ),
		'PL' => __( 'Poland', 'jasperfm' ),
		'PT' => __( 'Portugal', 'jasperfm' ),
		'PR' => __( 'Puerto Rico', 'jasperfm' ),
		'QA' => __( 'Qatar', 'jasperfm' ),
		'RE' => __( 'Reunion', 'jasperfm' ),
		'RO' => __( 'Romania', 'jasperfm' ),
		'RU' => __( 'Russia', 'jasperfm' ),
		'RW' => __( 'Rwanda', 'jasperfm' ),
		'BL' => __( 'Saint Barth&eacute;lemy', 'jasperfm' ),
		'SH' => __( 'Saint Helena', 'jasperfm' ),
		'KN' => __( 'Saint Kitts and Nevis', 'jasperfm' ),
		'LC' => __( 'Saint Lucia', 'jasperfm' ),
		'MF' => __( 'Saint Martin (French part)', 'jasperfm' ),
		'SX' => __( 'Saint Martin (Dutch part)', 'jasperfm' ),
		'PM' => __( 'Saint Pierre and Miquelon', 'jasperfm' ),
		'VC' => __( 'Saint Vincent and the Grenadines', 'jasperfm' ),
		'SM' => __( 'San Marino', 'jasperfm' ),
		'ST' => __( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe', 'jasperfm' ),
		'SA' => __( 'Saudi Arabia', 'jasperfm' ),
		'SN' => __( 'Senegal', 'jasperfm' ),
		'RS' => __( 'Serbia', 'jasperfm' ),
		'SC' => __( 'Seychelles', 'jasperfm' ),
		'SL' => __( 'Sierra Leone', 'jasperfm' ),
		'SG' => __( 'Singapore', 'jasperfm' ),
		'SK' => __( 'Slovakia', 'jasperfm' ),
		'SI' => __( 'Slovenia', 'jasperfm' ),
		'SB' => __( 'Solomon Islands', 'jasperfm' ),
		'SO' => __( 'Somalia', 'jasperfm' ),
		'ZA' => __( 'South Africa', 'jasperfm' ),
		'GS' => __( 'South Georgia/Sandwich Islands', 'jasperfm' ),
		'KR' => __( 'South Korea', 'jasperfm' ),
		'SS' => __( 'South Sudan', 'jasperfm' ),
		'ES' => __( 'Spain', 'jasperfm' ),
		'LK' => __( 'Sri Lanka', 'jasperfm' ),
		'SD' => __( 'Sudan', 'jasperfm' ),
		'SR' => __( 'Suriname', 'jasperfm' ),
		'SJ' => __( 'Svalbard and Jan Mayen', 'jasperfm' ),
		'SZ' => __( 'Swaziland', 'jasperfm' ),
		'SE' => __( 'Sweden', 'jasperfm' ),
		'CH' => __( 'Switzerland', 'jasperfm' ),
		'SY' => __( 'Syria', 'jasperfm' ),
		'TW' => __( 'Taiwan', 'jasperfm' ),
		'TJ' => __( 'Tajikistan', 'jasperfm' ),
		'TZ' => __( 'Tanzania', 'jasperfm' ),
		'TH' => __( 'Thailand', 'jasperfm' ),
		'TL' => __( 'Timor-Leste', 'jasperfm' ),
		'TG' => __( 'Togo', 'jasperfm' ),
		'TK' => __( 'Tokelau', 'jasperfm' ),
		'TO' => __( 'Tonga', 'jasperfm' ),
		'TT' => __( 'Trinidad and Tobago', 'jasperfm' ),
		'TN' => __( 'Tunisia', 'jasperfm' ),
		'TR' => __( 'Turkey', 'jasperfm' ),
		'TM' => __( 'Turkmenistan', 'jasperfm' ),
		'TC' => __( 'Turks and Caicos Islands', 'jasperfm' ),
		'TV' => __( 'Tuvalu', 'jasperfm' ),
		'UG' => __( 'Uganda', 'jasperfm' ),
		'UA' => __( 'Ukraine', 'jasperfm' ),
		'AE' => __( 'United Arab Emirates', 'jasperfm' ),
		'GB' => __( 'United Kingdom (UK)', 'jasperfm' ),
		'US' => __( 'United States (US)', 'jasperfm' ),
		'UM' => __( 'United States (US) Minor Outlying Islands', 'jasperfm' ),
		'UY' => __( 'Uruguay', 'jasperfm' ),
		'UZ' => __( 'Uzbekistan', 'jasperfm' ),
		'VU' => __( 'Vanuatu', 'jasperfm' ),
		'VA' => __( 'Vatican', 'jasperfm' ),
		'VE' => __( 'Venezuela', 'jasperfm' ),
		'VN' => __( 'Vietnam', 'jasperfm' ),
		'VG' => __( 'Virgin Islands (British)', 'jasperfm' ),
		'VI' => __( 'Virgin Islands (US)', 'jasperfm' ),
		'WF' => __( 'Wallis and Futuna', 'jasperfm' ),
		'EH' => __( 'Western Sahara', 'jasperfm' ),
		'WS' => __( 'Samoa', 'jasperfm' ),
		'YE' => __( 'Yemen', 'jasperfm' ),
		'ZM' => __( 'Zambia', 'jasperfm' ),
		'ZW' => __( 'Zimbabwe', 'jasperfm' ),
	);
	return $countries;
}

/**
 * Convert an associative array into array of objects prepped for selectControl.
 *
 * @param array $arr Array to be converted.
 * @return array
 */
function jasperfm_select_prepare( $arr ) {
	$result = array();
	foreach ( $arr as $key => $value ) {
		$result[] = [
			'label' => html_entity_decode( $value ),
			'value' => $key,
		];
	}
	return $result;
}
