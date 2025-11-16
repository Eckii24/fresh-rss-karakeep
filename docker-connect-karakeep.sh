#!/usr/bin/env bash
# Simple idempotent script to connect karakeep-web-1 and freshrss to a shared network.
# Usage: ./connect-karakeep-freshrss.sh [karakeep-container] [freshrss-container] [network-name]
# Defaults: karakeep-web-1 freshrss shared_net

set -euo pipefail

CONTAINER_A="${1:-karakeep-web-1}"
CONTAINER_B="${2:-freshrss}"
NETWORK="${3:-shared_net}"

# create network if missing
if ! docker network ls --format '{{.Name}}' | grep -xq -- "$NETWORK"; then
  echo "Creating network: $NETWORK"
  docker network create "$NETWORK"
else
  echo "Network exists: $NETWORK"
fi

# connect container A if not already on the network
if ! docker inspect --format '{{json .NetworkSettings.Networks}}' "$CONTAINER_A" 2>/dev/null | grep -Fq "\"$NETWORK\""; then
  echo "Connecting $CONTAINER_A -> $NETWORK"
  docker network connect "$NETWORK" "$CONTAINER_A"
else
  echo "$CONTAINER_A already on $NETWORK"
fi

# connect container B if not already on the network
if ! docker inspect --format '{{json .NetworkSettings.Networks}}' "$CONTAINER_B" 2>/dev/null | grep -Fq "\"$NETWORK\""; then
  echo "Connecting $CONTAINER_B -> $NETWORK"
  docker network connect "$NETWORK" "$CONTAINER_B"
else
  echo "$CONTAINER_B already on $NETWORK"
fi

echo "Done."
