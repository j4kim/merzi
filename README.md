# merzi

ics based freetime seeker for cff employees.

## Set up

### Install dependencies

    composer install

    npm install

### Create config file

    cp config.example.json config.json

### Generate password

    php -r 'echo password_hash("password", PASSWORD_DEFAULT) . "\n";'

Copy result to "passphrase" in `config.json`.

### Serve locally

    composer serve

Open http://localhost:1234/

### Generate css for production

    npm run build
