/*
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

import 'izitoast/dist/css/iziToast.min.css';
import iZtoast from 'izitoast';

/**
 * Service to show toasts
 */
export default class Toast {
    /**
     * Error notification
     * @param message
     */
    static error(message) {
        return iZtoast.error({
            message: message,
            position: 'topCenter',
            animateInside: false,
            pauseOnHover: false,
            timeout: 3500,
        });
    }

    /**
     * Successful notification
     * @param message
     */
    static success(message) {
        return iZtoast.success({
            message: message,
            position: 'topCenter',
            animateInside: false,
            pauseOnHover: false,
            timeout: 3500,
        });
    }
}
