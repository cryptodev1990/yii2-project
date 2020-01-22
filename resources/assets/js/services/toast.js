import UIKit from 'uikit';

/**
 * Service to show toasts
 */
export default class Toast {
    /**
     * Error notification
     * @param message
     */
    static error(message) {
        return UIKit.notification({
            message: message,
            status: 'danger',
            pos: 'top-center',
            timeout: 3500,
        });
    }

    /**
     * Successful notification
     * @param message
     */
    static success(message) {
        return UIKit.notification({
            message: message,
            status: 'success',
            pos: 'top-center',
            timeout: 3500,
        });
    }
}
