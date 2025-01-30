
**[Back to Index](index.md)**

---

# Docker container

## Prepare SSL certificates

The Apache webserver inside the docker container requires  `*.pem` development certificates for its SSL engine. Create those and store them in **resources/docker/ssl/** directory.

> A good tool for creating locally trusted development certificates is Filippo Valsorda's **[mkcert](https://github.com/FiloSottile/mkcert)**. It is available for MacOS, Linux, and Windows; follow the docs over on GitHub on how to [install mkcert](https://github.com/FiloSottile/mkcert#installation).

```bash
$ cd resources/docker/ssl
$ mkcert \
-key-file localhost-key.pem \
-cert-file localhost.pem \
localhost 127.0.0.1 ::1
```

## Running Docker

You can use [`docker-compose.yml`](./docker-compose.yml) to serve on [**https://localhost/**](https://localhost/). Make sure you installed some locally trusted SSL certificates / PEM keys as described above. To turn on Docker machine:

```bash
$ docker compose up
# and somewhere else:
$ docker compose down
```
