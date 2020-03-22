<?php

class WebConstants extends WebConstantsBase
{
    const ID_CATEGORY_INACTIVE = 4;
    const ID_CATEGORY_SOLD = 5;
    const ID_CATEGORY_NEXT = 7;
    const ID_CATEGORY_IN_AUCTION = 6;

    const ID_CATEGORY_PRESENTATION_HOME = 14;
    const ID_CATEGORY_PRESENTATION_HELP = 15;
    const ID_CATEGORY_PRESENTATION_SOLD = 16;
    const ID_CATEGORY_PRESENTATION_SCHEDULE = 18;

    const USER_FOLDER_ID = 8;
    const USER_DEFAULT_BANS = 5;

    const BID_INCREASE_AMOUNT = 0.01;
    const BID_QUEUE_SIZE = 10; // For the product detail
    const BID_SCHEDULE_MIN_SECONDS = 5; // The minimal schedule seconds to place bid

    const AUCTION_REFRESH_ITERATION_MILISECONDS = 2000;
    const AUCTION_REFRESH_CRON_MILISECONDS = 60000;
    const AUCTION_MAX_ITEMS = 6; // Max items in auction

    const MAIL_COMMERCIAL = 'info@banmonkey.com';
    const MAIL_NOREPLY = 'noreply@banmonkey.com';

    const CONTACT_PHONE = '645 59 34 55';
}
 