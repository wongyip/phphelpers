# ICAL::class

## Purpose
To generate standardized ICAL format calendar.

## Current Stage
- Worked well with Outlook appointment feature.
- Worked well with Gmail's Google Calendar integration.

## Usage
- Extened this class and make use of the make() method to generate ICAL string.
- Save as whatever.ics for output.
- Set MIME as 'text/calendar; charset=utf-8; method=REQUEST' when adding attachment.
- Ending as '7-bit' when necessary.