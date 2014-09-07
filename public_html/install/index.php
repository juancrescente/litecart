<?php
  require('includes/header.inc.php');
  
  ini_set('display_errors', 'On');
  
// Function to get object from a relative path to this script
  function get_absolute_path($path=null) {
    if (empty($path)) $path = dirname(__FILE__);
    $path = str_replace('\\', '/', $path);
    $parts = array_filter(explode('/', $path), 'strlen');
    $absolutes = array();
    foreach ($parts as $part) {
      if ('.' == $part) continue;
      if ('..' == $part) {
        array_pop($absolutes);
      } else {
        $absolutes[] = $part;
      }
    }
    return ((substr(PHP_OS, 0, 3) == 'WIN') ? '' : '/') . implode('/', $absolutes);
  }
  
  $document_root = get_absolute_path(dirname(__FILE__) . '/..') .'/';
  
  function return_bytes($val) {
    $val = trim($val);
    switch(strtolower($val[strlen($val)-1])) {
      case 'g':
        $val *= 1024;
      case 'm':
        $val *= 1024;
      case 'k':
        $val *= 1024;
    }
    return $val;
  }
  
  $countries = array(
    'AF' => 'Afghanistan',
    'AL' => 'Albania',
    'DZ' => 'Algeria',
    'AS' => 'American Samoa',
    'AD' => 'Andorra',
    'AO' => 'Angola',
    'AI' => 'Anguilla',
    'AQ' => 'Antarctica',
    'AG' => 'Antigua and Barbuda',
    'AR' => 'Argentina',
    'AM' => 'Armenia',
    'AW' => 'Aruba',
    'AU' => 'Australia',
    'AT' => 'Austria',
    'AZ' => 'Azerbaijan',
    'BS' => 'Bahamas',
    'BH' => 'Bahrain',
    'BD' => 'Bangladesh',
    'BB' => 'Barbados',
    'BY' => 'Belarus',
    'BE' => 'Belgium',
    'BZ' => 'Belize',
    'BJ' => 'Benin',
    'BM' => 'Bermuda',
    'BT' => 'Bhutan',
    'BO' => 'Bolivia',
    'BA' => 'Bosnia and Herzegowina',
    'BW' => 'Botswana',
    'BV' => 'Bouvet Island',
    'BR' => 'Brazil',
    'IO' => 'British Indian Ocean Territory',
    'BN' => 'Brunei Darussalam',
    'BG' => 'Bulgaria',
    'BF' => 'Burkina Faso',
    'BI' => 'Burundi',
    'KH' => 'Cambodia',
    'CM' => 'Cameroon',
    'CA' => 'Canada',
    'CV' => 'Cape Verde',
    'KY' => 'Cayman Islands',
    'CF' => 'Central African Republic',
    'TD' => 'Chad',
    'CL' => 'Chile',
    'CN' => 'China',
    'CX' => 'Christmas Island',
    'CC' => 'Cocos (Keeling) Islands',
    'CO' => 'Colombia',
    'KM' => 'Comoros',
    'CG' => 'Congo',
    'CK' => 'Cook Islands',
    'CR' => 'Costa Rica',
    'CI' => 'Cote D\'Ivoire',
    'HR' => 'Croatia',
    'CU' => 'Cuba',
    'CY' => 'Cyprus',
    'CZ' => 'Czech Republic',
    'CD' => 'Democratic Republic of Congo',
    'DK' => 'Denmark',
    'DJ' => 'Djibouti',
    'DM' => 'Dominica',
    'DO' => 'Dominican Republic',
    'TP' => 'East Timor',
    'EC' => 'Ecuador',
    'EG' => 'Egypt',
    'SV' => 'El Salvador',
    'GQ' => 'Equatorial Guinea',
    'ER' => 'Eritrea',
    'EE' => 'Estonia',
    'ET' => 'Ethiopia',
    'FK' => 'Falkland Islands (Malvinas)',
    'FO' => 'Faroe Islands',
    'FJ' => 'Fiji',
    'FI' => 'Finland',
    'FR' => 'France',
    'FX' => 'France, Metropolitan',
    'GF' => 'French Guiana',
    'PF' => 'French Polynesia',
    'TF' => 'French Southern Territories',
    'GA' => 'Gabon',
    'GM' => 'Gambia',
    'GE' => 'Georgia',
    'DE' => 'Germany',
    'GH' => 'Ghana',
    'GI' => 'Gibraltar',
    'GR' => 'Greece',
    'GL' => 'Greenland',
    'GD' => 'Grenada',
    'GP' => 'Guadeloupe',
    'GU' => 'Guam',
    'GT' => 'Guatemala',
    'GN' => 'Guinea',
    'GW' => 'Guinea-bissau',
    'GY' => 'Guyana',
    'HT' => 'Haiti',
    'HM' => 'Heard and Mc Donald Islands',
    'HN' => 'Honduras',
    'HK' => 'Hong Kong',
    'HU' => 'Hungary',
    'IS' => 'Iceland',
    'IN' => 'India',
    'ID' => 'Indonesia',
    'IR' => 'Iran (Islamic Republic of)',
    'IQ' => 'Iraq',
    'IE' => 'Ireland',
    'IL' => 'Israel',
    'IT' => 'Italy',
    'JM' => 'Jamaica',
    'JP' => 'Japan',
    'JO' => 'Jordan',
    'KZ' => 'Kazakhstan',
    'KE' => 'Kenya',
    'KI' => 'Kiribati',
    'KR' => 'Korea, Republic of',
    'KW' => 'Kuwait',
    'KG' => 'Kyrgyzstan',
    'LA' => 'Lao People\'s Democratic Republic',
    'LV' => 'Latvia',
    'LB' => 'Lebanon',
    'LS' => 'Lesotho',
    'LR' => 'Liberia',
    'LY' => 'Libyan Arab Jamahiriya',
    'LI' => 'Liechtenstein',
    'LT' => 'Lithuania',
    'LU' => 'Luxembourg',
    'MO' => 'Macau',
    'MK' => 'Macedonia',
    'MG' => 'Madagascar',
    'MW' => 'Malawi',
    'MY' => 'Malaysia',
    'MV' => 'Maldives',
    'ML' => 'Mali',
    'MT' => 'Malta',
    'MH' => 'Marshall Islands',
    'MQ' => 'Martinique',
    'MR' => 'Mauritania',
    'MU' => 'Mauritius',
    'YT' => 'Mayotte',
    'MX' => 'Mexico',
    'FM' => 'Micronesia, Federated States of',
    'MD' => 'Moldova, Republic of',
    'MC' => 'Monaco',
    'MN' => 'Mongolia',
    'MS' => 'Montserrat',
    'MA' => 'Morocco',
    'MZ' => 'Mozambique',
    'MM' => 'Myanmar',
    'NA' => 'Namibia',
    'NR' => 'Nauru',
    'NP' => 'Nepal',
    'NL' => 'Netherlands',
    'AN' => 'Netherlands Antilles',
    'NC' => 'New Caledonia',
    'NZ' => 'New Zealand',
    'NI' => 'Nicaragua',
    'NE' => 'Niger',
    'NG' => 'Nigeria',
    'NU' => 'Niue',
    'NF' => 'Norfolk Island',
    'KP' => 'North Korea',
    'MP' => 'Northern Mariana Islands',
    'NO' => 'Norway',
    'OM' => 'Oman',
    'PK' => 'Pakistan',
    'PW' => 'Palau',
    'PA' => 'Panama',
    'PG' => 'Papua New Guinea',
    'PY' => 'Paraguay',
    'PE' => 'Peru',
    'PH' => 'Philippines',
    'PN' => 'Pitcairn',
    'PL' => 'Poland',
    'PT' => 'Portugal',
    'PR' => 'Puerto Rico',
    'QA' => 'Qatar',
    'RE' => 'Reunion',
    'RO' => 'Romania',
    'RU' => 'Russian Federation',
    'RW' => 'Rwanda',
    'KN' => 'Saint Kitts and Nevis',
    'LC' => 'Saint Lucia',
    'VC' => 'Saint Vincent and the Grenadines',
    'WS' => 'Samoa',
    'SM' => 'San Marino',
    'ST' => 'Sao Tome and Principe',
    'SA' => 'Saudi Arabia',
    'SN' => 'Senegal',
    'SC' => 'Seychelles',
    'SL' => 'Sierra Leone',
    'SG' => 'Singapore',
    'SK' => 'Slovak Republic',
    'SI' => 'Slovenia',
    'SB' => 'Solomon Islands',
    'SO' => 'Somalia',
    'ZA' => 'South Africa',
    'GS' => 'South Georgia &amp; South Sandwich Islands',
    'ES' => 'Spain',
    'LK' => 'Sri Lanka',
    'SH' => 'St. Helena',
    'PM' => 'St. Pierre and Miquelon',
    'SD' => 'Sudan',
    'SR' => 'Suriname',
    'SJ' => 'Svalbard and Jan Mayen Islands',
    'SZ' => 'Swaziland',
    'SE' => 'Sweden',
    'CH' => 'Switzerland',
    'SY' => 'Syrian Arab Republic',
    'TW' => 'Taiwan',
    'TJ' => 'Tajikistan',
    'TZ' => 'Tanzania, United Republic of',
    'TH' => 'Thailand',
    'TG' => 'Togo',
    'TK' => 'Tokelau',
    'TO' => 'Tonga',
    'TT' => 'Trinidad and Tobago',
    'TN' => 'Tunisia',
    'TR' => 'Turkey',
    'TM' => 'Turkmenistan',
    'TC' => 'Turks and Caicos Islands',
    'TV' => 'Tuvalu',
    'UG' => 'Uganda',
    'UA' => 'Ukraine',
    'AE' => 'United Arab Emirates',
    'GB' => 'United Kingdom',
    'US' => 'United States',
    'UM' => 'United States Minor Outlying Islands',
    'UY' => 'Uruguay',
    'UZ' => 'Uzbekistan',
    'VU' => 'Vanuatu',
    'VA' => 'Vatican City State (Holy See)',
    'VE' => 'Venezuela',
    'VN' => 'Viet Nam',
    'VG' => 'Virgin Islands (British)',
    'VI' => 'Virgin Islands (U.S.)',
    'WF' => 'Wallis and Futuna Islands',
    'EH' => 'Western Sahara',
    'YE' => 'Yemen',
    'YU' => 'Yugoslavia',
    'ZM' => 'Zambia',
    'ZW' => 'Zimbabwe',
  );
  
