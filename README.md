# *«No-links please!»* Anti-spam WordPress plugin

This astonishing-simple and really-effective anti-SPAM system just works. It definitively protects your WordPress site from SPAM without imposing annoying CAPTCHAs, configurations, third-party services, blockchains, artificial intelligence or unicorns. Oh, just avoid URLs in comments when not logged-in :^)

If your SPAM always contains links this could be your definitive solution.

## Why it works

You can't really stop SPAM-bots. Bots try to submit tons of links into your comments in the hope that search engines will index them. Fortunately WordPress already de-index them since years as default but unfortunately bots do their job anyway, shooting in the mass and hoping to find a way to spread their spam via web.

Here is the idea: applying a small "no links please!" netiquette you can pratically kill every SPAM-bot of this kind at their deep intentions, before even reaching your database.

Tl;dr If you do not write links you are a good human.

## Features

* The SPAM is just dropped before reaching your database
* It does not annoy the average user (have you said CAPTCHA?)
* It does not need maintainment (have you said public blacklist?)
* It counts how much spam the system has blocked (for your personal satisfaction)
* You can display this counter from your Dashboard or from the `[no_links_please_anti_spam_counter]` shortcode
* Very lightweight and KISS design (keep it simple and stupid)
* It has not crapware

## Known bugs

* None! Only features. asd

## Installation

As every WordPress plugin:

1. Download this repository as `.zip` file ([master.zip](https://github.com/valerio-bozzolan/wp-no-links-please-anti-spam/archive/master.zip))
2. Activate the plugin

## Customization

To customize the error message put this somewhere in the `functions.php` of your WordPress theme:

	add_filter( 'no_links_please_anti_spam_error', function () {
		return "<b>Error</b>: Sir, please try again removing all the links from your comment. Yes, your comment was just dropped. Apologies, but SPAM is a bad beast.";
	} );

To customize the netiquette message put this instead:

	add_filter( 'no_links_please_anti_spam_netiquette', function () {
		return "Sir, before submitting just remember to avoid links. Cheers!";
	} );

## Credits

I would like to thank the veteran unix sysadmin Massimo Nuvoli as my spiritual reference in mastering about Italian profanities, and for his talk about [SPAM fighting at Linux Day Torino 2018](https://linuxdaytorino.org/2018/#programma) as well.
