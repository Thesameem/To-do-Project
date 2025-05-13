<script setup>


    let emits = defineEmits(['close']);

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
            <div class="add-btnion">
                <img src="./../images/mark-read.svg" style="margin-right: 5px; width: 20px; height: 20px;">
                <p>Mark all as read</p>
            </div>
        </div>
    </div>

    <div class="notification-content">
        <ul class="notifications">
            <li class="unread">
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