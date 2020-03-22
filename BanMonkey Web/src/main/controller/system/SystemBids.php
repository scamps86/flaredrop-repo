<?php

class SystemBids
{


    /**
     * Get the last 10 bids of a product
     *
     * @param int $productId The product id
     */
    public static function getProductBids($productId)
    {
        // Get global server database connection
        $connection = Managers::mySQL(false);

        // Generate the query to get the products bids list (not using the generic library because of the performance)
        $q = new VoSelectQuery();
        $q->select = 'bidId, userNick, TIMESTAMPDIFF(SECOND, NOW(), auctionExpireDate) as auctionExpireTime, currentPrice';
        $q->from = 'bid';
        $q->where = 'objectId=' . UtilsString::sqlQuote($productId);
        $q->orderBy = 'creationDate DESC';
        $q->limit = WebConstants::BID_QUEUE_SIZE;

        // Do the query
        $q->result = $connection->queryToArray($q->generateQuery());

        // Return the result
        return $q->result;
    }


    /**
     * Get the current product winner user. If no user, it will return a null object
     *
     * @param int $productId The product id
     *
     * @return VoUser The user
     */
    public static function getProductCurrentWinner($productId)
    {
        $productsLastBid = self::getProductsLastBid();
        foreach ($productsLastBid as $p) {
            if ($p['objectId'] == $productId) {
                return SystemUsers::get($p['userId']);
            }
        }
        return null;
    }


    /**
     * Remove all related product bids
     *
     * @param int $productId The product id
     *
     * @return boolean
     */
    public static function removeProductBids($productId)
    {
        // Get global server database connection (USER SESSION NOT REQUIRED)
        $connection = Managers::mySQL(false);

        // Return the resulting boolean
        return $connection->query('DELETE FROM bid WHERE objectId=' . $productId);
    }


    /**
     * Get the last bid of each auction product
     *
     * @returns array Array containing each product bid
     */
    public static function getProductsLastBid()
    {
        // Get global server database connection
        $connection = Managers::mySQL(false);

        // Generate the query to get the products bids list (not using the generic library because of the performance)
        $q = new VoSelectQuery();
        $q->select = 'bids.bidId, bids.objectId, bids.userId, bids.userNick, TIMESTAMPDIFF(SECOND, NOW(), bids.auctionExpireDate) as auctionExpireTime, bids.currentPrice';
        $q->from = '(SELECT b . * FROM object o, object_folder of, bid b WHERE b.objectId = o.objectId AND of.objectId = o.objectId AND ';
        $q->from .= 'of.folderId = ' . WebConstants::ID_CATEGORY_IN_AUCTION . ' AND ';
        $q->from .= 'o.type = ' . UtilsString::sqlQuote('product') . ' ORDER BY b.creationDate DESC) bids';
        $q->groupBy = 'bids.objectId';

        // Do the query
        $q->result = $connection->queryToArray($q->generateQuery());

        // Return the result
        return $q->result;
    }


    /**
     * Apply a bid! The user must be logged before placing a bid. An empty string is returned if all is OK
     *
     * @param int $productId The product id
     * @param int $userId The user id (optional when the bid is auto)
     *
     * @return string "", "ERROR" (generic error), "BANS" (user has no bans), "CURRENT" (user is the last bidder), "AUCTION" (product not in auction)
     */
    public static function doBid($productId, $userId = '')
    {
        // Check if user in session
        $inSession = $userId == '';

        // Get global server database connection (USER SESSION REQUIRED)
        $connection = $inSession ? Managers::mySQL(true, WebConfigurationBase::$DISK_WEB_ID) : Managers::mySQL(false);

        // Get the logged user who is placing the bid
        $userData = $inSession ? SystemUsers::getLogged(WebConfigurationBase::$DISK_WEB_ID) : SystemUsers::get($userId);

        // Get the product that we're placing the bid
        $product = SystemDisk::objectGet($productId, 'product');

        // Get the bid bans price
        $bidBans = intval($product->propertyGet('bidBans'));

        // Validate if the user exists and has bans
        if ($userData && intval($userData->data) >= $bidBans) {
            // Get the product current winner
            $winner = self::getProductCurrentWinner($productId);
            $winnerId = $winner == null ? -1 : $winner->userId;

            if ($winnerId != $userData->userId) {
                // Validate if the product exists and is in auction, Get the product action expire time
                $auctionExpireTime = UtilsDate::toTimestamp($product->propertyGet('auctionExpireDate')) - UtilsDate::toTimestamp('');

                if ($product && WebConstants::ID_CATEGORY_IN_AUCTION == $product->firstFolderIdGet() && $auctionExpireTime > 0) {
                    // Increase the product current price
                    $product->propertySet('currentPrice', floatval($product->propertyGet('currentPrice')) + (WebConstants::BID_INCREASE_AMOUNT * $bidBans));
                    $product->propertySet('auctionExpireDate', UtilsDate::operate('SECOND', UtilsDate::create(), $product->propertyGet('bidIncreaseTime')));

                    // Update the product
                    $result = SystemDisk::objectSet($product, 'product', $inSession, WebConfigurationBase::$DISK_WEB_ID);

                    if ($result->state) {
                        // Update the user bans
                        $userData->data = $userData->data - $bidBans;
                        $result = SystemUsers::set($userData, false, $inSession, WebConfigurationBase::$DISK_WEB_ID);

                        // Do the bid
                        if ($result->state) {
                            // Fill the bid entity
                            $bid = new VoBid();
                            $bid->objectId = $productId;
                            $bid->userId = $userData->userId;
                            $bid->userNick = $userData->name;
                            $bid->creationDate = UtilsDate::create();
                            $bid->auctionExpireDate = $product->propertyGet('auctionExpireDate');
                            $bid->currentPrice = $product->propertyGet('currentPrice');

                            // Insert the bid
                            if ($connection->insertUpdateFromClass($bid, 'bidId', 'bid', 'objectId, userId, userNick, creationDate, auctionExpireDate, currentPrice')) {
                                return '';
                            }
                        }
                    }
                } else {
                    return 'AUCTION';
                }
            } else {
                return 'CURRENT';
            }
        } else {
            return 'BANS';
        }
        return 'ERROR';
    }


