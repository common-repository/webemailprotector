=== Email Address Security by WebEmailProtector === 
Contributors: dsrodzin
Donate link: https://www.webemailprotector.com/cgi-bin/registerform.py?cms=wp
Tags: spam, email, address, encrypt, security, obfuscate
Requires at least: 3.0.1
Tested up to: 6.0.2
Requires PHP: 5.3
Stable tag: 3.3.6
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

An easy to use yet powerful security Plugin that stops email addresses from being harvested from your website.

== Description ==

Welcome to WebEmailProtector's Email Address Security plugin for WordPress. 

Using the WebEmailProtector service you can safely put Email Addresses on your website with confidence that they will be truly hidden from being scraped and harvested because they are no longer actually on your web site itself. 

Instead they are replaced by an IES encrypted Email Security Key..

Just <bold>Register</bold> the Emails you want to use, <bold>Validate</bold> that everything is set up and then place the email in <bold>Square Brackets</bold> [youremail@yourdomain.com] anywhere on you site and the Plugin will do the rest.

= What does it do? =

Instead of simple Javascript client side "encoders", that just obfuscate and inevitably include the email decoding fomula for the browser and so are inherently unsecure, ours is "server side" on a secure cloud based server with an encrypted Email Security Key - akin to public key encryption.

And in response to comments - we do not store the emails themselves just an encryption key to the email address - there is quite a difference.

WebEmailProtector detects who and what is trying to access the Key on your site at the time of clicking, and then deploys algorithms to validate whether this request is being made by a credible, bona-fide visitor. 

The algoriths check multiple points about the request using our robust, proven Artifical Intelligence (AI) derived method.

After running the validation process, the email address is only returned from the Key if certain criteria are met and others not broken.

This method stops attacks and ID theft perpetrators at source, and keeps your address private. Simple to use and fully supported.

= Check Out Your Site =

As a start why not check how secure your existing pages are using our email finder tool at <https://www.webemailprotector.com/sitescan.html>?

Note this simple tester will not attempt JavaScript encoders due to security risks.

= More Information =

Please see more at <https://www.webemailprotector.com/index.html> and our Quetions & Answers at <https://www.webemailprotector.com/help.html>

= Pricing =

* This plugin is provided to more conveniently manage the WebEmailProtector service on your WordPress pages.
* Access to the associated WebEmailProtector service itself is offered FREE for a trial period of 1 month, and no payment details are required.
* Visit <https://www.webemailprotector.com/cgi-bin/subscriptionform.py> for more details regarding definitions and subscription pricing options.
 
= How do you use it? =

After installing the plugin, register your addresses at <https://www.webemailprotector.com/cgi-bin/registerform.py?cms=wp> and just follow the remaining instructions on the 
WebEmailProtector settings menu of WordPress.

= Compatibility =
* HTML4/5 compliant is compatible with all known browsers/devices including:
* Browsers: Internet Explorer, Safari, Google Chrome, Mozilla Firefox & Opera
* Platform: Windows, Linux, Apple iOS & Android
* Devices: PC, Tablets & Phones including: Blackberry, Apple iPad iPhone

== Installation ==

1. Go to Plugins in the Admin menu
2. Click on the button 'Add New'
3. Search for WebEmailProtector and click 'Install Now' or click on the upload link to upload webemailprotector.zip
4. Click on Activate plugin
5. Click on the Settings->WebEmailProtector menu 
6. Follow the instructions on the settings page to enter the "secured email addresses" and "display text"
7. Register each email address at <https://www.webemailprotector.com/cgi-bin/registerform.py?cms=wp>
8. Validate each email addresses on the settings menu
9. To use the protected email address(es) anywhere on your site either write them on a page using square brackets e.g. [youremail@yourdomain.com] 
or within WordPress Link elements e.g. mailto:youremail@yourdomains.com

== Frequently Asked Questions ==

= What is it? =
Email address harvesters operate by using software "scrapers" or "click through" staff to steal email addresses directly from web-site pages.
Using our service prevents this as your email addresses no longer need to be listed directly on your web-site. Instead 
they are hidden away from your site. We then only release the address after 
we are sure it is not being accessed improperly. Because of this it becomes invisible to harvesters and machines and yet is completely 
visible to bona fide users.  

= How does a WebEmailProtector secured email address appear? =
The secured email address appears on a site like this: " &#60;a href='JavaScript:emo(<yourkey>);' &#62;Any Text &#60;/a &#62;"
(you can change what it says and how it looks)
whereas a non protected email address usually appears like this:" &#60;a href='mailto:nobody@webemailprotector.com' &#62;nobody@webemailprotector.com &#60;/a &#62;". 
Both operate when you "click", but only the former is safe.

