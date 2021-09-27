# HighCohesion Development Kit
## Source-Destination PHP Functions

This project will help you to implement and test your functions.

### Configuration
First you need to configure the .env file with the following environment variables

```dotenv
IMAGE=php-8.0
XDEBUG_CLIENT_HOST=172.17.0.1
# XDEBUG_CLIENT_HOST=docker.for.mac.localhost
XDEBUG_CLIENT_PORT=9003
XDEBUG_IDE_KEY=PHPSTORM
HIGHCOHESION_API_KEY=xxxxyyyyxxxx
```


### Installation
For building this project, you will need to have Docker and Docker Compose installed in your local machine.
Visit this [link](https://docs.docker.com/engine/install/) to find more information about the Docker installation process.

The run the following command to start the project.
```shell
make build
make start
```


### Functions

#### Source
