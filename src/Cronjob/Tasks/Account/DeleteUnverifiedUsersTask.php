<?php

namespace A11yBuddy\Cronjob\Tasks\Account;

use A11yBuddy\Application;
use A11yBuddy\Cronjob\CronjobTask;

/**
 * Deletes all users that have not verified their email address within 24 hours.
 */
class DeleteUnverifiedUsersTask extends CronjobTask
{

    public function canRun(): bool
    {
        // Run this only once per hour
        return $this->plannedTimestamp % 3600 === 0;
    }

    public function run(): void
    {
        $db = Application::getInstance()->getDatabase();

        $result = $db->query('SELECT id FROM users WHERE status = 0 AND created_at < :time', [':time' => time() - 24 * 60 * 60]);

        $users = $result->fetchAll(\PDO::FETCH_ASSOC);
        // Delete all users
        foreach ($users as $user) {
            $db->query('DELETE FROM users WHERE id = :id', [':id' => $user['id']]);
        }
    }

}