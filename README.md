# HighCohesion Development Kit
## Source-Destination PHP Functions

This project will help you to implement and test your functions.

### Configuration
First you need to configure the project `/.env` file with the following environment variables

```dotenv
IMAGE=php-8.0
XDEBUG_CLIENT_HOST=172.17.0.1
# XDEBUG_CLIENT_HOST=docker.for.mac.localhost
XDEBUG_CLIENT_PORT=9003
XDEBUG_IDE_KEY=PHPSTORM
```


### Installation
For building this project, you will need to have Docker and Docker Compose installed in your local machine.
Visit this [link](https://docs.docker.com/engine/install/) to find more information about the Docker installation process.

The run the following command to start the project.
```shell
make build
make start
```

You can access to it from
```
0.0.0.0:8081
```

## Functions
You can create two types of functions. **Sources** or **Destinations**.
- Source functions pull data from Source Systems and send it to HighCohesion. Every data that you send to HighCohesion will be attached to one job.
You can see the list of job in our Control Panel.
- Destination functions pull data from HighCohesion and send it to the destination system. You can specify an EventId or pass a custom json object.
### Function Creation
To create a new function, you need to run the following command.
`make create-package`
This command will generate the skeleton inside the **functions** folder.
The function structure will look like:

```angular2html
├── functions   
│   ├── Shopify                 # System Name
│       └── GetOrder            # Function Name
│           ├──Main.php         # Main class
│           ├──composer.json    # composer file
│           ├──Vendor           # vendor folder

```
_You can create a package manually, but you will need to modify the project composer file to include the repository.
You will need to include the following entry in the main composer.json file_
```        
"repositories": {
        "hicoh/shopify-get-product": {
            "type": "path",
            "url": "../functions/Shopify/GetProduct"
        }
    },
```

### Function Testing

For testing or implementing the function, you can use the project API to pass data from HighCohesion.
You can pass:
 - Key information
 - Stream Id
 - Payloads
 - Events. 
#### Check the [API doc](./documentation/api.yaml) to learn how to pass this information.
 
