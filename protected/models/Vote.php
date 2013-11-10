<?php

class Vote extends CActiveRecord{
    /**
     * Adds a vote either up or down to a certain comment. User must be
     * logged in for the voting mechanism to function properly
     *
     * @param int $commentId Comment to vote on
     * @return boolean if added or not
     */
    public static function addVote($model, $id, $up = true) {
        $userId = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $criteria->condition = "commentId = $id";
        $criteria->addCondition("userId = $userId");
        $criteria->limit = 1; // Only need 1 record to search for
        $row = $model->find($criteria);


        if (!$row) { // Check if existance of a vote
            // Add vote if row does not exist
            $cm = new $model;
            $cm->userId = $userId;
            $cm->commentId = $id;
            if ($up) {
                $cm->up = 1;
                $cm->down = 0;
            } else {
                $cm->up = 0;
                $cm->down = 1;
            }
            return $cm->save();
        } else {
            if (($up && $row->up == 1) || (!$up && $row->down == 1)) {
                // Enter here when user wishes to toggle the vote (pressed thumbs up after previously voted up)
                // Reset votes
                $row->up = 0;
                $row->down = 0;
            } else {
                // Enter here when user has changed previous vote from Up to Down or vice versa
                if ($up) {
                    $row->up = 1;
                    $row->down = 0;
                } else {
                    $row->up = 0;
                    $row->down = 1;
                }
            }
            return $row->save();
        }
    }

    /**
     * Checks to see if the user has voted up already for a given comment
     * @todo may want to optimize this with a query instead of looping through all of the votes
     */
    public static function hasVotedUp($votes, $id) {
         if(Yii::app()->user->isGuest)
            return false;
        foreach ($votes as $vote) {
            if ($vote->commentId == $id && $vote->userId == Yii::app()->user->id && $vote->up == 1)
                return true;
        }

        return false;
    }

    /**
     * Checks to see if the user has voted down already for a given comment
     * @todo may want to optimize this with a query instead of looping through all of the votes
     */
    public static function hasVotedDown($votes, $id) {
        if(Yii::app()->user->isGuest)
            return false;

        foreach ($votes as $vote) {
            if ($vote->userId == Yii::app()->user->id && $vote->down == 1)
                return true;
        }
        return false;
    }
}

