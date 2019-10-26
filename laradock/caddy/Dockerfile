FROM abiosoft/caddy:no-stats
ARG plugins="git,cors,realip,expires,cache,cloudflare"
CMD ["--conf", "/etc/caddy/Caddyfile", "--log", "stdout", "--agree=true"]

EXPOSE 80 443 2015