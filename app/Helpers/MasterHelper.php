<?php


namespace App\Helpers;


class MasterHelper
{

	private static function uuid() {

		// Generate 128 bit random sequence
		$randmax_bits = strlen(base_convert(mt_getrandmax(), 10, 2));  // how many bits is mt_getrandmax()
		$x = '';
		while (strlen($x) < 128) {
			$maxbits = (128 - strlen($x) < $randmax_bits) ? 128 - strlen($x) :  $randmax_bits;
			$x .= str_pad(base_convert(mt_rand(0, pow(2,$maxbits)), 10, 2), $maxbits, "0", STR_PAD_LEFT);
		}

		// break into fields
		$a = array();
		$a['time_low_part'] = substr($x, 0, 32);
		$a['time_mid'] = substr($x, 32, 16);
		$a['time_hi_and_version'] = substr($x, 48, 16);
		$a['clock_seq'] = substr($x, 64, 16);
		$a['node_part'] =  substr($x, 80, 48);

		// Apply bit masks for "random or pseudo-random" version per RFC
		$a['time_hi_and_version'] = substr_replace($a['time_hi_and_version'], '0100', 0, 4);
		$a['clock_seq'] = substr_replace($a['clock_seq'], '10', 0, 2);

		// Format output
		return sprintf('%s-%s-%s-%s-%s',
			str_pad(base_convert($a['time_low_part'], 2, 16), 8, "0", STR_PAD_LEFT),
			str_pad(base_convert($a['time_mid'], 2, 16), 4, "0", STR_PAD_LEFT),
			str_pad(base_convert($a['time_hi_and_version'], 2, 16), 4, "0", STR_PAD_LEFT),
			str_pad(base_convert($a['clock_seq'], 2, 16), 4, "0", STR_PAD_LEFT),
			str_pad(base_convert($a['node_part'], 2, 16), 12, "0", STR_PAD_LEFT));
	}

	private static function uuidSecure() {

		$pr_bits = null;
		$fp = @fopen('/dev/urandom','rb');
		if ($fp !== false) {
			$pr_bits .= @fread($fp, 16);
			@fclose($fp);
		} else {
			// If /dev/urandom isn't available (eg: in non-unix systems), use mt_rand().
			$pr_bits = "";
			for($cnt=0; $cnt < 16; $cnt++){
				$pr_bits .= chr(mt_rand(0, 255));
			}
		}

		$time_low = bin2hex(substr($pr_bits,0, 4));
		$time_mid = bin2hex(substr($pr_bits,4, 2));
		$time_hi_and_version = bin2hex(substr($pr_bits,6, 2));
		$clock_seq_hi_and_reserved = bin2hex(substr($pr_bits,8, 2));
		$node = bin2hex(substr($pr_bits,10, 6));

		/**
		 * Set the four most significant bits (bits 12 through 15) of the
		 * time_hi_and_version field to the 4-bit version number from
		 * Section 4.1.3.
		 * @see http://tools.ietf.org/html/rfc4122#section-4.1.3
		 */
		$time_hi_and_version = hexdec($time_hi_and_version);
		$time_hi_and_version = $time_hi_and_version >> 4;
		$time_hi_and_version = $time_hi_and_version | 0x4000;

		/**
		 * Set the two most significant bits (bits 6 and 7) of the
		 * clock_seq_hi_and_reserved to zero and one, respectively.
		 */
		$clock_seq_hi_and_reserved = hexdec($clock_seq_hi_and_reserved);
		$clock_seq_hi_and_reserved = $clock_seq_hi_and_reserved >> 2;
		$clock_seq_hi_and_reserved = $clock_seq_hi_and_reserved | 0x8000;

		return sprintf('%08s-%04s-%04x-%04x-%012s',
			$time_low, $time_mid, $time_hi_and_version, $clock_seq_hi_and_reserved, $node);
	}

	public static function GenerateUUID()
	{
		return self::uuidSecure();
    }

    // timestamp 를 문자열 시간형식으로 반환
    private static function _convertTimeToString($timestamp = NULL)
    {
        if(!ctype_digit($timestamp)) {
            $timestamp = strtotime($timestamp);
        }

        $diff = time() - $timestamp;

        if($diff == 0) {
            return 'now';
        } elseif($diff > 0) {

            $day_diff = floor($diff / 86400);

            if($day_diff == 0) {
                if($diff < 60) return 'just now';
                if($diff < 120) return '1 minute ago';
                if($diff < 3600) return floor($diff / 60) . ' minutes ago';
                if($diff < 7200) return '1 hour ago';
                if($diff < 86400) return floor($diff / 3600) . ' hours ago';
            }

            if($day_diff == 1) { return 'Yesterday'; }
            if($day_diff < 7) { return $day_diff . ' days ago'; }
            if($day_diff < 31) { return ceil($day_diff / 7) . ' weeks ago'; }
            if($day_diff < 60) { return 'last month'; }

            return date('F Y', $timestamp);
        } else {

            $diff = abs($diff);
            $day_diff = floor($diff / 86400);

            if($day_diff == 0) {
                if($diff < 120) { return 'in a minute'; }
                if($diff < 3600) { return 'in ' . floor($diff / 60) . ' minutes'; }
                if($diff < 7200) { return 'in an hour'; }
                if($diff < 86400) { return 'in ' . floor($diff / 3600) . ' hours'; }
            }

            if($day_diff == 1) { return 'Tomorrow'; }
            if($day_diff < 4) { return date('l', $timestamp); }
            if($day_diff < 7 + (7 - date('w'))) { return 'next week'; }
            if(ceil($day_diff / 7) < 4) { return 'in ' . ceil($day_diff / 7) . ' weeks'; }
            if(date('n', $timestamp) == date('n') + 1) { return 'next month'; }

            return date('F Y', $timestamp);
        }
    }

    public static function convertTimeToString($timestamp)
    {
        return self::_convertTimeToString($timestamp);
    }

    // 사용자 이름
    public static function setUserName($user_name) : string
    {
        return preg_replace("/[^a-z0-9]/i", "_", strtolower($user_name));
    }
}
