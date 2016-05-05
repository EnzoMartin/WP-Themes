WordPress Themes
=========

All the themes for the WordPress sites can be found here

## How to use

### First time setup
* Clone this repo to a folder on your computer
* Install [WordPress](http://wordpress.org/download/) in the folder you just created
* Install [NodeJS](http://nodejs.org/)
* In Command Prompt, run `npm install grunt-cli -g`
* In Command Prompt, run `npm install bower -g`

### Editing a theme for the first time
* Open a Command Prompt window in the theme folder you wish to edit (ex: `\wp-content\themes\hypernia`) (`SHIFT + Click` inside the folder as a shortcut)
* Run `npm install`
* Run `grunt packages`

***NOTE:* This must be done for every theme you edit for the first time, so if you did this for the `Hypernia` theme, and now want to edit the `PurePings` theme, you must do the same steps in the `PurePings` theme directory as well.**

## General
If you've already done the setup steps above, all you have to do is open a Command Prompt window from the theme folder you're wishing to edit, and run `grunt --force`. **Always make sure to pull the latest changes from the repo before doing changes to the code, you can do so from the GitHub Client.**
 
Once the above steps have been completed, you can start editing the templates. The CSS is compiled from the `assets\scss` folder, it's using [SASS](http://sass-lang.com/guide) which is essentially CSS on crack.

The themes are based off of [Roots.io](http://roots.io/starter-theme/)
