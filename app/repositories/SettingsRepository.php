<?php
namespace Monal\Repositories;
/**
 * Settings Repository.
 *
 * This is a repository for storing Settings models.
 *
 * @author  Arran Jacques
 */

use Monal\Models\Setting;

class SettingsRepository extends Repository
{
    /**
     * The database table the repository uses.
     *
     * @var     String
     */
    protected $table = 'settings';

    /**
     * Return a new Settings model.
     *
     * @return  Monal\Models\Setting
     */
    public function newModel()
    {
        return \App::make('Monal\Models\Setting');
    }

    /**
     * Check a Settings model validates for storage.
     *
     * @param   Monal\Models\Setting
     * @return  Boolean
     */
    public function validatesForStorage(Setting $setting)
    {
        // Allow alpha, numeric, hypens, underscores and space characters.
        \Validator::extend('setting', function($attribute, $value, $parameters)
        {
            return preg_match('/^[a-z0-9 \-_]+$/i', $value) ? true : false;
        });
        $unique_exception = ($setting->ID()) ? ',' . $setting->ID() : null;
        $validation_rules = array(
            'key' => 'required|max:60|setting|unique:settings,key' . $unique_exception,
            'value' => 'max:255' . $unique_exception,
        );
        $validation_messages = array(
            'key.required' => 'You need to give this setting a Key.',
            'key.max' => 'The Key for this setting is to long. It must be no more than 60 characters long.',
            'key.setting' => 'The Key for this setting is invalid. It can only contain letter, numbers, underscores, hyphens and spaces.',
            'key.unique' => 'There is already a setting using this key. Please choose a different one.',
            'value.max' => 'The Value for this setting is to long. It must be no more than 255 characters long.',
        );
        if ($setting->validates($validation_rules, $validation_messages)) {
            return true;
        } else {
            $this->messages->merge($setting->messages());
            return false;
        }
    }

    /**
     * Encode a Settings model so it is ready to be stored in the
     * repository.
     *
     * @param   Monal\Models\Settings
     * @return  Array
     */
    protected function encodeForStorage(Setting $setting)
    {
        return array(
            'key' => $setting->key(),
            'value' => $setting->value(),
        );
    }

    /**
     * Decode a Settings repository entry into its model class.
     *
     * @param   stdClass
     * @return  Monal\Models\Setting
     */
    protected function decodeFromStorage($result)
    {
        $setting = $this->newModel();
        $setting->setID($result->id);
        $setting->setKey($result->key);
        $setting->setValue($result->value);
        return $setting;
    }

    /**
     * Retrieve an instance/s from the repository.
     *
     * @param   Integer
     * @return  Illuminate\Database\Eloquent\Collection / Monal\Models\Setting
     */
    public function retrieve($key = null)
    {
        if (!$key) {
            $settings = \App::make('Illuminate\Database\Eloquent\Collection');
            foreach (\DB::table($this->table)->select('*')->get() as $result) {
                $settings->add($this->decodeFromStorage($result));
            }
            return $settings;
        } else {
            if ($result = \DB::table($this->table)->where('id', '=', $key)->first()) {
                $setting = $this->decodeFromStorage($result);
                return $setting;
            }
        }
        return false;
    }

    /**
     * Retrieve an instance from the repository using it's key.
     *
     * @param   String
     * @return  Monal\Models\Setting
     */
    public function retrieveByKey($key)
    {
        if ($result = \DB::table($this->table)->where('key', '=', $key)->first()) {
            $setting = $this->decodeFromStorage($result);
            return $setting;
        }
        return false;
    }

    /**
     * Write a Setting model to the repository.
     *
     * @param   Monal\Models\Setting
     * @return  Boolean
     */
    public function write(Setting $setting)
    {
        if ($this->validatesForStorage($setting)) {
            $encoded = $this->encodeForStorage($setting);
            if ($setting->ID()) {
                $encoded['updated_at'] = date('Y-m-d H:i:s');
                \DB::table($this->table)->where('id', '=', $setting->ID())->update($encoded);
                return true;
            } else {
                $encoded['created_at'] = date('Y-m-d H:i:s');
                $encoded['updated_at'] = date('Y-m-d H:i:s');
                \DB::table($this->table)->insert($encoded);
                return true;
            }
        }
        return false;
    }
}