    /**
     * Create or update an user bid schedule
     *
     * @param int $productId The product id
     * @param int $maxBans The max bans
     * @param float $maxPrice The max price
     * @param int $bidScheduleId The bid schedule id (only if we want to update it)
     * @param int $userId The user id (for authomatic process)
     *
     * @return boolean
     */
    public static function setSchedule($productId, $maxBans, $maxPrice, $bidScheduleId = '', $userId = '')
    {
        $inSession = $userId == '';

        // Get global server database connection (USER SESSION REQUIRED)
        $connection = $inSession ? Managers::mySQL(true, WebConfigurationBase::$DISK_WEB_ID) : Managers::mySQL(false);

        // Validate if the product id is in auction mode
        $product = SystemDisk::objectGet($productId, 'product');

        if (WebConstants::ID_CATEGORY_IN_AUCTION != $product->firstFolderIdGet()) {
            return false;
        }

        // Get the logged user who is programming a new bid schedule
        $userData = $inSession ? SystemUsers::getLogged(WebConfigurationBase::$DISK_WEB_ID) : SystemUsers::get($userId);

        // Create the bid schedule entity
        $bidSchedule = new VoBidSchedule();
        $bidSchedule->objectId = $productId;
        $bidSchedule->userId = $userData->userId;
        $bidSchedule->maxBans = $maxBans;
        $bidSchedule->maxPrice = $maxPrice;

        if ($bidScheduleId != '') {
            $bidSchedule->bidScheduleId = $bidScheduleId;
        }

        // Insert the bid schedule
        return $connection->insertUpdateFromClass($bidSchedule, 'bidScheduleId', 'bid_schedule', 'objectId, userId, maxBans, maxPrice');
    }


    /**
     * Remove the specified user bid schedules by the scheduleId
     *
     * @param array $ids The user bid schedule ids array
     *
     * @return boolean
     */
    public static function removeSchedules(array $ids)
    {
        // Get global server database connection (USER SESSION NOT REQUIRED)
        $connection = Managers::mySQL(false);

        // Generate the deletion where
        $where = '';
        for ($i = 0; $i < count($ids); $i++) {
            $where .= ($i == 0 ? '' : ' OR ') . 'bidScheduleId=' . $ids[$i];
        }

        // Return the resulting boolean
        return $connection->query('DELETE FROM bid_schedule WHERE ' . $where);
    }


    /**
     * Remove the specified user bid schedules by the product id
     *
     * @param int $productId The product id
     *
     * @return boolean
     */
    public static function removeSchedulesByProduct($productId)
    {
        // Get global server database connection (USER SESSION NOT REQUIRED)
        $connection = Managers::mySQL(false);

        // Return the resulting boolean
        return $connection->query('DELETE FROM bid_schedule WHERE objectId=' . UtilsString::sqlQuote($productId));
    }


    /**
     * Get the current schedules
     *
     * @value int $userId The user schedules. If no user defined it will return all users schedules
     *
     * @return array
     */
    public static function getSchedules($userId = '')
    {
        // Get global server database connection (USER SESSION NOT REQUIRED)
        $connection = Managers::mySQL(false);

        // Define the query
        $q = new VoSelectQuery();
        $q->select = '*';
        $q->from = 'bid_schedule';
        $q->orderBy = 'bidScheduleId DESC';

        if ($userId != '') {
            $q->where = 'userId=' . UtilsString::sqlQuote($userId);
        }

        // Do the query
        $q->result = $connection->queryToArray($q->generateQuery());

        // Return the result
        return $q->result;
    }
}