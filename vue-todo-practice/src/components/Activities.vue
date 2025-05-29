<script setup>
    
    import { onMounted, ref } from 'vue';
    import { GET } from '@/scripts/Fetch';
    import { useTodoStore } from '@/stores/Todo';

    import { ShowToast } from '@/scripts/Toast';

    // pinia store
    let TodoStore = useTodoStore();

    // data to emit from this Component
    // this will close the activities model
    let emits = defineEmits(['close']);

    // activities and loading stuff
    let Activities = ref([]);
    let isLoading = ref(true);

    // this function will mark all activities as read
    // from store and from database as well
    const MarkAllNotification = async () => {
        TodoStore.Activities.map(activity => {
            activity.unread = false;
            return activity;
        });

        Activities.value = TodoStore.Activities;
        TodoStore.UnreadActivities = 0;

        let result = await GET('activities/read');

        // finally show the toast to user
        ShowToast('Marked all as read', 'top');

    }

    // filter only unread activities
    const ShowUnread = () => {
        Activities.value = Activities.value.filter(activity => {
            if (activity.unread) return true;
        });
    }

    const FormatedDate = (date) => {
        let months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        let newDate = new Date(date);

        let year = newDate.getFullYear();
        let month = months[newDate.getMonth()];
        let today = newDate.getDate();


        return `${year} ${month} ${today}`;
    }

    // load all activities of current user
    onMounted(async () => {
        let result = await GET('activities');
        isLoading.value = false;

        if (!result.error) {
            TodoStore.Activities = result.response;
            Activities.value = result.response;
        }
    });

</script>

<template>
    <span class="close" @click="emits('close')">
        <img src="./../images/close.svg" alt="">
    </span>

    <div class="dash-header">
        <div class="actions">
            <div class="actbtn" style="margin-right: 7px;" @click="Activities = TodoStore.Activities">
                <p>All</p>
            </div>
            <div class="actbtn" @click="ShowUnread">
                <p>Unread</p>
            </div>
        </div>
                    
        <div class="addition">
            <div class="add-btnion" @click="MarkAllNotification">
                <img src="./../images/mark-read.svg" style="margin-right: 5px; width: 20px; height: 20px;">
                <p>Mark all as read</p>
            </div>
        </div>
    </div>

    <div class="notification-content">
        <div class="loader" v-if="isLoading">
            <img src="./../images/loader2.gif" alt="">
        </div>
        
        <ul v-else class="notifications">
            <li :class="activity.unread ? 'unread' : ''" v-for="activity in Activities" :key="activity.id">
                <div class="image">
                    <div class="noticon">
                        <img src="./../images/notify-fill.svg">
                    </div>
                </div>
                <div class="content">
                    <p v-html="activity.detail"></p>
                    <span>
                        <img src="./../images/time.svg">
                        <p>{{ FormatedDate(activity.created_at) }}</p>
                    </span>
                </div>
            </li>      
        </ul>
    </div>

    <div class="empty-task" v-if="Activities.length <= 0 && isLoading == false">
        <img src="./../images/empty-task.svg">
        <p>Nice! You are all caught up.</p>
    </div>


</template>