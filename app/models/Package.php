<?php
namespace Monal\Models;
/**
 * Package.
 *
 * This is a model of a system package.
 *
 * @author  Arran Jacques
 */

class Package extends Model
{
    /**
     * The package's ID.
     *
     * @var     Integer
     */
    protected $id = null;

    /**
     * The package's name.
     *
     * @var     String
     */
    protected $name = null;

    /**
     * Return the package's ID.
     *
     * @return  Integer
     */
    public function ID()
    {
        return (integer) $this->id;
    }

    /**
     * Return the package's name.
     *
     * @return  String
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Set the package's ID.
     *
     * @param   Integer
     * @return  Void
     */
    public function setID($id)
    {
        $this->id = (integer) $id;
    }

    /**
     * Set the package's name.
     *
     * @param   String
     * @return  Void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Check the package validates against a set of given rules.
     *
     * @param   Array
     * @param   Array
     * @return  Boolean
     */
    public function validates(array $validation_rules = array(), array $validation_messages = array())
    {
        $data = array(
            'name' => $this->name,
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