= Why is it better than a Contact Form? =
Contact Forms are effective in dealing with both human and machine based harvesting, unless you ever want to use email auto responders of course 
as this gives your identity away.
However the real problem is that all the form filling can annoy and therefore dissuade real users from getting in touch - effectively putting a 
barrier between you and your users in your most important communications channel - email

= Why is it better than Captcha codes? =
Captcha codes are effective in dealing with machines but not with users who simply click to reveal your address.
And the other main issue is that they are very very annoying to real users and can heavily dissuade communications with you - so are effectively 
putting a barrier between you and your wanted users.

= Why is it better than 'free' address encoder? =
Although at first they may appear effective as your 'mailto:' text is no longer obvious to the eye within your HTML code. Encoders and encrypters, 
'free' or otherwise, have to be built so that they can be interpreted by any web-browser using standard HTML. And this is the nature of there 
drawback. 
They are more or less complex but involve a Java/JavaScript sequence munger or character set coder. But to cut a long story short if your browser 
understands them so can any harvesting software. 
So it's actually quite simple for encoded email addresses to be interpreted and harvested using standard software libraries and methods.

= How is the email protected? =
We provide protection as the email address is never listed or disclosed on your website. Instead WebEmailProtector detects who and what is trying to access 
the email link on your site at the time of "clicking", and then deploys algorithms to validate whether this request is being made by a credible, bona-fide visitor. 
The algoriths check multiple points about the request using our robust, proven Artifical Intelligence (AI) derived method.
After running the validation process, the email address is only returned if certain criteria are met and others not broken. 

= What do you get for the FREE trial? =
You get the full service free for 1 month, with exactly the same protection as offered with a paid up subscription. 
There is no obligation to purchase, but at the end of the trial we are confident that you will see a reduction in volume of new email 
spam originating from your web site. At the end of the trial we would also ask you to complete a 10 question survey on how you found 
installing and using it.
Please note that as its a trial you only get it once per email/website for you to try unless otherwise agreed with us.

= How do you subscribe following the trial? =
Once your trial is coming to an end we will send you an email detailing what you have to do to continue the services. You need do nothing if you are 
a non commercial site. All payments can be made on-line using PayPal. the more people that use it the more we can keep prices down. More details at 
<https://www.webemailprotector.com/cgi-bin/subscriptionform.py>.

= How can you check if you are protected? =
Once installed, click on your Email and your installed email tool should open as normal. If you really want to check your email is no longer 
listed view your web site in text mode (e.g. pressing the F12 key in your Internet Explorer/Google Chrome/Firefox web browser) and search for 
your email address or the mailto: reference. It should no longer be there. And finally check out your site using our email finder tool at <https://www.webemailprotector.com/website-email-security-check.html>.

== Screenshots ==

