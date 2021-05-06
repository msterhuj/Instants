<?php

namespace App;

class Config {
    const DB_HOST = "mariadb";
    const DB_NAME = "instants";
    const DB_USER = "root";
    const DB_PASS = "root";

    const MAIL_HOSTNAME = "instants.dev";
    const MAIL_SRV = "mail.instants.dev";
    const MAIL_PORT = 587;
    const MAIL_USER = "noreply@instants.dev";
    const MAIL_PASS = "";
    const MAIL_TIMEOUT = 30;

    const REDIS_HOST = "redis";
    const REDIS_PORT = 6379;
}