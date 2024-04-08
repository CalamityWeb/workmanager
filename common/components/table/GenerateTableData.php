<?php

namespace tframe\common\components\table;

use tframe\common\components\text\Text;
use tframe\core\Application;
use tframe\core\database\MagicRecord;
use tframe\core\exception\InvalidConfigException;

class GenerateTableData {
    private static array $disabledAttributes = ['password', 'token', 'errors',];

    public static function convertData(array|MagicRecord $data, string|array $disabled = null): false|string {
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

    public static function generateColumns($model, array $config = null): string {
        if (!isset($config['remove'])) {
            $config['remove'] = array ();
        }
        if (isset($config['disabledAttributes'])) {
            if (is_array($config['disabledAttributes'])) {
                foreach ($config['disabledAttributes'] as $d) {
                    self::$disabledAttributes[] = $d;
                }
            } else {
                self::$disabledAttributes[] = $config['disabledAttributes'];
            }
        }

        $flag = true;
        $i = 1;
        $placed = array ();

        $duplicate = 0;
        foreach ($model::attributes() as $attribute) {
            if (array_key_exists($attribute, $config['columns'])) {
                $duplicate++;
            }
            if (in_array($attribute, self::$disabledAttributes)) {
                $duplicate++;
            }
        }
        foreach ($config['columns'] as $attribute => $value) {
            if (in_array($attribute, self::$disabledAttributes)) {
                $duplicate++;
            }
        }
        $maxplaced = count($model::attributes()) + count($config['columns']) - $duplicate - count($config['remove']);
        $added = 0;
        $latest = false;
        foreach ($config['columns'] as $column => $settings) {
            if (!isset($settings['place']) and in_array($column, $model::attributes())) {
                $added++;
            }
            if (isset($settings['place']) and $settings['place'] == 'latest' and $latest) {
                throw new InvalidConfigException(Application::t('table', 'Cannot be more than one latest column in a table!'));
            }
            if (isset($settings['place']) and $settings['place'] == 'latest' and !$latest) {
                $latest = true;
            }
        }

        $return = '[';
        while ($flag) {
            foreach ($config['columns'] as $column => $settings) {
                if (isset($settings['place']) and $settings['place'] == $i and
                    !in_array($column, $placed) and !in_array($column, self::$disabledAttributes)) {
                    $placed[] = $column;
                    $return .= '{';
                    if (isset($settings['title'])) {
                        $return .= 'title : "' . $settings['title'] . '",';
                    } elseif (isset($model::labels()[$column])) {
                        $return .= 'title : "' . $model::labels()[$column] . '",';
                    } else {
                        $return .= 'title : "' . $column . '",';
                    }
                    if (isset($settings['data'])) {
                        $return .= 'data : ' . $settings['data'] . ',';
                    } elseif (in_array($column, $model::attributes())) {
                        $return .= 'data : "' . $column . '",';
                    } else {
                        throw new InvalidConfigException(Application::t('table', 'DataTables custom column needs a data field!'));
                    }
                    $return .= '},';
                    unset($config['columns'][$column]);
                    $i++;
                }
            }

            foreach ($model::attributes() as $attribute) {
                if (!in_array($attribute, $placed) and !in_array($attribute, self::$disabledAttributes)
                    and !in_array($attribute, $config['remove'])) {
                    $placed[] = $attribute;
                    $return .= '{';
                    if (isset($config['columns'][$attribute]['title'])) {
                        $return .= 'title : "' . $config['columns'][$attribute]['title'] . '",';
                    } else {
                        $return .= 'title : "' . $model::labels()[$attribute] . '",';
                    }
                    if (isset($config['columns'][$attribute]['data'])) {
                        $return .= 'data : ' . $config['columns'][$attribute]['data'] . ',';
                    } else {
                        $return .= 'data : "' . $attribute . '",';
                    }
                    $return .= '},';
                    unset($config['columns'][$attribute]);
                    $i++;
                    break;
                }
            }

            if (count($placed) == $maxplaced - $added - $latest) {
                foreach ($config['columns'] as $column => $settings) {
                    if (isset($settings['place']) and $settings['place'] == 'latest') {
                        break;
                    }
                    $placed[] = $column;
                    $return .= '{';
                    if (isset($settings['title'])) {
                        $return .= 'title : "' . $settings['title'] . '",';
                    } elseif (isset($model::labels()[$column])) {
                        $return .= 'title : "' . $model::labels()[$column] . '",';
                    } else {
                        $return .= 'title : "' . $column . '",';
                    }
                    if (isset($settings['data'])) {
                        $return .= 'data : ' . $settings['data'] . ',';
                    } else {
                        throw new InvalidConfigException(Application::t('table', 'DataTables custom column needs a data field!'));
                    }
                    $return .= '},';
                    unset($config['columns'][$column]);
                    $i++;
                }
            }

            if (count($placed) == $maxplaced - $latest) {
                $return .= '{';
                $return .= 'title : "' . Application::t('general', 'Created') . '",';
                $return .= 'data : "created_at",';
                $return .= '},';

                $return .= '{';
                $return .= 'title : "' . Application::t('general', 'Updated') . '",';
                $return .= 'data : function (data) {return (!data.updated_at) ? \'' . Text::notSetText() . '\' : data.updated_at },';
                $return .= '},';
                foreach ($config['columns'] as $column => $settings) {
                    $placed[] = $column;
                    $return .= '{';
                    if (isset($settings['title'])) {
                        $return .= 'title : "' . $settings['title'] . '",';
                    } elseif (isset($model::labels()[$column])) {
                        $return .= 'title : "' . $model::labels()[$column] . '",';
                    } else {
                        $return .= 'title : "' . $column . '",';
                    }
                    if (isset($settings['data'])) {
                        $return .= 'data : ' . $settings['data'] . ',';
                    } else {
                        throw new InvalidConfigException(Application::t('table', 'DataTables custom column needs a data field!'));
                    }
                    $return .= '},';
                    unset($config['columns'][$column]);
                    $i++;
                }
            }

            if (count($placed) == $maxplaced) {
                $flag = false;
            }
        }

        $return .= ']';
        return $return;
    }
}