?>

  <h1>Installer</h1>
  
  <h2>System Requirements</h2>
  <ul>
    <li>PHP 5.3+ <?php echo version_compare(PHP_VERSION, '5.3', '>=') ? '<span class="ok">['. PHP_VERSION .']</span>' : '<span class="error">['. PHP_VERSION .']</span>'; ?>
      <ul>
        <li>Settings
          <ul>
            <li>register_globals = <?php echo ini_get('register_globals'); ?> <?php echo in_array(strtolower(ini_get('register_globals')), array('off', 'false', '', '0')) ? '<span class="ok">[OK]</span>' : '<span class="error">[Not recommended]</span>'; ?></li>
            <li>arg_separator.output = <?php echo htmlspecialchars(ini_get('arg_separator.output')); ?> <?php echo (ini_get('arg_separator.output') == '&') ? '<span class="ok">[OK]</span>' : '<span class="error">[Not recommended]</span>'; ?></li>
            <li>memory_limit = <?php echo ini_get('memory_limit'); ?> <?php echo (return_bytes(ini_get('memory_limit')) >= 128*1024*1024) ? '<span class="ok">[OK]</span>' : '<span class="error">[Not recommended]</span>'; ?></li>
          </ul>
        </li>
        <li>Extensions
          <ul>
            <li>CURL <?php echo extension_loaded('curl') ? '<span class="ok">[OK]</span>' : '<span class="error">[Missing]</span>'; ?></li>
            <li>EXIF <?php echo extension_loaded('exif') ? '<span class="ok">[OK]</span>' : '<span class="error">[Missing]</span>'; ?></li>
            <li>MBString <?php echo extension_loaded('mbstring') ? '<span class="ok">[OK]</span>' : '<span class="error">[Missing]</span>'; ?></li>
            <li>MySQL or MySQLi <?php echo (extension_loaded('mysql') || extension_loaded('mysqli')) ? '<span class="ok">[OK]</span>' : '<span class="error">[Missing]</span>'; ?></li>
            <li>GD or GD2 <?php echo (extension_loaded('gd') || extension_loaded('gd2')) ? '<span class="ok">[OK]</span>' : '<span class="error">[Missing]</span>'; ?></li>
            <li>FreeType <?php echo function_exists('imagettftext') ? '<span class="ok">[OK]</span>' : '<span class="error">[Missing]</span>'; ?></li>
          </ul>
        </li>
      </ul>
    </li>
    <li>Apacahe 2 compatible HTTP daemon
      <?php if (function_exists('apache_get_modules')) $installed_apache_modules = apache_get_modules(); ?>
      <ul>
        <li>Allow, Deny</li>
        <li>Options -Indexes</li>
        <li>Apache Modules
          <ul>
            <li>mod_auth_basic (SHA) <?php if (!empty($installed_apache_modules)) echo !in_array('mod_redirect', $installed_apache_modules) ? '<span class="ok">[OK]</span>' : '<span class="error">[Missing]</span>'; ?></li>
            <li>mod_deflate <?php if (!empty($installed_apache_modules)) echo !in_array('mod_redirect', $installed_apache_modules) ? '<span class="ok">[OK]</span>' : '<span class="error">[Missing]</span>'; ?></li>
            <li>mod_headers <?php if (!empty($installed_apache_modules)) echo !in_array('mod_redirect', $installed_apache_modules) ? '<span class="ok">[OK]</span>' : '<span class="error">[Missing]</span>'; ?></li>
            <li>mod_rewrite <?php if (!empty($installed_apache_modules)) echo !in_array('mod_redirect', $installed_apache_modules) ? '<span class="ok">[OK]</span>' : '<span class="error">[Missing]</span>'; ?></li>
            <li>mod_redirect <?php if (!empty($installed_apache_modules)) echo !in_array('mod_redirect', $installed_apache_modules) ? '<span class="ok">[OK]</span>' : '<span class="error">[Missing]</span>'; ?></li>
          </ul>
        </li>
      </ul>
    </li>
    <li>MySQL 5.5+ / MariaDB 5.5+</li>
  </ul>
  
  <h2>Client Requirements</h2>
  <ul>
    <li>HTML 5</li>
    <li>CSS 3 (IE9+)</li>
  </ul>
  
  <h2>Writables</h2>
    <ul>
