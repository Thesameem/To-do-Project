<script setup>

    import { onMounted , ref } from 'vue';
    import { useTodoStore } from '@/stores/Todo';
import { GET } from '@/scripts/Fetch';


    let emits = defineEmits(['close']);

    //pinia store
    let TodoStore =useTodoStore();

    let isLoading =ref(true);

    const MarkAllNotification=async()=>{
        TodoStore.Activities.map(activity=>{
            activity.unread = false;
            return activity;
        });

        let result= await GET('activities/read');

    }

    onMounted(async()=>{
        let result = await GET('activities');
        isLoading.value=false;

        if(!result.error){
            TodoStore.Activities = result.response;
        };
        
    });

</script>

<template>
    <span class="close" @click="emits('close')">
        <img src="./../images/close.svg" alt="">
    </span>

    <div class="dash-header">
        <div class="actions">
            <div class="actbtn" style="margin-right: 7px;">
            <p>All</p>
            </div>
            <div class="actbtn">
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
            <li class="activity.unread ? 'unread' : ''" v-for="activity in TodoStore.Activities" :key="activity.id">
                <div class="image">
                    <div class="noticon">
                        <img src="./../images/notify-fill.svg">
                    </div>
                </div>
                <div class="content">
                    <p>You have successfully added new task 'task name goes here'</p>
                    <span>
                        <img src="./../images/time.svg">
                        <p>April 9, 2025 . 3 weeks ago</p>
                    </span>
                </div>
            </li>    
            
            <li>
                <div class="image">
                    <div class="noticon">
                        <img src="./../images/notify-fill.svg">
                    </div>
                </div>
                <div class="content">
                    <p>You have successfully updated the task 'task name goes here'</p>
                    <span>
                        <img src="./../images/time.svg">
                        <p>April 9, 2025 . 3 weeks ago</p>
                    </span>
                </div>
            </li>    
        </ul>
    </div>

    <div class="empty-task" style="display: none;">
        <img src="./../images/empty-task.svg">
        <p>Nice! You are all caught up.</p>
    </div>


</template>

<style scoped>


</style>