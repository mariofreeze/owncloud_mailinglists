# OwnCloud App Mailing List Manager
OwnCloud App to manage mailing lists.
In the first step this app is implemented for ezmlm mailing lists.

Features
========
1. Subscribe/Unsubscribe
------------------------
The app shows all users all lists and their subscribers as well as their additionally allowed senders. This is because I didn't find a way to get the email address of the current user in OC 8.2. From 9.0 on this API function is available.
An OC user can subscribe anyone to a list by entering the email address. This will pop up a new email to the subscription address of the list. This way it is safe to allow this because a moderator needs to confirm this subscription.

2. Moderator Add/Remove
-----------------------
Also moderators can add/remove moderators of a list. Moderators need to be added to a configurable OC group on the admin page.
The add/remove of a moderator becomes effective immediately.

3. Configuration Features
-------------------------
The type of mailing list - currently only ezmlm. 
The user group which can access the security relevant features like add/remove moderators.

For ezmlm lists you can configure:
- the ezmlm home directory where each subdirectory contains a separate mailing list
- the domain used for sub/unsubscribe emails

Prerequisites
=============
The own cloud installation must be on the same server as the ezmlm installation.
The PATH must contain ezmlm-sub and ezmlm-unsub for the moderation features to work.

Possible Features
=================
- Configurable if all users can see all lists/subscribers for OC 9.0
- Create new Lists
- Show the archive mails for ezmlm-idx lists
- Pending moderations
- mailman and other mailing list managers
