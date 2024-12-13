<?php
defined('ABSPATH') || exit;
/**
 * WVL_Venue class
 */
class WVL_Venue
{
    /**
     * The venue ID
     */
    private $_venue_id;


    /**
     * Constructor
     *
     * @param int $venue_id The ID of the venue
     */
    public function __construct($venue_id)
    {
        $this->_venue_id = $venue_id;
    }
}