<?php
  $files = array(
    'admin/.htaccess',
    'admin/.htpasswd',
    'cache/',
    'data/',
    'images/',
    'includes/config.inc.php',
    '.htaccess',
  );
  foreach($files as $file) {
    if (file_exists($file) && is_writable('../' . $file)) {
      echo '      <li>~/'. $file .' <span class="ok">[OK]</span></li>' . PHP_EOL;
    } else if (is_writable('../' . pathinfo($file, PATHINFO_DIRNAME))) {
      echo '      <li>~/'. $file .' <span class="ok">[OK]</span></li>' . PHP_EOL;
    } else {
      echo '      <li>~/'. $file .' <span class="error">[Read-only, please make path writable]</span></li>' . PHP_EOL;
    }
  }
?>
  </ul>
  
  <h2>Installation Parameters</h2>
  
<?php
  if (file_exists('../includes/config.inc.php')) {
    echo '<p style="color: #f00; font-weight: bold;">Attention: An existing installation has been detected. If you continue the existing installation will be overwritten. <a href="upgrade.php">Upgraders click here insted.</a></p>';
  }
?>
  
  <form name="installation_form" method="post" action="install.php">
    <h3>File System</h3>
    <table>
      <tr>
        <td><strong>Installation Path</strong><br />
          <?php echo $document_root; ?></td>
      </tr>
    </table>
    <h3>MySQL</h3>
    <table>
      <!--
      <tr>
        <td><strong>Type</strong><br />
          <select name="db_type">
            <option value="mysql">MySQL</option>
          </select>
        </td>
        <td></td>
      </tr>
      -->
      <tr>
        <td><strong>Hostname</strong><br />
          <input name="db_server" type="text" value="localhost"  />
        </td>
        <td><strong>Database</strong><br />
        <input type="text" name="db_database" /></td>
      </tr>
      <tr>
        <td><strong>Username</strong><br />
        <input type="text" name="db_username" /></td>
        <td><strong>Password</strong><br />
        <input type="password" name="db_password" /></td>
      </tr>
      <tr>
        <td><strong>Table Prefix</strong><br />
        <input name="db_table_prefix" type="text" value="lc_" style="width: 75px;" /></td>
        <td><strong>Demo Data</strong><br />
          <label><input name="demo_data" type="checkbox" value="true" <?php echo !file_exists('data/demo/data.sql') ? 'disabled="disabled"' : ''; ?> /> Install demo data</label></td>
      </tr>
    </table>
    <h3>Store Information</h3>
    <table>
      <tr>
        <td><strong>Store Name</strong><br />
          <input name="store_name" type="text" value="My Store"  /></td>
        <td><strong>Store E-mail</strong><br />
          <input name="store_email" type="text" value="store@email.com" /></td>
      </tr>
      <tr>
        <td colspan="2"><strong>Country</strong><br />
          <select name="country_code">
            <option value="">-- Select --</option>
            <?php foreach ($countries as $code => $name) echo '<option value="'. $code .'">'. $name .'</option>' . PHP_EOL; ?>
          </select>
        </td>
      </tr>
      <tr>
        <td colspan="2"><strong>Time Zone</strong><br />
          <select name="store_time_zone" >
