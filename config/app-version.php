<?php

return [
    'sentry' => [
        /*
         * The sentry auth token used to authenticate with Sentry Api
         * Create tokens here at account level https://sentry.io/settings/account/api/auth-tokens/
         * Or here at organization level https://sentry.io/settings/your-organization/developer-settings/
         */
        'auth_token' => env('APP_VERSION_SENTRY_AUTH'),

        /*
         * The organization name this project belongs to, you can find out the
         * organization at https://sentry.io/settings/
         */
        'organization' => env('APP_VERSION_SENTRY_ORGANIZATION', 'placetopay'),

        /*
         * The repository name of this project. Repositories are added in sentry as integrations.
         * You must add your (Github|Bitbucket) integration at https://sentry.io/settings/your-organization/integrations/
         * and then add the repositories you want to track commits
         */
        'repository' => env('APP_VERSION_SENTRY_REPOSITORY'),

        /*
         * The name of this project in Sentry Dashboard
         * You can find out the project name at https://sentry.io/settings/your-organization/projects/
         */
        'project' => env('APP_VERSION_SENTRY_PROJECT'),
    ],

    'newrelic' => [
        /*
         * The NewRelic Rest API Key, you can found it on the following URL when you are logged in
         * https://rpm.newrelic.com/api/explore/application_deployments/create
         */
        'api_key' => env('APP_VERSION_NEWRELIC_API_KEY'),

        /*
         * The NewRelic application id, you can get it from the URL in the APM
         */
        'application_id' => env('APP_VERSION_NEWRELIC_APPLICATION_ID'),
    ],

    /*
     * The current deployed version, will be read from version file
     * generated by `php artisan app-version:create ...` command
     */
    'version' => \PlacetoPay\AppVersion\VersionFile::read(),

    /**
     * Credentials by get /version.
     */
    'username' => env('APP_VERSION_USERNAME', 'admin'),
    'password' => env('APP_VERSION_PASSWORD', 'password'),
];
