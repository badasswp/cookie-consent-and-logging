#!/bin/bash

wp-env run cli wp theme activate twentytwentythree
wp-env run cli wp rewrite structure /%postname%
wp-env run cli wp option update blogname "Cookie Consent And Logging"
wp-env run cli wp option update blogdescription "Manage Cookie consent & logging on your WP website."
