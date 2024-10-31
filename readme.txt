=== Pushie ===
Contributors: Neil 'WolfieZero' Sweeney
Tags: boxcar, push notifications, iphone, instant, comments, pingbacks
Requires at least: 3.0.1
Tested up to: 3.1
Stable tag: 0.3.1
License: GPLv3
Donate link: http://wolfiezero.com/wordpress/donate/

Push notifcations to your device on certain events

== Description ==

Pushie allows you to send push notifications from your self-hosted WordPress blog to your 
device.

All you need at the moment is Boxcar installed on your device (only iOS at the moment), 
setup an account then create a provider. With that API information, you can then get push 
notifications sent to your device whenever you have a connection to the internet.

Features
* Instant push notifications to Boxcar
* Notification on new comments
* Notification on new pingbacks

Requirements
* Your WordPress installation needs cURL support

== Installation ==

To use Pushie, you currently require [Boxcar](http://boxcar.io/)

1.	Download Boxcar for your device ([iOS](http://itunes.apple.com/gb/app/boxcar/id321493542?mt=8))
2.	[Sign up to Boxcar](http://boxcar.io/sign-up) (if you have not already)
3.	[Create a provider](http://boxcar.io/site/providers/new) for your site
4.	Keep the API key and API secret safe (do not give this out to people you do not trust)
5.	Install Pushie on your self-hosted WordPress blog
6.	On the setup screen, under Boxcar, enter the API info from step 4 into the respective boxes
7.	Enter your email address you used to register Boxcar with
8.	Check what you want notifications on
9.	Wait for the comments!


== Screenshots ==

* Setup screen - http://wolfiezero.com/wp-content/uploads/2011/03/Pushie-Settings-v0.3b.png
* Boxcar push notification on iPhone - http://wolfiezero.com/wp-content/uploads/2011/03/20110307-105808.jpg


== Donate ==

If you wish like this plugin, use it for a site that makes you a profit or are a commercial user then please donate. See http://wolfiezero.com/wordpress/donate/ for more info

== Changelog ==

= 0.3.1 =

* Added check in settings page to see if WordPress supports cURL
* Removed beta tag

= 0.3 =

* First available public release.