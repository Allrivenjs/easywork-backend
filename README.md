<p align="center"><a href="https://easywork-frontend.vercel.app/"  target="_blank"><img src="./public/assets/Frame%204.svg" width="530"></a></p>


Using backend EasyWork
---

1. Into line command
   > composer install 
2. check `.env` of the app (group **whatsapp**) 
   > php artisan migrate
   > php artisan passport:install
3. check routes of the app with next command
   > php artisan r:l
4. Local storage of the app:
   > php artisan storage:link
5. Record that you must configure the .env where the server is hosted to be able to access the images while being local. :D

<br>

6. **New, now running in console this command for execute previous commands**
   > php artisan start::system --help <- "Know all your options"


<br>

``Si quieres iniciar un servidor en tu red local solo inicia este comando``
`` php artisan serve --host="la ip de tu pc (ipconfig(windows), ifconfig(linux))" --port=8000``

<br>

### Your app is ready :D

<br>

##### made by PrimiparosCompany
<p align="center"><a href="#" target="_blank"><img src="./public/images/tux.png" width="130"></a></p>
