# Requirements
1. PHP 7.3
2. MariaDB
3. OS (Linux, Mac, Windows)

Development dapat menggunakan XAMPP yang didownload pada laman berikut ini :
https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/7.3.33/

# Editor
Bisa menggunakan atom, sublime, maupun notepad++

# Cara Instalasi

Langkah melakukan instalasi :
1. git clone <alamat repositori>
2. cd kepegawaian-rspon
3. php composer.phar install
4. php artisan migrate
5. php artisan db:seed
6. php artisan passport:install

Contoh cara instalasi di windows dengan xampp
1. git clone https://chaisir_ibnu@bitbucket.org/chaisir_ibnu/kepegawaian-rspon.git
2. cd kepegawaian-rspon
3. D:/xampp/php/php.exe composer.phar install
4. D:/xampp/php/php.exe artisan migrate
5. D:/xampp/php/php.exe artisan db:seed
6. D:/xampp/php/php.exe artisan passport:install
