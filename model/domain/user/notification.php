<?php

/**
 * Notification
 * @package model
 * @subpackage domain.user
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class Notification implements DaoObject {

    /**
     * Id for database purposes
     * @var int 
     */
    private $_id = -1;

    /**
     * User to who the notification belongs
     * @var User
     */
    private $_userId;

    /**
     * The notification body
     * @var string 
     */
    private $_text;

    /**
     * When the notification was created (date and time)
     * @var DateTime 
     */
    private $_created;

    /**
     * Wheter the notification was read or not
     * @var boolean
     */
    private $_isRead;

    public function __construct($userId, $text, $created, $isRead, $format) {
        $this->setUserId($userId);
        $this->setText($text);
        $this->setCreated($created, $format);
        $this->setIsRead($isRead);
    }

    /* ---------------------------------------------------------------------- */

    public function setId($id = -1) {
        $this->_id = $id;
    }

    public function setUserId($userId) {
        $this->_userId = $userId;
    }

    public function setText($text) {
        $this->_text = $text;
    }

    public function setCreated($created, $format) {
        $this->_created = DateTime::createFromFormat($format, $created);
    }

    public function setIsRead($isRead) {
        $this->_isRead = $isRead;
    }

    /* ---------------------------------------------------------------------- */

    public function getId() {
        return $this->_id;
    }

    public function getUserId() {
        return $this->_userId;
    }

    public function getText() {
        return $this->_text;
    }

    public function getCrated() {
        return $this->_created;
    }

    public function getIsRead() {
        return $this->_isRead;
    }

    /**
     * getCreatedStr
     * returns the creation date and time as string with given format.
     * format should be a php datetime format string.
     * @param string $format
     * @return string
     */
    public function getCreatedStr($format) {
        return $this->_created->format($format);
    }

}
