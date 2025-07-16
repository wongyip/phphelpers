<?php namespace Wongyip\PHPHelpers\Traits;

use DateInterval;

trait FormatDateInterval
{
    /**
     * Format the input DateInterval as a human-readable string. e.g. Input
     * 'P9Y8M7DPT6H54M32S' (as DateInterval), output: "9 years 8 months 7 days 6
     * hours 54 minutes and 32 seconds".
     *
     * @param DateInterval $di
     * @return string
     */
    public static function dateInterval(DateInterval $di): string
    {
        // Get all
        $pieces = [];
        $pieces[] = $di->y ? sprintf('%d %s', $di->y, $di->y > 1 ? 'years'   : 'year') : null;
        $pieces[] = $di->m ? sprintf('%d %s', $di->m, $di->d > 1 ? 'months'  : 'month') : null;
        $pieces[] = $di->d ? sprintf('%d %s', $di->d, $di->d > 1 ? 'days'    : 'day') : null;
        $pieces[] = $di->h ? sprintf('%d %s', $di->h, $di->h > 1 ? 'hours'   : 'hour') : null;
        $pieces[] = $di->i ? sprintf('%d %s', $di->i, $di->i > 1 ? 'minutes' : 'minute') : null;
        $pieces[] = $di->s ? sprintf('%d %s', $di->s, $di->s > 1 ? 'seconds' : 'second') : null;

        // No null.
        $pieces = array_filter($pieces);

        // Add "and" before the last segment "3 hours and 15 minutes".
        if (count($pieces) > 1) {
            $pieces[count($pieces) - 1] = 'and ' . $pieces[count($pieces) - 1];
        }
        return implode(' ', $pieces);
    }

    /**
     * Format the input DateInterval as a human-readable string. e.g. Input
     * 'P9Y8M7DPT6H54M32S' (as DateInterval), output: "9 yrs 8 months 7 days 6
     * hrs 54 mins & 32 secs".
     *
     * @param DateInterval $di
     * @return string
     */
    public static function dateIntervalShortForm(DateInterval $di): string
    {
        // Get all
        $pieces = [];
        $pieces[] = $di->y ? sprintf('%d %s', $di->y, $di->y > 1 ? 'yrs'    : 'yr') : null;
        $pieces[] = $di->m ? sprintf('%d %s', $di->m, $di->d > 1 ? 'months' : 'month') : null;
        $pieces[] = $di->d ? sprintf('%d %s', $di->d, $di->d > 1 ? 'days'   : 'day') : null;
        $pieces[] = $di->h ? sprintf('%d %s', $di->h, $di->h > 1 ? 'hrs'    : 'hr') : null;
        $pieces[] = $di->i ? sprintf('%d %s', $di->i, $di->i > 1 ? 'mins'   : 'min') : null;
        $pieces[] = $di->s ? sprintf('%d %s', $di->s, $di->s > 1 ? 'secs'   : 'sec') : null;

        // No null.
        $pieces = array_filter($pieces);

        // Add "and" before the last segment "3 hrs and 15 mins".
        if (count($pieces) > 1) {
            $pieces[count($pieces) - 1] = '& ' . $pieces[count($pieces) - 1];
        }
        return implode(' ', $pieces);
    }
}