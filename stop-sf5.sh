#[!bin/bash]
export $(grep -v '^#' .env.local | xargs) && docker-compose down --remove-orphans
