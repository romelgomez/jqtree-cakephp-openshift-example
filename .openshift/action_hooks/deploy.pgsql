#!/bin/bash
# this file is sourced from the deploy hook script

set -e

# Confirm database exists, if not create it
if ! psql -c "select * from posts;" "$OPENSHIFT_APP_NAME" > /dev/null 2>&1
then
    echo
    echo "Database schema not found, importing 'cake.pgsql.sql' schema."
    echo
    psql -a -f "$OPENSHIFT_REPO_DIR/.openshift/action_hooks/cake.pgsql.sql" "$OPENSHIFT_APP_NAME"
    echo
    echo "done."
else
    echo "Database found, skipping import."
fi
