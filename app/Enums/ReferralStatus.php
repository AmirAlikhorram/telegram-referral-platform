<?php

namespace App\Enums;

enum ReferralStatus: string
{
    case Pending = 'pending';

    case Verified = 'verified';

    case Rewarded = 'rewarded';
}
