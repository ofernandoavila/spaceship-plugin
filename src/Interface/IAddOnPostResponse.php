<?php

namespace ofernandoavila\SpaceshipPlugin\Interface;

interface IAddOnPostResponse {
    public function addToPostResponse($response, $post, $context): void;
}