// vue notification toast
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

export const ShowToast = (text, position) => {
    const toast = useToast();
    toast.success(text, {
        position: position,
    });
};