<?php
  $zones = timezone_identifiers_list();
       
  foreach ($zones as $zone) {
    $zone = explode('/', $zone); // 0 => Continent, 1 => City
   
    // Only use "friendly" continent names
    if (in_array($zone[0], array('Africa', 'America', 'Antarctica', 'Arctic', 'Asia', 'Atlantic', 'Australia', 'Europe', 'Indian', 'Pacific'))) {
      if (!empty($zone[1])) {
        echo '<option>'. $zone[0]. '/' . $zone[1]  .'</option>';
      }
    }
  }
?>
        </select></td>
      </tr>
    </table>
    <h3>Administration</h3>
    <table>
      <tr>
        <td><strong>Folder Name</strong><br />
          <input name="admin_folder" type="text" value="admin"  /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Username</strong><br />
          <input name="username" type="text" id="username" value="admin"  /></td>
        <td><strong>Password</strong><br />
          <input name="password" type="text" id="password"  /></td>
      </tr>
    </table>
    <h3>Errors
      <input name="client_ip" type="hidden" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>"  />
    </h3>
    <p>Errors will be hidden for all visitors except you, determined by IP <strong><?php echo $_SERVER['REMOTE_ADDR']; ?></strong>. Some web host providers may not allow  overriding PHP error settings. Blank pages are usually the result of an error and you might need to contact your web host provider how to turn PHP error messages on.</p>
    <p>If your IP address changes, or if you need to add more, these settings can be found in the configuration file.<br />
    </p>
    <p><strong>By installing this software you agree to the <a href="http://www.litecart.net/license" target="_blank">terms and conditions</a>.</strong></p>
    <p><input type="submit" name="install" value="Install Now" onclick="if(!confirm('This will now install LiteCart. Any existing databases tables will be overwritten with new data.')) return false;" /></p>
  </form>
<?php require('includes/footer.inc.php'); ?>