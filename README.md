## Dependencies
- Wordpress 6.1+
- PHP 7.4+/8.0, MySQL 5.7+
- `mysql` global accessible
- `Nodejs` - tested on 18.12.1
- `yarn`
- `gulp` - global (v4)
- `composer` - global

## Project root .env Configuration
Create and configure .env file, based on .env.example
## Environment Setup
To run the environment, open a console in a project and type

`yarn start`

or

`yarn install` & `composer install` & `gulp install`

If you run into problems with the global gulp version, you can always fire up gulp commands via yarn

`yarn gulp install`

## Build Project
`gulp build` - build CSS sources & JS

`gulp` - build & run watch

## Build File Pack

`yarn files` (theme, plugins, uploads, db)

or

`yarn files-full` (full enviroment)

## Database
Database is stored in the `/db/` folder

Import - `gulp db:import`

Export - `gulp db:export`

Custom db file name with attr - `--file=data`
## Manual install DB on server
Replace all occurrences: (IMPORTANT - WITHOUT `/` on the end of link)

`${WP_HOME}/wp` => http://domain.com

`<-- HOST_URL -->` => http://domain.com