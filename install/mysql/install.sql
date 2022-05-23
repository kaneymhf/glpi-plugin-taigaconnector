CREATE TABLE IF NOT EXISTS `glpi_plugin_taigaconnector_eventtypes`
(
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`        CHAR(24)        NOT NULL,
    `description` VARCHAR(80)     NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

INSERT IGNORE INTO `glpi_plugin_taigaconnector_eventtypes` (`id`, `name`, `description`)
VALUES (1, 'TicketCreated', 'New Ticket Created'),
       (2, 'TicketSolved', 'Ticket Solved'),
       (3, 'TicketFollowupAdded', 'New Followup Created'),
       (4, 'TicketApprovalAdded', 'New Ticket Approval Created'),
       (5, 'TicketApprovalResolved', 'Ticket Approval Resolved');

CREATE TABLE IF NOT EXISTS `glpi_plugin_taigaconnector_subscriptions`
(
    `id`                    BIGINT UNSIGNED   NOT NULL AUTO_INCREMENT,
    `name`                  VARCHAR(80)       NOT NULL,
    `url`                   VARCHAR(255)      NOT NULL,
    `event_type_id`         BIGINT UNSIGNED   NOT NULL,
    `created_at`            TIMESTAMP         NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`            TIMESTAMP         NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `is_active`             TINYINT UNSIGNED  NOT NULL DEFAULT 1,
    `is_deleted`            TINYINT UNSIGNED  NOT NULL DEFAULT 0,
    `unsubscribed_at`       TIMESTAMP         NULL     DEFAULT NULL,
    `unsubscribed_because`  TINYINT UNSIGNED  NULL     DEFAULT NULL,
    `failures`              SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    `filtering_regex`       VARCHAR(255)      NULL     DEFAULT NULL,
    `filtering_category_id` BIGINT UNSIGNED   NULL     DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY subscriptions_event_type_index (event_type_id) REFERENCES glpi_plugin_taigaconnector_eventtypes (id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `glpi_plugin_taigaconnector_contents`
(
    `id`            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `event_type_id` BIGINT UNSIGNED NOT NULL,
    `content`       TEXT            NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY trigger_history_event_type_index (event_type_id) REFERENCES glpi_plugin_taigaconnector_eventtypes (id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `glpi_plugin_taigaconnector_messages`
(
    `id`               BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT,
    `subscription_id`  BIGINT UNSIGNED  NOT NULL,
    `content_id`       BIGINT UNSIGNED  NOT NULL,
    `url`              VARCHAR(255)     NOT NULL DEFAULT '',
    `called_at`        TIMESTAMP        NOT NULL DEFAULT NOW(),
    `response_status`  SMALLINT UNSIGNED         DEFAULT NULL,
    `response_content` TEXT                      DEFAULT NULL,
    `attempt`          TINYINT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY message_history_webhook_index (subscription_id) REFERENCES glpi_plugin_taigaconnector_subscriptions (id) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY message_history_trigger_index (content_id) REFERENCES glpi_plugin_taigaconnector_contents (id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `glpi_plugin_taigaconnector_queue`
(
    `id`               BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT,
    `subscription_id`  BIGINT UNSIGNED  NOT NULL,
    `content_id`       BIGINT UNSIGNED  NOT NULL,
    `created_at`       TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`       TIMESTAMP        NULL     DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `response_status`  INT UNSIGNED              DEFAULT NULL,
    `response_content` TEXT                      DEFAULT NULL,
    `attempts`         TINYINT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    FOREIGN KEY queue_webhook_index (subscription_id) REFERENCES glpi_plugin_taigaconnector_subscriptions (id) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY queue_trigger_index (content_id) REFERENCES glpi_plugin_taigaconnector_contents (id) ON UPDATE CASCADE ON DELETE RESTRICT

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
