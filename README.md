# Install a wide network for all your containers
```
docker network create ${yourNetworkName}

```
# Launch the traefik container
Create a folder for the traefik project and into this folder, create a docker-compose.yml file with the content below

```
version: '3.9'

networks:
  ${yourNetworkName}:
    external: true

services:
  traefik:
    image: traefik
    command:
      - "--log.level=DEBUG"
      - "--api.insecure=true"
      - "--providers.docker=true"
      - "--providers.docker.exposedbydefault=false"
      - "--entrypoints.${yourNetworkName}.address=:80"
    restart: always
    ports:
      - "80:80"
      - "8080:8080" # The Web UI (enabled by --api)
    networks:
      - ${yourNetworkName}
    volumes:
      - /var/run/docker.sock:/var/run/docker.sock
```

This allow you to launch the traefik service which will perform the reverse proxy for yours others services/containers

# Reconfigure your existing services
In all your existing containers/services, remove port exposition. Instead, define a router which will redirect a HTTP(S) trafic targeting a specific domain to the specific port of your container. To perform that config, add the section below under your services definition in your docker-compose.yml files
```
version: "3.9"
services:
    ${yourService}
        ...
        labels:
            # This is enableing treafik to proxy this service
            - "traefik.enable=true"
            # Here we have to define the URL
            - "traefik.http.routers.${yourService}.rule=Host(`${yourDomain}`)"
            # Define the router identity
            - "traefik.http.routers.${yourRouterName}.service=${targetedServiceName}"
            # Here we are defining wich entrypoint should be used by clients to access this service
            - "traefik.http.routers.${yourRouterName}.entrypoints=intranet"
            # Here we define in wich network treafik can find this service
            - "traefik.docker.network=${yourNetworkName}"
            # This is the port that traefik should proxy
            - "traefik.http.services.${yourRouterName}.loadbalancer.server.port=${containerPort}"
```
