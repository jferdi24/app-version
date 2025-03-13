<?php

namespace PlacetoPay\AppVersion\Tests\Commands;

use PlacetoPay\AppVersion\Tests\Mocks\InteractsWithFakeClient;
use PlacetoPay\AppVersion\Tests\TestCase;

class CreateDeployCommandTest extends TestCase
{
    use InteractsWithFakeClient;

    /** @test */
    public function can_create_a_release_for_sentry()
    {
        $this->setSentryEnvironmentSetUp();

        $this->bindSentryFakeClient();
        $this->fakeClient->push('success_deploy');

        $this->artisan('app-version:create-deploy')->assertExitCode(0);

        $this->fakeClient->assertLastRequestHas('environment', 'testing');

        $this->assertStringContainsString('Authorization: Bearer', $this->fakeClient->lastRequest()['headers'][0]);
    }

    /** @test */
    public function can_create_a_release_for_newrelic()
    {
        $this->setNewRelicEnvironmentSetUp();

        $this->bindNewRelicFakeClient();
        $this->fakeClient->push('success_deploy');

        $this->artisan('app-version:create-deploy')->assertExitCode(0);

        $applicationId = config('app-version.newrelic.application_id');
        $this->fakeClient->assertFirstRequestHas('query',  <<<GRAPHQL
        {
            actor {
                entitySearch(query: "domainId=$applicationId") {
                    count
                    query
                    results {
                        entities {
                            entityType
                            name
                            guid
                        }
                    }
                }
            }
        }
        GRAPHQL);

        $this->fakeClient->assertLastRequestHas('query', <<<GRAPHQL
        mutation {
          changeTrackingCreateDeployment(
            deployment: {
              version: "asdfg2",
              entityGuid: "",
              changelog: "Not available right now"
              description: "Commit on testing",
              user: "Not available right now",
            }
          ) {
            deploymentId
            timestamp
          }
        }
        GRAPHQL);

        $this->assertEquals($this->fakeClient->lastRequest()['headers'][0], 'API-Key: ' . config('app-version.newrelic.api_key'));
    }
}
