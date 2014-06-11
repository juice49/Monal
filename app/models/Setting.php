<?php
namespace Monal\Models;
/**
 * Setting.
 *
 * This is a model of a system setting.
 *
 * @author  Arran Jacques
 */

class Setting extends Model
{
    /**
     * The setting's ID.
     *
     * @var     Integer
     */
    protected $id = null;

    /**
     * The setting's key.
     *
     * @var     String
     */
    protected $key = null;

    /**
     * The setting's value.
     *
     * @var     String
     */
    protected $value = null;

    /**
     * Return the setting's ID.
     *
     * @return  Integer
     */
    public function ID()
    {
        return (integer) $this->id;
    }

    /**
     * Return the setting's key.
     *
     * @return  String
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * Return the setting's value.
     *
     * @return  String
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Set the setting's ID.
     *
     * @param   Integer
     * @return  Void
     */
    public function setID($id)
    {
        $this->id = (integer) $id;
    }

    /**
     * Set the setting's key.
     *
     * @param   String
     * @return  Void
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Set the setting's value.
     *
     * @param   String
     * @return  Void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Check the setting validates against a set of given rules.
     *
     * @param   Array
     * @param   Array
     * @return  Boolean
     */
    public function validates(array $validation_rules = array(), array $validation_messages = array())
    {
        $data = array(
            'key' => $this->key,
            'value' => $this->value,
        );
        $validation = \Validator::make($data, $validation_rules, $validation_messages);
        if ($validation->passes()) {
            return true;
        } else {
            $this->messages->merge($validation->messages());
            return false;
        }
    }
}