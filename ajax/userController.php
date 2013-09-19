<?php

/**
 * ownCloud - Documents App
 *
 * @author Victor Dubiniuk
 * @copyright 2013 Victor Dubiniuk victor.dubiniuk@gmail.com
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later.
 */

namespace OCA\Documents;

class UserController extends Controller{
	
	/**
	 * Invite users to the editing session
	 */
	public static function invite(){
		self::preDispatch();
		$invitees = @$_POST['users'];
		
		if (is_array($invitees)){
			$invitees = array_unique($invitees);
		
			$esId = @$_POST['esId'];
			foreach ($invitees as $userId){
				try {
					Invite::add($esId, $userId);
				} catch (\Exception $e) {
					
				}
			}
		}
		\OCP\JSON::success();
	}
	
	/**
	 * Stub - sends a generic avatar
	 */
	public static function sendAvatar(){
		$uid = self::preDispatch(false);
		$image = new \OC_Image('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P7Xw0wspKVBX09ExNOT1quqHH3788erVHs/q1WvWDA6uWEF+b9DSEolD9C41lYueB+gWTwcd2dav19bW1SnKgQM9PX19XV2iKAg8X1lZWjp6dEHBjTfyvMnkcJSUAEAg0N4O6C7jxxK6tjgcV14JKMro0TffDFRXHz78ySeh0ObNO3e+9lpb23PPrVkzNHT33ZHAR8twm5jhOnZGcY4E0KlGl7+za3Jy7PjxgwcPHx4crK4WBJ7fvfuKKzSN41jWYHA4xo1bsYLjeD4hITcXoIsoQM9qnsuEPpMIAqnS2+3TpgGalpV1881Ad3cwKEmatn37P//53HOh0LvvfvRRZeXOnWvWrF8fCDz+uM/n95OgMxzIaFcTfT1ax54J5+hJ6VQ72ww4fUbQNnFC8fEVFTNmCMLSpTfcMHeuxXLrrUVFY8dWVPD8hAmFhddeazQmJiYkuFwAwwwNNTYCQCBAjqXQqEZRyO8GaMZNysKAIFitAGAy2e0AYLFkZwOhEMdZrUBbW2trVZWq7t9/6ND27bJcU3Po0MmTdXXvvLN5czC4dm1LS3u7qpLMAKBxEzGJ09vROtbnsQ/xnudSRk9XRgMcTUistq4FgecBi6WkZOJEnp81a/bsGTMMhoULc3JycqzW3Nz0dLt90iRFcbnS0vLzDYaUlKSk9HSOMxgMBlIOJwezFIUU4/x+n6+vT9M6Onp6mptDoZaWzs7aWk1zu93uU6dEsaqqujoY3LNn9+69e2X544/b2zs7VZWeaKIAUk2BiwVw9P2x7ostFxhLRM8I6nqi2+En/IdrU02JFQRCjNmcm5uVxbLFxRkZo0axbHa2y5WWxnFZWQkJVivLJiYaDDyvaUajzxcIAD5fd3dvr6p2dra3d3UpSnMzcYFHj5I6PV32w39TE64p4LF0NOCx9MiPrV/kYC4WIacDPHw78hRp5G5yeHukwWi0r6a+OFpHHqDRATwbMdTCzz8P+JF+I0YBjDxOGxvwaB3rMGKsE2ixopBYRITvModr+jm1bNq+OGEB8LP5mWo0sCO1/FgzIBqgs0Un555AXZbLclkuy3+B/B+iYBQdKn9hfAAAACV0RVh0Y3JlYXRlLWRhdGUAMjAwOS0xMS0yOFQyMjo0NDo1Ni0wNzowMGFOGmwAAAAldEVYdGRhdGU6Y3JlYXRlADIwMTAtMDItMjBUMjM6MjY6MjQtMDc6MDAuw1DWAAAAJXRFWHRkYXRlOm1vZGlmeQAyMDEwLTAxLTExVDA4OjU3OjQzLTA3OjAwwqyWbAAAADJ0RVh0TGljZW5zZQBodHRwOi8vZW4ud2lraXBlZGlhLm9yZy93aWtpL1B1YmxpY19kb21haW4//erPAAAAJXRFWHRtb2RpZnktZGF0ZQAyMDA5LTExLTI4VDIyOjQ0OjU2LTA3OjAwPv9sWAAAABl0RVh0U291cmNlAFRhbmdvIEljb24gTGlicmFyeVTP7YIAAAA6dEVYdFNvdXJjZV9VUkwAaHR0cDovL3RhbmdvLmZyZWVkZXNrdG9wLm9yZy9UYW5nb19JY29uX0xpYnJhcnm8yK3WAAAAcnRFWHRzdmc6YmFzZS11cmkAZmlsZTovLy9tbnQvb2dyZS9wcml2eS9kb2NzL2ljb25zL29wZW5faWNvbl9saWJyYXJ5LWRldmVsL2ljb25zL3RhbmdvL3N2ZzJwbmcvZW1vdGVzL2ZhY2Utc21pbGUtMi5zdmerBUU8AAAAAElFTkSuQmCC');
		\OC_Util::obEnd();

		echo $image->show();
	}
	
}