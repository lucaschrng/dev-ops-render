#[!bin/bash]
cd ~/www/sf5-p5 && export $(grep -v '^#' .env.local | xargs) && docker-compose down --remove-orphans
