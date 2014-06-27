<?php
namespace Monal\Libraries;
/**
 * Flash Messages.
 *
 * This is a library for flashing and retrieve messages to a user’s session.
 *
 * @author  Arran Jacques
 */

use Illuminate\Support\MessageBag;

class FlashMessages
{
    /**
     * Check if there are any flash message in the user’s session.
     *
     * @return  Boolean
     */
    public function any()
    {
        return $this->all()->count() > 0;
    }

    /**
     * Check if there is a specific flash message in the user’s session.
     *
     * @param   String
     * @return  Boolean
     */
    public function has($key)
    {
        return $this->all()->has($key);
    }

    /**
     * Flash a message to the user's session.
     *
     * @param   String
     * @param   String
     * @return  Void
     */
    public function flash($key, $message)
    {
        $messages = $this->all();
        $messages->add($key, $message);
        \Session::flash('flash_messages', $messages->toArray());
    }

    /**
     * Flash all of the messages in a message bag to the user’s session.
     *
     * @param   Illuminate\Support\MessageBag
     * @return  Void
     */
    public function flashMessageBag(MessageBag $message_bag)
    {
        \Session::flash('flash_messages', $message_bag->toArray());
    }

    /**
     * Get a flash message from the user’s session by its key.
     *
     * @param   String
     * @return  Array / String
     */
    public function get($key)
    {
        return $this->has($key) ? $this->all()->get($key) : null; 
    }

    /**
     * Return all flash messages from the user's session.
     *
     * @return  Illuminate\Support\MessageBag
     */
    public function all()
    {
        $messages = \App::make('Illuminate\Support\MessageBag');
        if (\Session::has('flash_messages')) {
            $messages->merge(\Session::get('flash_messages'));
        }
        return $messages;
    }
}