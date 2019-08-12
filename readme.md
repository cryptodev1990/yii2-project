# Yii 2 application boilerplate

### Main features
- **.env** configuration support with type casting
- **Docker** support with 'one click to start'
- **Twig** is a default renderer
- **Simple** project structure with a more clean view
- **Webpack 4** based on [Laravel mix](https://laravel-mix.com), just run ```npm run dev```
- **Code Generator** for controllers, models, etc (like Laravel artisan) (```php yii make``` for details)
- **Dependency injection** in controller actions, **helper** functions, **extended** components etc (like `ActiveCollection`)
- **RBAC** configuration ready to scale 
- **Deploy** project to the remote host with one command ```dep deploy``` (see [Deployer](https://github.com/deployphp/deployer) extension)

### Extensions installed
- Twig - [github](https://github.com/yiisoft/yii2-twig)
- DB Seeder - [github](https://github.com/tebazil/yii2-db-seeder)
- DotEnv - [github](https://github.com/vlucas/phpdotenv)
- Carbon - [github](https://github.com/briannesbitt/carbon)
- Stringy - [github](https://github.com/danielstjules/Stringy)
- Arrayzy - [github](https://github.com/bocharsky-bw/Arrayzy)
- Deployer - [github](https://github.com/deployphp/deployer) (requires `acl` on the server)
- Laravel mix - [website](https://laravel-mix.com)

### Installation
For install project environment follow the instructions below

##### Docker
Deploy with *docker.yml* by command `docker-compose up -f docker.yml` or you can create `Run configuration` with your IDE (ex. PhpStorm)

##### MAMP/LAMP etc
Set up Apache document root to the ```public``` or root application directory

##### Environment installation
- Install project dependencies by `composer install`
- Node.js dependencies `npm install`
- Change `.env` settings for database and necessary sections
- Start your server (Apache, Nginx, MySQL, Docker etc)
- Use app init command `php yii app/init` (reset - `php yii app/reset`) for apply migrations and seeders
- Check project available on `http://localhost/`

### Webpack usage
Project contains preconfigured webpack (see `webpack.mix.js`). You can use following commands:
- `npm run dev` to build application assets
- `npm run watch` to start file-watcher
- `npm run prod` to build application assets with optimization (images, styles, inline-svg etc)

### Deployment
This project contains 'Deployer' extension which provides simple functionality to automatic deploy Your application to the server. 
You only have to adjust the specific section in the `.env` file to start using it (for details about {{variables}} see Deployer docs). 
Variables description:
- **DEPLOY_REPOSITORY**: Git repository project URL
- **DEPLOY_HOST**: Remote host address to deploy
- **DEPLOY_APPLICATION_NAME**: Project directory name
- **DEPLOY_USER**: Remote connection user
- **DEPLOY_ROOT_PATH**: Base upload directory on the server, example: `~/www/{{hostname}}`
- **DEPLOY_PROJECT_PATH**: Base working directory for project (contains releases, symlinks, etc), example: `{{root_path}}/{{application}}`
- **DEPLOY_PUBLIC_PATH**: Public directory contains web-accessible files, example: `{{root_path}}/public_html` 

To deploy the last '**master**' commit of the project use following command: 

`dep deploy` (if installed globally) 
or 
`vendor/bin/dep deploy` (by Composer)

Also, for local deploy functions (like npm build, composer install etc) use:
 
`dep local` 
or
`vendor/bin/dep local`

### Modules
If you want to create a new application module, just simple run `php yii make/module Name` 
or `php yii make/api Name` if API-preconfigured module is necessary

### Tests
Project contains preconfigured tests directory with necessary modules loading. 
To start all suites use a command `vendor/bin/codecept run`. Also, you have to create another database with 
`_test` suffix and apply necessary migrations by executing `php yii_test migrate`

##### Create new tests
You might use following commands to create new tests quickly:

- Acceptance (web): `vendor/bin/codecept g:cest acceptance {TEST_NAME}`
- Unit (logic): `vendor/bin/codecept g:test unit {TEST_NAME}`
- Functional (http): `vendor/bin/codecept g:cest functional {TEST_NAME}`

### Useful commands


Command                              | Description
---                                  | ---
npm run dev                          | Builds an assets bundle
npm run prod                         | Builds an assets bundle in production mode (optimized)
vendor/bin/codecept build          | Builds necessary helper classes for the tests actors
vendor/bin/codecept run tests      | Starts tests for the whole app
supervisorctl stop all               | Stops all of the background workers 
supervisorctl start all              | Starts all of the background workers