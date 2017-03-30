# BilderDB ItsWasteD
## Todo
### Important:
* Display galleries + [nice looking](https://www.w3schools.com/bootstrap/bootstrap_images.asp)
* DB export
* Separate public and private area
* User can change account settings
### Optional:
* [Carousel](https://www.w3schools.com/bootstrap/bootstrap_carousel.asp "W3C")
* Add own CSS
* Use of [modals](https://www.w3schools.com/bootstrap/bootstrap_modal.asp)
## Summary
 Date  | Deed 
 :---: | ---
 **24.3.17** | Finished login + start page
 
## vHOSTS

```
<VirtualHost *:80>
    # DNS Name auf den der VHost hören soll
    DocumentRoot "C:/Users/vmadmin/Desktop/bbcmvc/public"
    ServerName roth.local    

    # Nochmals
    <Directory "C:/Users/vmadmin/Desktop/bbcmvc/public">
        Options Indexes FollowSymLinks Includes ExecCGI
        Options +Includes
        AllowOverride All 
        Require all granted
        DirectoryIndex index.php
        Options All
    </Directory>
</VirtualHost>
```