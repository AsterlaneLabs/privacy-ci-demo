<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * An older table that arrived as a SQL dump rather than a Blueprint. Plenty of
 * long-lived applications carry at least one of these.
 */
return new class extends Migration
{
    public function up(): void
    {
        // The MySQL dump this table originally shipped as. SQLite will not run
        // it, so the demo creates an equivalent table there instead. The scanner
        // reads whichever statement is in the file, not the database.
        if (DB::getDriverName() === 'sqlite') {
            DB::statement("CREATE TABLE `legacy_profiles` (
              `profile_id` integer PRIMARY KEY AUTOINCREMENT NOT NULL,
              `user_id` integer NOT NULL,
              `phone` varchar DEFAULT NULL,
              `date_of_birth` date DEFAULT NULL,
              `status` varchar NOT NULL DEFAULT 'active',
              `notes` text,
              FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
            );");

            return;
        }

        DB::statement("CREATE TABLE `legacy_profiles` (
          `profile_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `user_id` int(10) unsigned NOT NULL,
          `phone` varchar(32) DEFAULT NULL,
          `date_of_birth` date DEFAULT NULL,
          `status` enum('active','dormant','pending removal') NOT NULL DEFAULT 'active',
          `notes` text,
          PRIMARY KEY (`profile_id`),
          CONSTRAINT `fk_profiles_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
        ) ENGINE=InnoDB;");
    }

    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS `legacy_profiles`;');
    }
};
