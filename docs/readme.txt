README FIRST
-----------------------


--------------------------------------------------------
Module            aChat v0.24              For xoops 2
--------------------------------------------------------
Tested with Xoops 2.5.6
--------------------------------------------------------

aChat : A chat module with AJAX.

--------------------------------------------------------

aChat is a chat module, created to be a tagboard, but it
can be used for a small chat.

It uses the AJAX technology to send and refresh messages
without reloading the page.

--------------------------------------------------------

It's a Beta version, please test it and feedback.

--------------------------------------------------------

Features:

For the visitor:

- BBCodes
- Color of the messages
- URL too large are truncated for a better display
( Not totally OK)
- The guests can choose the nickname
- Can view the messages in database
- Can view the messages in archive files (created with purge)
- 2 blocks :
   - one which displays the normal chat,
      with autorefresh and send form
   - one which displays the last messages,
      without autorefresh and without send form

For the admin:

- Switch On/Off the BBCodes
- Choice of the available colors for messages
- Ip are logged, and are visible beside the Post time
(cursor flying over the Nickname of the poster)
- Display of the number of messages on the database
- Purge feature to not overload the database :
   - By number of messages
   - By date
- Can create html archive file while purging
- Can choose the height display, and the number of messages
initially loaded (for main and block).
- Can choose the permissions by groups, to allow or not to
send messages
- Can clone the module with one click, to create severals rooms
- Can desable the choice of the nicknames for the anonymous

For translations, contact me (kiwiiii@gmail.com),
I'll put them on the file module.

--------------------------------------------------------

Known issues:
- aChat doesn't work with multiMenu : it needs a small hack explained in How_to_use_aChat_and_MultiMenu.txt
(it can be applied to other modules which use window.onload javascript function)

--------------------------------------------------------

License
This module is released under the GPL license. See LICENSE.txt for details.
Niluge_KiWi created the images in this package and holds the copyright.
Images may be used within this module, but any other use requires the permission of Niluge_KiWi.
Niluge_KiWi can be contacted at kiwiiii@gmail.com
