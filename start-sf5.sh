#[!bin/bash]
#docker network create --driver bridge ter_networks  --subnet=172.21.0.0/16  --gateway=172.21.0.1 || true
cd ~/www/sf5-p3 && docker-compose up -d --build --force-recreate
