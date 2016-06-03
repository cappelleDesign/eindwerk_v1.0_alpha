<?php

class notificationHandler {

    /**
     * The user database handler
     * @var UserDao 
     */
    private $_userDb;

    /**
     * The comment database handler
     * @var CommentDao 
     */
    private $_commentDb;

    /**
     * The review database handler
     * @var ReviewsDao 
     */
    private $_reviewDb;

    public function __construct(UserDao $userDb, CommentDao $commentDb, ReviewsDao $reviewDb) {
        $this->init($userDb, $commentDb, $reviewDb);
    }

    private function init($userDb, $commentDb, $reviewDb) {
        $this->_userDb = $userDb;
        $this->_commentDb = $commentDb;
        $this->_reviewDb = $reviewDb;
    }

    /**
     * notifyParents
     * Notifies the direct parent of this comment and the rootparent if necessary
     * @param Comment $comment
     */
    public function notifyParentWriterCommented($comment) {
        $txt = 'replied to your comment';
        if ($comment->getParentId()) {
            $parent = $this->_commentDb->get($comment->getParentId());
            if ($parent->getNotifId()) {
                $body = $this->buildNotificationBody($comment->getParentId(), $txt);
                if ($body === -1) {
                    $this->_commentDb->updateCommentNotification($parent->getId(), NULL);
                    $this->_userDb->removeNotification($parent->getNotifId());
                } else {
                    $this->_userDb->updateNotification($parent->getNotifId(), $body, FALSE);
                }
            } else {
                $body = $comment->getPoster()->getUsername() . ' ' . $txt;
                $notif = $this->createNotif($parent->getId(), $parent->getPoster()->getId(), $body);
                $notifId = $this->_userDb->addNotification($parent->getPoster()->getId(), $notif);
                $this->_commentDb->updateCommentNotification($comment->getParentId(), $notifId);
            }
        } else {
            $txt = 'commented on your ';
            $parent = $this->_commentDb->getSuperParentId($comment->getId());
            //TODO notify review writer if user review when review db is ready
        }
    }

    public function notifyParentWriterVoted($commentId, $voterId, $voterName, $voteFlag, $notifIdPrev = 0) {
        $notifId = $notifIdPrev ? $notifIdPrev : $this->_commentDb->getVotedNotifId($commentId, $voteFlag);
        $text = $this->getVoteText($voteFlag);
        if ($notifId < 0 && $voterName > -1) {
            $body = $voterName . ' ' . $text;
            $notification = $this->createNotif($commentId, $voterId, $body);
            $notifId = $this->_userDb->addNotification($voterId, $notification);
        } else {
            $body = $this->buildVoteNotifBody($commentId, $voteFlag, $voterName, $text);
            if ($body === -1) {
                $this->_userDb->removeNotification($notifId);
            } else {
                $this->_userDb->updateNotification($notifId, $body);
            }
        }
        return $notifId;
    }

    private function getVoteText($voteFlag) {
        switch ($voteFlag) {
            case '1':
                return 'downvoted your comment :(';
            case '2' :
                return 'upvoted your comment!';
            case '3' :
                return 'gave your comment a diamond';
        }
    }

    private function buildVoteNotifBody($commentId, $flag, $voterName, $text) {
        $voters = $this->_commentDb->getVoters($commentId, $flag, 2);
        $keys = array_keys($voters);
        $count = $this->_commentDb->getVotersCount($commentId, $flag);        
        if (!$count) {
            return -1;
        }        
        $body = '';
        $i = 0;
        if ($voterName !== -1) {
            $body = $voterName;
        } else {
            $i = 1;
            $body = $voters[$keys[0]]->getVoterName();
        }
        if ($count > 2 + $i) {            
            $body .= ', ' . $voters[$keys[0 + $i]]->getVoterName();
            $body .= ', ' . $voters[$keys[1 + $i]]->getVoterName();
            $body .= ' and ' . ($count - 2) . ' other(s)';
        } else if ($count > 1 + $i) {
            $body .= ', ' . $voters[$keys[0 + $i]]->getVoterName() . ' and ' . $voters[$keys[1]]->getVoterName();
        } else if ($count > 0 + $i) {
            $body .= ' and ' . $voters[$keys[0 + $i]]->getVoterName();
        } else if ($voterName === -1) {
            return $voterName;
        }
        $body .= ' ' . $text;
        return $body;
    }

    /**
     * buildNotificationBody
     * Creates the correct body for comment related notification
     * @param int $subsForId     
     * @param string $text
     */
    private function buildNotificationBody($subsForId, $text) {

        $lastComments = $this->_commentDb->getSubComments($subsForId, 3, true);
        $count = $this->_commentDb->getSubCommentsCount($subsForId, true);
        if (!$count) {
            return -1;
        }
        $body = $lastComments[0]->getPoster()->getUsername();
        if ($count > 3) {
            $body .= ', ' . $lastComments[1]->getPoster()->getUsername();
            $body .= ', ' . $lastComments[2]->getPoster()->getUsername();
            $body .= ' and ' . ($count - 3) . ' other(s)';
        } else {
            if ($count > 2) {
                $body .= ', ' . $lastComments[1]->getPoster()->getUsername() . ' and ' . ($count - 2) . ' other(s)';
            } else if ($count > 1) {
                $body .= ' and ' . $lastComments[1]->getPoster()->getUsername();
            }
        }
        $body .= ' ' . $text;
        return $body;
    }

    private function createNotif($commentId, $userId, $body) {
        $linkBase = 'index.php/comments/show-comment/';
        $format = Globals::getDateTimeFormat('mysql', true);
        $date = DateFormatter::getNow()->format($format);
        $notif = new Notification($userId, $body, $linkBase . $commentId, $date, FALSE, $format);
        return $notif;
    }

}
