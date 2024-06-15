<?php

$routes = [
    "api" => [
        "me" => [
            "url" => "/api/me",
            "method" => "GET",
            "description" => "Get the current authenticated user",
            "arguments" => "n/a",
        ],
        "post_create" => [
            "url" => "/api/post/create",
            "method" => "POST",
            "description" => "Create a new post",
            "arguments" => "content, channel_id[optional], category[optional]",
        ],
        "post_media_upload" => [
            "url" => "/api/post/upload",
            "method" => "POST",
            "description" => "Upload media to post",
            "arguments" => "id, media file [`media`]",
        ],
        "post" => [
            "url" => "/api/post",
            "method" => "GET",
            "description" => "Get a specific post",
            "arguments" => "id",
        ],
        "posts" => [
            "url" => "/api/posts",
            "method" => "GET",
            "description" => "Retrieve the list of posts",
            "arguments" => "n/a",
        ],
        "login" => [
            "url" => "/api/login",
            "method" => "POST",
            "description" => "User login",
            "arguments" => "email, password",
        ],
        "logout" => [
            "url" => "/api/logout",
            "method" => "POST",
            "description" => "User logout",
            "arguments" => "n/a",
        ],
        "user" => [
            "url" => "/api/user",
            "method" => "GET",
            "description" => "Get user details",
            "arguments" => "username",
        ],
        "users" => [
            "url" => "/api/users",
            "method" => "GET",
            "description" => "Get a list of users",
            "arguments" => "n/a",
        ],
        "signup" => [
            "url" => "/api/signup",
            "method" => "POST",
            "description" => "User sign up",
            "arguments" => "username, email, password",
        ],
        "upload_avatar" => [
            "url" => "/api/upload/avatar",
            "method" => "POST",
            "description" => "Upload user avatar",
            "arguments" => "avatar file [`avatar`]",
        ],
        "upload_banner" => [
            "url" => "/api/upload/banner",
            "method" => "POST",
            "description" => "Upload user banner",
            "arguments" => "banner file [`banner`]",
        ],
        "user_channels" => [
            "url" => "/api/channel/mine",
            "method" => "GET",
            "description" => "Get a list of channels belongs to the user",
            "arguments" => "n/a",
        ],
        "create_channel" => [
            "url" => "/api/channel/create",
            "method" => "POST",
            "description" => "Create a new channel",
            "arguments" => "channel_name, channel_username",
        ]
    ],
];
