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
 **30.3.17** | Add galleries, gallery edit screen, delete galleries, check gallery permission
 **30.3.17** | Show pictures, add pictures, rename pictures, check picture permission
 **30.3.17** | Added hidden builder (input type=hidden) with a name and value
 **30.3.17** | Added some pictures + galleries + users
 **30.3.17** | Added readByUserId($uid) in galleryrepository
 **30.3.17** | Added readByGalleryId() and updateNameById() and countByGalleryId in PicRepo
 **5.4.17** | TODO 
 
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