# Table of contents

1. [Meet Calamity](#meet-calamity)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Support](#support)

## Meet Calamity

Calamity is a web application framework, for making your life simple and easy. **Please note**, that it is still in
progress. Calamity is based on `PHP` and `MySQL` or `PostgreSQL` (it uses PDO). It is free to use for any project you
want.

## Installation

To install Calamity just download the source zip, extract, and it is ready to use. Please refer
to [configuration](#configuration) before using it. In `/sql/base.sql` you find the basic SQL commands you need to run.
There is a pre-configured account `Superadmin`.

> [!IMPORTANT]
> The email for the login is `admin@example.com` with the password of `Superadmin1*`

## Configuration

First run `composer install` to get the necessary files you need.

Under `/common/config/` you will find a `.env.example` file. Rename it to just `.env`, and fill the fields in it.
For the `_URL` paths include `http://` or `https://` otherwise your app could crash. For the pages root set the `/web`
folder under admin/public.

To use Google Captcha field, fill the `.env` file with the site key and secret key.

To use Google Authentication download the `client_secret.json` file from the Google Console and paste it to `/common/config/`

## Support

| Version | PHP  |      Release      |      Support       |
|:-------:|:----:|:-----------------:|:------------------:|
|  v1.0   | 8.2+ | 04th January 2024 |        :x:         |
|  v2.0   | 8.2+ |    01 May 2024    | :white_check_mark: |
|  v3.0   | 8.3+ |        TBA        |        TBA         |
