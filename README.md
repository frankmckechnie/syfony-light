# Docker/symfony test #

Docker compose allows you to bundle you docker files and run them as a group rather than alone.

Running `docker-composer up` will build all containers, down will destory all containers.

```
    docker-composer up
    docker-composer down 
```

When you have a new DockerFile and you want to build that file to create an image you have run docker build.

``` docker build --tag image-name . ```

Will build a docker file, doing so will execute all the commands and create a image of the build file.

To run the images to make a container as a background process ``-d``

``` docker run -p 8080:80 --name container-name -d image-name ```

## To stop start conatiners ##

```
    docker start conatiner-name
    docker stop container-name
```

## To remove container ##

``` docker rm conatiner-name ```

## View commands ##

### View images(built docker files) ###

``` docker iamges ```

### View running/stopped containers ###

``` docker ps -a ```

### View logs of a conatiner ###

``` docker logs container-name ```

## Run commands on containers ##

To ssh in to a container, you can run the ``exec`` command, this command allows you to execute programs on yout container. By adding bach and ``-it` you can state the container tag and to to mark the operation as interactive. Add bash at the end and it would be like ssh'ing into a server.

``` docker exec -it container-name bash ```

If using docker-compose you can ssh or run commands aswell.

``` 
    docker-composer run --rm service-name php bin\console doctrine:database:create
    docker exec -it container-name bash
```