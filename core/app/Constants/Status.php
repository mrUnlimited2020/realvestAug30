<?php

namespace App\Constants;

class Status
{
    const ENABLE  = 1;
    const DISABLE = 0;

    const YES = 1;
    const NO  = 0;

    const VERIFIED   = 1;
    const UNVERIFIED = 0;

    const PAYMENT_INITIATE = 0;
    const PAYMENT_SUCCESS  = 1;
    const PAYMENT_PENDING  = 2;
    const PAYMENT_REJECT   = 3;

    const TICKET_OPEN   = 0;
    const TICKET_ANSWER = 1;
    const TICKET_REPLY  = 2;
    const TICKET_CLOSE  = 3;

    const PRIORITY_LOW    = 1;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_HIGH   = 3;

    const USER_ACTIVE = 1;
    const USER_BAN    = 0;

    const KYC_UNVERIFIED = 0;
    const KYC_PENDING    = 2;
    const KYC_VERIFIED   = 1;

    const DAY   = 1;
    const MONTH = 2;
    const YEAR  = 3;

    const INVEST_TYPE_ONETIME     = 1;
    const INVEST_TYPE_INSTALLMENT = 2;

    const PROFIT_TYPE_FIXED = 1;
    const PROFIT_TYPE_RANGE = 2;

    const PROFIT_AMOUNT_TYPE_FIXED   = 1;
    const PROFIT_AMOUNT_TYPE_PERCENT = 2;

    const CAPITAL_BACK_YES = 1;
    const CAPITAL_BACK_NO  = 2;

    const PROFIT_LIFETIME      = 1;
    const PROFIT_REPEATED_TIME = 2;
    const PROFIT_ONETIME       = 3;

    const PROFIT_DISTRIBUTION_MANUAL = 1;
    const PROFIT_DISTRIBUTION_AUTO   = 2;

    const PROPERTY_INITIATE  = 0;
    const PROPERTY_RUNNING   = 1;
    const PROPERTY_COMPLETED = 2;

    const RUNNING            = 1;
    const COMPLETED          = 2;
    const INVESTMENT_RUNNING = 3;

    const INSTALLMENT_SUCCESS = 1;
    const INSTALLMENT_PENDING = 2;

    const PROFIT_PENDING = 0;
    const PROFIT_SUCCESS = 1;
}
