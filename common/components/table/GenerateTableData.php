<?php

namespace tframe\common\components\table;

use tframe\core\database\MagicRecord;

class GenerateTableData {
	private static array $disabledAttributes = ['password', 'token', 'errors',];

	public static function convertData (array|MagicRecord $data, string|array $disabled = null): false|string {
		if (!is_null($disabled)) {
			if (is_array($disabled)) {
				foreach ($disabled as $d) {
					self::$disabledAttributes[] = $d;
				}
			} else {
				self::$disabledAttributes[] = $disabled;
			}
		}

		if (is_array($data)) {
			foreach ($data as $model) {
				foreach (self::$disabledAttributes as $attribute) {
					unset($model->$attribute);
				}
			}
		} else {
			foreach (self::$disabledAttributes as $attribute) {
				unset($data->$attribute);
			}
		}

		return json_encode($data);
	}
}