<?php
/**
 * ReviewDistDao
 * This is an interface for all classes that handle review dist database functionality
 * @package dao
 * @subpackage dao.review.dist
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
interface ReviewDistDao {

    /**
     * AddUserScore
     * Adds a user score to the user scores
     * @param int $reviewId
     * @param int $userId
     * @param int $userScore
     */
    public function addUserScore($reviewId, $userId, $userScore);

    /**
     * updateUserScore
     * Updates the user score for this user and review combination
     * @param int $reviewId
     * @param int $userId
     * @param int $newScore
     */
    public function udpateUserScore($reviewId, $userId, $newScore);

    /**
     * RemoveUserScore
     * Removes a user score from the user scores
     * @param int $reviewId
     * @param int $userId
     */
    public function removeUserScore($reviewId, $userId);

    /**
     * addGoodBadTag
     * Adds a good, a bad or a tag to the database
     * @param int $reviewId
     * @param int $goodBadTag
     */
    public function addGoodBadTag($reviewId, $goodBadTag);

    /**
     * removeGoodBadTag
     * Removew a good, a bad or a tag from the database
     * @param int $reviewId
     * @param int $goodBadTagId
     */
    public function removeGoodBadTag($reviewId, $goodBadTagId);

    /**
     * addGalleryImage
     * Adds a image to the gallery of this review
     * @param int $reviewId
     * @param Image $image
     */
    public function addGalleryImage($reviewId, Image $image);

    /**
     * removeGalleryImage
     * Removes an image from the gallery of this review
     * @param int $reviewId
     * @param int $imageId
     */
    public function removeGalleryImage($reviewId, $imageId);
    
    /**
     * addRootComment
     * Adds a root comment to this review.
     * A root comment is a comment that is a direct child of this review
     * @param int $reviewId
     * @param Comment $rootComment
     */
    public function addRootComment($reviewId, Comment $rootComment);

    /**
     * removeRootComment
     * Removew a root comment from this review.
     * A root comment is a comment that is a direct child of this review
     * @param int $reviewId
     * @param int $commentId
     */
    public function removeRootComment($reviewId, $commentId);

    /**
     * addVoter
     * Adds a voter to this review
     * @param int $reviewId
     * @param int $voterId
     * @param int $voterFlag
     */
    public function addVoter($reviewId, $voterId, $voterFlag);

    /**
     * removeVoter
     * Removes a voter from this review
     * @param int $reviewId
     * @param int $voterId
     */
    public function removeVoter($reviewId, $voterId);

    /**
     * updateVoter
     * Updates a voter for this review
     * @param int $reviewId
     * @param int $voterId
     * @param int $voterFlag
     */
    public function updateVoter($reviewId, $voterId, $voterFlag);
}
