<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotificationModel;

class Notifications extends BaseController
{
    public function get()
    {
        if (!session()->get('isAuthenticated')) {
            return $this->response->setJSON(['error' => 'Unauthorized'], 401);
        }

        $userId = session()->get('userId');
        $notificationModel = new NotificationModel();

        $unreadCount = $notificationModel->getUnreadCount($userId);
        $notifications = $notificationModel->getNotificationsForUser($userId);

        return $this->response->setJSON([
            'unreadCount' => $unreadCount,
            'notifications' => $notifications
        ]);
    }

    public function mark_as_read($id)
    {
        if (!session()->get('isAuthenticated')) {
            return $this->response->setJSON(['error' => 'Unauthorized'], 401);
        }

        $notificationModel = new NotificationModel();
        $success = $notificationModel->markAsRead($id);

        if ($success) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['error' => 'Failed to mark as read'], 400);
        }
    }
}
