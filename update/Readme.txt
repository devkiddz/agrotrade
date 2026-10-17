TO UPDATE YOUR SCRIPT

NOTE: 
- Any changes (customization) you have made to your webiste files will be lost when you update.
- make sure to let your users know that you are performing an update.
-> Always create a backup incase something goes wrong so you can restore back your old files.
- make sure your server meets minimum requirements to run the scirpt. check PHP VERSION.
- Please ENSURE YOU DEACTIVATE YOUR OLD LICENSE first before performing the update. You will need to contact us if you fail to do so before updating.
- After successful update, you can re-activate your script.



WHAT TO DO 

-> Firstly import the Database(version5DB.sql and version5_0_3) file in this folder to your existing database. It will insert the neccessary columns and tables to run this new update.
-> Remove the old files from where it is installed (sub-domain, sub-folder, public_html, etc..)
-> moved them to a backup folder(usually called 'backup')
-> import the new script files you downloaded from codeanyon and extract it in the location you want. (usually where the prvious files was).
-> Enter the database credentials in the .env file (look up the values in the old .env file from the backup folder.)

-> test your webiste in the browser and see if it is working.
-> If it is working you will get your website back.
-> procced to activate your website again.


NOTE:
some images maybe lost due to this update.

please re-upload them(
    logo, favicon, ...website images
)

That is all.

Contact us on support@brynamics.com if you have trouble updating or if you run into any problem, we will be happy to help.