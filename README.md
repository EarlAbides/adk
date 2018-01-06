# Docker instructions
1. First get docker installed for your platform (see https://docs.docker.com/engine/installation/)
1. Run `docker build -t adk .` to build the container
1. Run `docker run -i -t -p "80:80"  adk`
1. Browse to http://localhost

## TBD
1. Container is based off of this repo: https://github.com/mattrayner/docker-lamp. There are instructions there to map folders into the container so that any environment can have persistent data.
1. This just initializes an empty database and runs without connecting to SQL
1. Instructions from above are available to install and set up a database with credentials (e.g. what you would put into .adk_db)