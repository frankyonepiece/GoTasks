import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const $toast = useToast({
    position: 'top-right',
    dismissible: true,
    duration: 2000,
});

export default class Notify {
    static success(msg: string) {
        $toast.success(msg);
    }

    static error(msg: string) {
        $toast.error(msg);
    }
}
