<?php
namespace Monal\Libraries;
/**
 * Flash Messages.
 *
 * This is a library for flashing and retrieve messages to a user’s session.
 *
 * @author  Arran Jacques
 */

class FlashMessages
{
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