<?php

// CRON COMMAND:
//php public_html/banmonkey/controller/crons/RefreshAuction.php
//php /home/banmonkey/public_html/controller/crons/RefreshAuction.php

// Load the library
require_once dirname(__FILE__) . '/../system/SystemWebLoader.php';

// Define mails to send at the end of this script to prevent delays
$mailsToSend = [];

// Initialize the timer to sync the cron task (processed every minute and looped every 5 seconds)
Managers::timer()->start('cronTime');
$startAgain = true;

// Initialize the iteration
while ($startAgain) {
    // Initialize the iteration time
    Managers::timer()->start('iterationTime');

    // Get the in auction products
    $filter = new VoSystemFilter();
    $filter->setLanTag(WebConstants::getLanTag());
    $filter->setAND();
    $filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
    $filter->setAND();
    $filter->setRootId(WebConfigurationBase::$ROOT_ID);
    $filter->setAND();
    $filter->setFolderId(WebConstants::ID_CATEGORY_IN_AUCTION);

    $inAuctionProducts = SystemDisk::objectsGet($filter, 'product');

    // Get the schedules
    $schedules = SystemBids::getSchedules();

    // Update the in auction product states and times
    $inAuctionItems = 0;

    foreach ($inAuctionProducts->list as $p) {
        // Set if the bid is done or not
        $bidDone = false;

        // Get the iteration product
        $product = SystemDisk::objectGet($p['objectId'], 'product');

        // If no auction expire date defined, increase it as default
        if ($product->propertyGet('auctionExpireDate') == '') {
            $product->propertySet('auctionExpireDate', UtilsDate::operate('SECOND', UtilsDate::create(), $product->propertyGet('initialTime')));
            SystemDisk::objectSet($product, 'product', false);
        }

        // Place the scheduled bids only on the last product 5 seconds
        if (UtilsDate::toTimestamp(UtilsDate::operate('SECONDS', UtilsDate::create(), WebConstants::BID_SCHEDULE_MIN_SECONDS)) >= UtilsDate::toTimestamp($product->propertyGet('auctionExpireDate'))) {
            foreach ($schedules as $s) {
                if ($product->objectId == $s['objectId']) {
                    if (floatval($s['maxPrice']) > floatval($product->propertyGet('currentPrice')) && intval($s['maxBans']) > 0) {
                        if (!$bidDone) {
                            $doBid = SystemBids::doBid($s['objectId'], $s['userId']);

                            if ($doBid != '') {
                                // If there is an error placing a bid...
                                if ($doBid == 'BANS') {
                                    // Remove the schedule if BANS expired
                                    SystemBids::removeSchedules([$s['bidScheduleId']]);
                                }
                            } else {
                                // Decrease the maxBans for the schedule as the product bid bans price
                                $s['maxBans'] = intval($s['maxBans']) - intval($product->propertyGet('bidBans'));
                                SystemBids::setSchedule($product->objectId, $s['maxBans'], $s['maxPrice'], $s['bidScheduleId'], $s['userId']);
                                $bidDone = true;
                            }
                        }
                    } else {
                        // If maxPrice or maxBans expire, remove the schedule
                        SystemBids::removeSchedules([$s['bidScheduleId']]);
                    }
                }
            }
        }

        // Validate if the product auction time is expired
        if (UtilsDate::toTimestamp('') > UtilsDate::toTimestamp($product->propertyGet('auctionExpireDate'))) {
            // Define the email that tells that the product is finished to the customer
            $winner = SystemBids::getProductCurrentWinner($p['objectId']);

            if ($winner) {
                $mailToCustomer = [];
                $mailToCustomer['sender'] = WebConstants::MAIL_NOREPLY;
                $mailToCustomer['receiver'] = $winner->email;
                $mailToCustomer['subject'] = $winner->firstName . ', eres el ganador de ' . $p['name'] . '!';
                $mailToCustomer['message'] = 'Acabas de ganar el producto ' . $p['name'] . '!';

                $mailToSeller = [];
                $mailToSeller['sender'] = WebConstants::MAIL_NOREPLY;
                $mailToSeller['receiver'] = WebConstants::MAIL_COMMERCIAL;
                $mailToSeller['subject'] = 'El cliente ' . $winner->name . ' ha ganado la subasta: ' . $p['name'] . '!';
                $mailToSeller['message'] = 'El cliente ' . $winner->name . ' ha ganado la subasta: ' . $p['name'] . '!';

                array_push($mailsToSend, $mailToCustomer);
                array_push($mailsToSend, $mailToSeller);
            }

            // Set the product as sold
            SystemDisk::objectsLink([$p['objectId']], WebConstants::ID_CATEGORY_SOLD, 'product', false);
            SystemDisk::objectsUnlink([$p['objectId']], WebConstants::ID_CATEGORY_IN_AUCTION, 'product', false);

            // Remove the product related bids
            SystemBids::removeProductBids($p['objectId']);

            // Remove all product bid schedules
            SystemBids::removeSchedulesByProduct($p['objectId']);
        } else {
            $inAuctionItems++;
        }
    }

    // Update the necessary next products as an auction ones
    if ($inAuctionItems < WebConstants::AUCTION_MAX_ITEMS) {
        // Get the necessary next products
        $filter = new VoSystemFilter();
        $filter->setLanTag(WebConstants::getLanTag());
        $filter->setAND();
        $filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
        $filter->setAND();
        $filter->setRootId(WebConfigurationBase::$ROOT_ID);
        $filter->setAND();
        $filter->setFolderId(WebConstants::ID_CATEGORY_NEXT);
        $filter->setSortFields('creationDate', 'ASC');
        $filter->setPageCurrent(0);
        $filter->setPageNumItems(WebConstants::AUCTION_MAX_ITEMS - $inAuctionItems);

        $nextProducts = SystemDisk::objectsGet($filter, 'product');

        // Do the state update
        foreach ($nextProducts->list as $p) {
            SystemDisk::objectsLink([$p['objectId']], WebConstants::ID_CATEGORY_IN_AUCTION, 'product', false);
            SystemDisk::objectsUnlink([$p['objectId']], WebConstants::ID_CATEGORY_NEXT, 'product', false);
        }
    }

    // Clear non auction products auctionExpireDate
    $filter = new VoSystemFilter();
    $filter->setLanTag(WebConstants::getLanTag());
    $filter->setAND();
    $filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
    $filter->setAND();
    $filter->setRootId(WebConfigurationBase::$ROOT_ID);
    $filter->setAND();
    $filter->setOpenParenthesis();
    $filter->setFolderId(WebConstants::ID_CATEGORY_NEXT);
    $filter->setOR();
    $filter->setFolderId(WebConstants::ID_CATEGORY_SOLD);
    $filter->setOR();
    $filter->setFolderId(WebConstants::ID_CATEGORY_INACTIVE);
    $filter->setCloseParenthesis();

    $nonAuctionProducts = SystemDisk::objectsGet($filter, 'product');

    foreach ($nonAuctionProducts->list as $p) {
        if (isset($p['auctionExpireDate']) && $p['auctionExpireDate'] != '') {
            // Get the iteration product and remove the auction expire date
            $product = SystemDisk::objectGet($p['objectId'], 'product');
            $product->propertySet('auctionExpireDate', '');
            SystemDisk::objectSet($product, 'product', false);
        }

        // Remove the non auction bids or schedules
        SystemBids::removeProductBids($p['objectId']);
        SystemBids::removeSchedulesByProduct($p['objectId']);
    }

    // Wait until the refreshing time complies
    Managers::timer()->sleepUntil('iterationTime', WebConstants::AUCTION_REFRESH_ITERATION_MILISECONDS);

    // Verify if the minute is expired
    if (Managers::timer()->get('cronTime') > WebConstants::AUCTION_REFRESH_CRON_MILISECONDS) {
        $startAgain = false;
    }
}

// Process the mails to send
foreach ($mailsToSend as $m) {
    Managers::mailing()->send($m['sender'], $m['receiver'], $m['subject'], $m['message']);
}