1. This is a screenshot of the WebEmailProtector WordPress plugin administration panel once installed. Note the secured email address appears in RED until the email is verified, when it turns GREEN. 
2. This is a screenshot of example html text code showing what a standard or unprotected linked email address looks like on a web page, hence why it is easy to "scrape".
3. This is a screenshot of example html text code showing what a webemailprotector linked email address looks like on a web page (the real code has been replaced with ####-####-####-####), can no longer be scraped.
4. This is a screenshot showing how both the above would appear to a webpage visitor.

== Changelog ==

= 3.3.5 =
* 21st July 2021
* Tested for WP 5.8
* Removed dependency on ctype_digit -> wep_ctype_digit (as some sites had auto disabled)
* Removed dependency on ctype_alnum -> wep_ctype_alnum (as some sites had auto disabled)
* Updated Styling

= 3.3.4 =
* 21st Mar 2021
* Tested for WP 5.7

= 3.3.3 =
* 3rd Feb 2021
* Tested for WP 5.6
* Verification and Testing including upto PHP7.4

= 3.3.2 =
* 6th Nov 2020
* Tested for WP 5.5.3
* Minor bug fixes for Verification

= 3.3.1 =
* 8th Sept 2020
* Tested for WP 5.5.1
* Minor bug fixes for Verification

= 3.3.0 =
* 13th July 2020
* Reverted back to standard 1.5x JQuery with JavaScript as v3.2.0 with JQuery 3.x broke the functionaility on some sites

= 3.2.0 =
* 9th July 2020
* WP Uses such an old insecure JQ (v 1.5x) that the latest Plugin Release had call issues, breaking some users
* Updated the header function to add the latest JS 3.5.1 from CDN 

= 3.1.0 =
* 8th July 2020
* Major Update to everything
* New Security Mechanisms
* New Forms
* New Branding
* New Server Side Database Structure

= 3.0.0 =
* 17th Jun 2020
* Upgraded and check to WP v5.4.2
* Started to migrate to New Branding

= 2.4.0 =
* 12th July 2019
* Upgraded and check to WP v5.0.3
* New Images Added

= 2.3.4 =
* 9th Jan 2019
* Upgraded and check to WP v5.0.3
* New Images Added

= 2.3.3 =
* 29th Nov 2018
* Upgraded and checedk to WP v5.0.2

= 2.3.2 =
* 14th Aug 2018
* Upgraded and checked to WP v4.9.8

= 2.3.2 =
* 14th Aug 2018
* Upgraded and checked to WP v4.9.8

= 2.3.1 =
* 29th Jan 2018
* Improved site URL detection logic to prevent false assumptions
* Upgraded and checked to WP v4.9.2

= 2.3.0 =
* 14th Dec 2017
* Corrected bug with validation over HTTPS

= 2.2.1 =
* 13th Dec 2017
* Upgraded and checked to WP v4.9.1

= 2.2.0 =
* 15th Aug 2017
* Upgraded to WP v4.8.1

= 2.1.1 =
* 3rd April 2017
* Minor update as stable tag was wrong

= 2.1.0 =
* 31st March 2017
* Upgraded to WP v4.7.3
* corrected issue of email getting invalidated on copy and paste in email box

= 2.0.0 =
* 25th Feb 2017
* Upgraded to WP v4.7.2
* new add_filter method to run on whole post processed content
* Implmented css icon to WEP email calls

= 1.6.1 = 
* 17th Jan 2017
* Upgraded to WP v4.7.1
* Remove and _target and subject style field for email calls 
* Added icon to WEP email calls

= 1.5.2 = 
* 19th Oct 2016
* Apply morphing add_filter on whole site <body>

= 1.5.1 = 
* 26th Sept 2016
* Upgraded to WP v4.6.1

= 1.5.0 = 
* 6th June 2016
* Upgraded to WP v4.5.2
* Added https SSL/TCN support for secure sites

= 1.4.5 =
* 28th April 2016
* Upgraded to WP v4.5.1
* Updated registration links making FREE resgitration an option

= 1.4.4 =
* 22nd February 2016
* Upgraded to WP v4.4.2

= 1.4.3 =
* 27th September 2015
* Upgraded to WP v4.3.1

= 1.4.2 =
* 16th June 2015
* Moved headerscript to enque in footer to speed up

= 1.4.1 =
* 17th May 2015 
* Upgraded to WP v4.2.2
* Added REGISTER as a link

= 1.4.0 =
* 9th April 2015
* Added register button to admin table to directly access addresses
* Improved top section layout
* Made on hover class for buttons

= 1.3.0 =
* 17th March 2015
* Added new title for plugin to improve searchability
* Slightly reworded pricing to make clearer

= 1.2.1 =
* 19th Feb 2015
* Changed install use text to add link replacement instructions
* Removed validation bug when adding new email

= 1.2.0 =
* 17th Jan 2015
* Upgraded to work with WP theme TwentyFifteen and the like that do not pass shortcodes from Social Menu
* Corrected various text and added updated logo on Settings Menu

= 1.1.6 =
* 6th Jan 2015
* Upgraded to be compatible with WPv4.1
* Added email response confirmation of version activation & verification

= 1.1.5 =
* 5th Dec 2014
* Updated assets images

= 1.1.4 =
* 2nd August 2014
* Added more info on free for Not For Profits
* Added http search tool link

= 1.1.3 =
* 21st June 2014
* Sorted header issue due to lingering old release in CSV

= 1.1.2 =
* 13th June 2014
* Improved description text in the main .php

= 1.1.1 =
* 6th June 2014
* Improved installation instructions

= 1.1.0 =
* 28th May 2014
* Updated validation text to make it easier to understand
* Updated validation process to change validation state and remove old code if fails
* Updated add_filter(content) command to only change content text to call if valid
* Updated add_filter(content) to fix issue with unchanged pages not being written out
* Added add_filter(widget) to also replace text in widgets - special forms, headers, themes etc

= 1.0.1 =
* 9th May 2014
* Updated description text 

= 1.0 =
* 6th May 2014
* First release onto WordPress sites 

== Upgrade Notice ==

= 3.3.6 =
* 14th Sept 2022
* Tested for WP 6.0
* Corrected settings link

