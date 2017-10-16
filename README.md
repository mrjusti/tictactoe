# Tic Tac Toe

## The rules of the tic tac toe game are the following:
* a game is over when all fields are taken
* a game is over when all fields in a row are taken by a player
* a game is over when all fields in a column are taken by a player
* a game is over when all fields in a diagonal are taken by a player
* a player can take a field if not already taken
* players take turns taking fields until the game is over
* there are two player in the game (X and O)

## Server Requirements
* PHP >= 7.0.0

## Configuration

### Instalation
`composer install`

### Public Directory

You should configure your web server's document / web root to be the  public directory. The index.php in this directory serves as the front controller for all HTTP requests entering your application.

### Configuration Files

All of the configuration files for the Laravel framework are stored in the config directory.

### Directory Permissions

After installing Laravel, you may need to configure some permissions. Directories within the `storage` and the `bootstrap/cache` directories should be writable by your web server or Laravel will not run.

### Application Key

The next thing you should do after installing Laravel is set your application key to a random string. This key has already been set for you by the `php artisan key:generate` command.

Typically, this string should be 32 characters long. The key can be set in the `.env` environment file. If you have not renamed the `.env.example` file to .env, you should do that now. **If the application key is not set, your user sessions and other encrypted data will not be secure!**
